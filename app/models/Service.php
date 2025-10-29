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
     * Get all services for admin panel
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
     *
     * @return array Array of active services
     */
    public function getAllActiveServices() {
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
     */
    public function createService($data) {
        $sql = "INSERT INTO services (title, description, category, icon_class, display_order, is_active) 
                VALUES (:title, :description, :category, :icon_class, :display_order, :is_active)";
        $stmt = $this->getDB()->prepare($sql);
        return $stmt->execute([
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'] ?? '',
            'icon_class' => $data['icon_class'] ?? '',
            'display_order' => $data['display_order'] ?? 0,
            'is_active' => isset($data['is_active']) ? 1 : 0
        ]);
    }

    /**
     * Update an existing service
     *
     * @param int $id Service ID
     * @param array $data Updated service data
     * @return bool Success status
     */
    public function updateService($id, $data): bool {
        try {
            // Validate ID
            if (!is_numeric($id) || $id <= 0) {
                throw new \InvalidArgumentException("Invalid service ID provided: {$id}");
            }

            // Log request data
            error_log("Update service request for ID {$id}");
            error_log("Raw input data: " . print_r($data, true));

            // Validate required fields
            if (empty($data['title'])) {
                throw new \InvalidArgumentException("Title is required");
            }
            if (empty($data['description'])) {
                throw new \InvalidArgumentException("Description is required");
            }

            // Check if service exists
            $sql = "SELECT id FROM services WHERE id = :id";
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute(['id' => $id]);
            if (!$stmt->fetch(\PDO::FETCH_ASSOC)) {
                throw new \InvalidArgumentException("Service with ID {$id} not found");
            }

            // Prepare update data with careful type handling
            $updateData = [
                'title' => trim($data['title']),
                'description' => trim($data['description']),
                'category' => !empty($data['category']) ? trim($data['category']) : '',
                'icon_class' => !empty($data['icon_class']) ? trim($data['icon_class']) : '',
                'display_order' => is_numeric($data['display_order']) ? intval($data['display_order']) : 0,
                'is_active' => isset($data['is_active']) ? 1 : 0
            ];

            // Log prepared data
            error_log("Prepared update data: " . print_r($updateData, true));

            // Build and execute update query directly
            $sql = "UPDATE services SET 
                    title = :title,
                    description = :description,
                    category = :category,
                    icon_class = :icon_class,
                    display_order = :display_order,
                    is_active = :is_active
                   WHERE id = :id";

            $stmt = $this->getDB()->prepare($sql);
            $updateData['id'] = $id; // Add ID to parameters
            
            error_log("Executing SQL: " . $sql);
            error_log("Parameters: " . print_r($updateData, true));

            if (!$stmt->execute($updateData)) {
                $error = $stmt->errorInfo();
                error_log("SQL Error: " . print_r($error, true));
                throw new \PDOException("Failed to update service: " . $error[2]);
            }

            $affectedRows = $stmt->rowCount();
            error_log("Update affected {$affectedRows} rows");

            return $affectedRows > 0;

        } catch (\PDOException $e) {
            error_log("Database error updating service {$id}: " . $e->getMessage());
            if ($e->errorInfo) {
                error_log("SQL State: " . $e->errorInfo[0]);
                error_log("Driver Error Code: " . $e->errorInfo[1]);
                error_log("Driver Error Message: " . $e->errorInfo[2]);
            }
            throw $e;
        } catch (\Exception $e) {
            error_log("Error updating service {$id}: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Delete a service (soft delete by setting is_active to 0)
     *
     * @param int $id Service ID
     * @return bool Success status
     */
    public function deleteService($id) {
        $sql = "DELETE FROM services WHERE id = :id";
        $stmt = $this->getDB()->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}