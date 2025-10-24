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
                'pending_contacts' => $pendingContacts,
                'ebooks' => $resources['ebooks'] ?? 0,
                'ejournals' => $resources['ejournals'] ?? 0,
                'databases' => $databases
            ];
        } catch (\PDOException $e) {
            // Log error and return empty stats
            error_log("Error fetching dashboard stats: " . $e->getMessage());
            return [
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

            // Sort contacts by date
            usort($contacts, function($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });

            // Return only the latest $limit items
            return array_slice($contacts, 0, $limit);
        } catch (\PDOException $e) {
            // Log error and return empty array
            error_log("Error fetching recent activity: " . $e->getMessage());
            return [];
        }
    }
}