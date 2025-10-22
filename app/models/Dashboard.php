<?php
namespace App\Models;

use Core\Model;

class Dashboard extends Model {
    /**
     * Get overview statistics for the dashboard
     * @return array Array of statistics
     */
    public function getStats(): array {
        try {
            // Get announcements count
            $announcementsSql = "SELECT COUNT(*) as count FROM announcements";
            $announcementsStmt = $this->db->prepare($announcementsSql);
            $announcementsStmt->execute();
            $announcements = $announcementsStmt->fetch(\PDO::FETCH_ASSOC)['count'];

            // Get contact submissions count
            $contactsSql = "SELECT COUNT(*) as count FROM contact_submissions WHERE status = 'pending'";
            $contactsStmt = $this->db->prepare($contactsSql);
            $contactsStmt->execute();
            $pendingContacts = $contactsStmt->fetch(\PDO::FETCH_ASSOC)['count'];

            // Get digital resources count
            $resourcesSql = "SELECT 
                SUM(CASE WHEN category = 'ebook' THEN 1 ELSE 0 END) as ebooks,
                SUM(CASE WHEN category = 'ejournal' THEN 1 ELSE 0 END) as ejournals
                FROM digital_resources";
            $resourcesStmt = $this->db->prepare($resourcesSql);
            $resourcesStmt->execute();
            $resources = $resourcesStmt->fetch(\PDO::FETCH_ASSOC);

            // Get total databases count
            $databasesSql = "SELECT COUNT(*) as count FROM databases";
            $databasesStmt = $this->db->prepare($databasesSql);
            $databasesStmt->execute();
            $databases = $databasesStmt->fetch(\PDO::FETCH_ASSOC)['count'];

            return [
                'announcements' => $announcements,
                'pending_contacts' => $pendingContacts,
                'ebooks' => $resources['ebooks'] ?? 0,
                'ejournals' => $resources['ejournals'] ?? 0,
                'databases' => $databases
            ];
        } catch (\PDOException $e) {
            // Log error and return empty stats
            error_log("Error fetching dashboard stats: " . $e->getMessage());
            return [
                'announcements' => 0,
                'pending_contacts' => 0,
                'ebooks' => 0,
                'ejournals' => 0,
                'databases' => 0
            ];
        }
    }

    /**
     * Get recent activities for the dashboard
     * @param int $limit Number of items to return
     * @return array Array of recent activities
     */
    public function getRecentActivity(int $limit = 5): array {
        try {
            // Get recent announcements
            $announcementsSql = "SELECT 
                'announcement' as type,
                title as item_title,
                date_posted as date,
                'Added new announcement' as action
                FROM announcements 
                ORDER BY date_posted DESC 
                LIMIT ?";
            $announcementsStmt = $this->db->prepare($announcementsSql);
            $announcementsStmt->execute([$limit]);
            $announcements = $announcementsStmt->fetchAll(\PDO::FETCH_ASSOC);

            // Get recent contact submissions
            $contactsSql = "SELECT 
                'contact' as type,
                subject as item_title,
                submitted_at as date,
                'New contact submission' as action
                FROM contact_submissions 
                ORDER BY submitted_at DESC 
                LIMIT ?";
            $contactsStmt = $this->db->prepare($contactsSql);
            $contactsStmt->execute([$limit]);
            $contacts = $contactsStmt->fetchAll(\PDO::FETCH_ASSOC);

            // Combine and sort by date
            $activities = array_merge($announcements, $contacts);
            usort($activities, function($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });

            // Return only the latest $limit items
            return array_slice($activities, 0, $limit);
        } catch (\PDOException $e) {
            // Log error and return empty array
            error_log("Error fetching recent activity: " . $e->getMessage());
            return [];
        }
    }
}