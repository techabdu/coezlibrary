<?php
/**
 * Service.php
 * Handles library services data operations
 */

namespace App\Models;

use Core\Model;
use PDO;

class Service extends Model {
    /**
     * Table name for this model
     * @var string
     */
    protected $table = 'services';
    /**
     * Get all active services ordered by display order
     *
     * @return array Array of services
     */
    public function getAllServices() {
        $sql = "SELECT * FROM services WHERE is_active = 1 ORDER BY display_order ASC";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a specific service by ID
     *
     * @param int $id Service ID
     * @return array|false Service data or false if not found
     */
    public function getServiceById($id) {
        $sql = "SELECT * FROM services WHERE id = :id AND is_active = 1";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new service
     *
     * @param array $data Service data
     * @return bool Success status
     */
    public function createService($data) {
        $sql = "INSERT INTO services (title, description, icon, display_order) 
                VALUES (:title, :description, :icon, :display_order)";
        $stmt = $this->getDB()->prepare($sql);
        return $stmt->execute([
            'title' => $data['title'],
            'description' => $data['description'],
            'icon' => $data['icon'],
            'display_order' => $data['display_order']
        ]);
    }

    /**
     * Update an existing service
     *
     * @param int $id Service ID
     * @param array $data Updated service data
     * @return bool Success status
     */
    public function updateService($id, $data) {
        $sql = "UPDATE services 
                SET title = :title, 
                    description = :description, 
                    icon = :icon, 
                    display_order = :display_order,
                    is_active = :is_active
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'description' => $data['description'],
            'icon' => $data['icon'],
            'display_order' => $data['display_order'],
            'is_active' => $data['is_active']
        ]);
    }

    /**
     * Delete a service (soft delete by setting is_active to 0)
     *
     * @param int $id Service ID
     * @return bool Success status
     */
    public function deleteService($id) {
        $sql = "UPDATE services SET is_active = 0 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}