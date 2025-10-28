<?php
namespace App\Models;

use Core\Model;

class Dashboard extends Model {
    /**
     * Get overview statistics for the dashboard
     * @return array Array of statistics
     */
    public function getStats(): array {
        $stats = [
            'pending_contacts' => 0
        ];

        try {
            // Get pending contact submissions count
            $contactsSql = "SELECT COUNT(*) as count FROM contact_submissions WHERE status = 'pending'";
            $contactsStmt = $this->getDB()->prepare($contactsSql);
            $contactsStmt->execute();
            $stats['pending_contacts'] = $contactsStmt->fetch(\PDO::FETCH_ASSOC)['count'];
        } catch (\PDOException $e) {
            error_log("Error fetching contact submissions count: " . $e->getMessage());
        }

        return $stats;
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
            $contactsStmt = $this->getDB()->prepare($contactsSql);
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