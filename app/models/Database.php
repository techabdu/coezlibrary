<?php
/**
 * Database.php
 * Handles external database links data operations
 */

namespace App\Models;

use Core\Model;
use PDO;

class Database extends Model {
    /**
     * Table name for this model
     * @var string
     */
    protected $table = 'external_databases';

    /**
     * Get all active database links ordered by name
     *
     * @return array Array of database links
     */
    public function getAllDatabases() {
        $sql = "SELECT * FROM external_databases ORDER BY name ASC";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get databases filtered by category
     *
     * @param string $category The category to filter by
     * @return array Array of database links in the specified category
     */
    public function getDatabasesByCategory($category) {
        $sql = "SELECT * FROM external_databases WHERE category = :category ORDER BY name ASC";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute(['category' => $category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all unique categories
     *
     * @return array Array of unique categories
     */
    public function getAllCategories() {
        $sql = "SELECT DISTINCT category FROM external_databases WHERE category IS NOT NULL ORDER BY category ASC";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}