<?php
/**
 * Policy.php
 * Handles library policies data operations
 */

namespace App\Models;

use Core\Model;
use PDO;

class Policy extends Model {
    /**
     * Table name for this model
     * @var string
     */
    protected $table = 'policies';

    /**
     * Get all active policies ordered by display order and grouped by category
     *
     * @return array Array of policies grouped by category
     */
    public function getAllPolicies() {
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
     * Get a specific policy by ID
     *
     * @param int $id Policy ID
     * @return array|false Policy data or false if not found
     */
    public function getPolicyById($id) {
        $sql = "SELECT * FROM policies WHERE id = :id AND is_active = 1";
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