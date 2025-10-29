<?php
/**
 * Policy.php
 * Handles library policies data operations
 */

namespace App\Models;

use Core\Model;
use PDO;

class Policy extends Model {
    protected $table = 'policies';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all policies ordered by display order
     *
     * @return array Array of all policies
     */
    public function getAllPolicies() {
        $sql = "SELECT * FROM policies ORDER BY display_order ASC";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get all active policies ordered by display order and grouped by category
     *
     * @return array Array of policies grouped by category
     */
    public function getAllActivePolicies() {
        $sql = "SELECT * FROM policies WHERE is_active = 1 ORDER BY category, display_order ASC";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute();
        
        // Group policies by category
        $policies = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $policy) {
            $policies[$policy['category']][] = $policy;
        }
        return $policies;
    }

    /**
     * Create a new policy
     *
     * @param array $data Policy data
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function create(array $data): int {
        if (empty($data['title']) || empty($data['content']) || empty($data['category'])) {
            throw new \InvalidArgumentException('Title, content, and category are required');
        }

        return parent::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'category' => $data['category'],
            'display_order' => $data['display_order'] ?? 0,
            'is_active' => isset($data['is_active']) ? 1 : 0
        ]);
    }

    /**
     * Update an existing policy
     *
     * @param int $id
     * @param array $data Updated policy data
     * @return bool
     * @throws \InvalidArgumentException|\Exception
     */
    public function update(int $id, array $data): bool {
        try {
            // Validate required fields
            if (empty($data['title'])) {
                throw new \InvalidArgumentException('Title is required');
            }
            if (empty($data['content'])) {
                throw new \InvalidArgumentException('Content is required');
            }
            if (empty($data['category'])) {
                throw new \InvalidArgumentException('Category is required');
            }

            // Sanitize and prepare data
            $updateData = [
                'title' => trim($data['title']),
                'content' => trim($data['content']),
                'category' => trim($data['category']),
                'display_order' => isset($data['display_order']) ? intval($data['display_order']) : 0,
                'is_active' => isset($data['is_active']) ? 1 : 0
            ];

            // Let the parent Model class handle existence check and update
            if (!parent::update($id, $updateData)) {
                throw new \Exception('Failed to update policy');
            }

            return true;
        } catch (\InvalidArgumentException $e) {
            error_log("Validation error updating policy: " . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            error_log("Error updating policy: " . $e->getMessage());
            throw new \Exception('Error updating policy: ' . $e->getMessage());
        }
    }    /**
     * Delete a policy
     *
     * @param int $id Policy ID
     * @return bool
     */
    public function delete(int $id): bool {
        try {
            // Let the parent Model class handle existence check
            return parent::delete($id);
        } catch (\Exception $e) {
            error_log("Error deleting policy: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get a specific policy by ID
     *
     * @param int $id Policy ID
     * @return array|false Policy data or false if not found
     */
    public function getPolicyById($id) {
        $sql = "SELECT * FROM policies WHERE id = :id";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get all policy categories
     *
     * @return array Array of unique categories
     */
    public function getAllCategories() {
        $sql = "SELECT DISTINCT category FROM policies WHERE is_active = 1 ORDER BY category";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}