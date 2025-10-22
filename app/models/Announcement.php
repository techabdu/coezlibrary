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
    public function getById(int $id) {
        try {
            $sql = "SELECT id, title, content, date_posted, is_active, created_at 
                   FROM announcements 
                   WHERE id = :id";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in Announcement->getById(): " . $e->getMessage());
            throw new Exception('Failed to fetch announcement');
        }
    }

    /**
     * Get all announcements for admin management
     * 
     * @return array Array of all announcements
     */
    public function getAllAnnouncements() {
        try {
            $sql = "SELECT id, title, content, date_posted, is_active, created_at 
                   FROM announcements 
                   ORDER BY date_posted DESC, created_at DESC";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in Announcement->getAllAnnouncements(): " . $e->getMessage());
            throw new Exception('Failed to fetch announcements');
        }
    }

    /**
     * Create a new announcement
     * 
     * @param array $data Announcement data
     * @return int ID of the created announcement
     */
    public function create(array $data): int {
        try {
            $sql = "INSERT INTO announcements (title, content, date_posted, is_active) 
                   VALUES (:title, :content, :date_posted, :is_active)";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindValue(':content', $data['content'], PDO::PARAM_STR);
            $stmt->bindValue(':date_posted', $data['date_posted'], PDO::PARAM_STR);
            $stmt->bindValue(':is_active', $data['is_active'], PDO::PARAM_INT);
            $stmt->execute();
            
            return $this->getDB()->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error in Announcement->create(): " . $e->getMessage());
            throw new Exception('Failed to create announcement');
        }
    }

    /**
     * Update an existing announcement
     * 
     * @param int $id Announcement ID
     * @param array $data Updated announcement data
     * @return bool Success status
     */
    public function update(int $id, array $data): bool {
        try {
            $sql = "UPDATE announcements 
                   SET title = :title, 
                       content = :content, 
                       date_posted = :date_posted, 
                       is_active = :is_active 
                   WHERE id = :id";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindValue(':content', $data['content'], PDO::PARAM_STR);
            $stmt->bindValue(':date_posted', $data['date_posted'], PDO::PARAM_STR);
            $stmt->bindValue(':is_active', $data['is_active'], PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in Announcement->update(): " . $e->getMessage());
            throw new Exception('Failed to update announcement');
        }
    }

    /**
     * Delete an announcement
     * 
     * @param int $id Announcement ID
     * @return bool Success status
     */
    public function delete(int $id): bool {
        try {
            $sql = "DELETE FROM announcements WHERE id = :id";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in Announcement->delete(): " . $e->getMessage());
            throw new Exception('Failed to delete announcement');
        }
    }

    /**
     * Toggle announcement active status
     * 
     * @param int $id Announcement ID
     * @return bool Success status
     */
    public function toggleStatus(int $id): bool {
        try {
            $sql = "UPDATE announcements 
                   SET is_active = NOT is_active 
                   WHERE id = :id";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in Announcement->toggleStatus(): " . $e->getMessage());
            throw new Exception('Failed to toggle announcement status');
        }
    }
}