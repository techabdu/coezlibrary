<?php
/**
 * Announcement.php
 * Model for handling announcements data and operations
 */

namespace App\Models;

use Core\Model;
use PDO;
use PDOException;
use Exception;

class Announcement extends Model {
    protected $table = 'announcements';
    /**
     * Get the latest active announcements
     * 
     * @param int $limit Number of announcements to return (default: 5)
     * @return array Array of announcements
     */
    public function getActiveAnnouncements($limit = 5) {
        try {
            $sql = "SELECT id, title, content, date_posted, created_at 
                   FROM announcements 
                   WHERE is_active = 1 
                   ORDER BY date_posted DESC, created_at DESC 
                   LIMIT :limit";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in Announcement->getActiveAnnouncements(): " . $e->getMessage());
            throw new Exception('Failed to fetch announcements');
        }
    }

    /**
     * Get a single announcement by ID
     * 
     * @param int $id Announcement ID
     * @return array|false Announcement data or false if not found
     */
    public function getAnnouncementById($id) {
        try {
            $sql = "SELECT id, title, content, date_posted, created_at 
                   FROM announcements 
                   WHERE id = :id AND is_active = 1";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in Announcement->getAnnouncementById(): " . $e->getMessage());
            throw new Exception('Failed to fetch announcement');
        }
    }
}