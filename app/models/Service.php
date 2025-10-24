<?php
/**
 * Service.php
 * Handles library services data operations
 */

namespace App\Models;

use Core\Model;
use PDO;
use InvalidArgumentException;

class Service extends Model {
    /**
     * Table name for this model
     * @var string
     */
    protected $table = 'services';

    /**
     * Get all services including inactive ones, ordered by display order
     * Used in admin panel
     *
     * @return array Array of all services
     */
    public function getAllServices() {
        $sql = "SELECT * FROM services ORDER BY display_order ASC";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all active services ordered by display order
     * Used in frontend
     *
     * @return array Array of active services
     */
    public function getActiveServices() {
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
        $sql = "SELECT * FROM services WHERE id = :id";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new service
     *
     * @param array $data Service data
     * @return bool Success status
     * @throws InvalidArgumentException If validation fails
     */
    public function createService($data) {
        // Validate required fields
        $this->validateServiceData($data);

        $sql = "INSERT INTO services (title, description, icon, display_order, is_active) 
                VALUES (:title, :description, :icon, :display_order, :is_active)";
        $stmt = $this->getDB()->prepare($sql);
        return $stmt->execute([
            'title' => $data['title'],
            'description' => $data['description'],
            'icon' => $data['icon'],
            'display_order' => $data['display_order'],
            'is_active' => $data['is_active']
        ]);
    }

    /**
     * Update an existing service
     *
     * @param int $id Service ID
     * @param array $data Updated service data
     * @return bool Success status
     * @throws InvalidArgumentException If validation fails
     */
    public function updateService($id, $data) {
        // Validate required fields
        $this->validateServiceData($data);

        // Check if service exists
        if (!$this->getServiceById($id)) {
            throw new InvalidArgumentException('Service not found');
        }

        $sql = "UPDATE services 
                SET title = :title, 
                    description = :description, 
                    icon = :icon, 
                    display_order = :display_order,
                    is_active = :is_active
                WHERE id = :id";
        
        $stmt = $this->getDB()->prepare($sql);
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
     * @throws InvalidArgumentException If service not found
     */
    public function deleteService($id) {
        // Check if service exists
        if (!$this->getServiceById($id)) {
            throw new InvalidArgumentException('Service not found');
        }

        $sql = "UPDATE services SET is_active = 0 WHERE id = :id";
        $stmt = $this->getDB()->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Validate service data
     *
     * @param array $data Service data to validate
     * @throws InvalidArgumentException If validation fails
     */
    private function validateServiceData($data) {
        if (empty($data['title'])) {
            throw new InvalidArgumentException('Service title is required');
        }

        if (empty($data['description'])) {
            throw new InvalidArgumentException('Service description is required');
        }

        if (empty($data['icon'])) {
            throw new InvalidArgumentException('Service icon is required');
        }

        if (!is_numeric($data['display_order'])) {
            throw new InvalidArgumentException('Display order must be a number');
        }
    }
}