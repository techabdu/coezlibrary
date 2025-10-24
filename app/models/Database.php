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
     * Get all database links ordered by name
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

    /**
     * Get a database by ID
     *
     * @param int $id Database ID
     * @return array|false Database data or false if not found
     */
    public function getDatabaseById($id) {
        $sql = "SELECT * FROM external_databases WHERE id = :id";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new database entry
     *
     * @param array $data Database data (name, description, url, category, icon_path)
     * @return int Last insert ID
     * @throws \InvalidArgumentException If validation fails
     * @throws \Exception If database error occurs
     */
    public function create(array $data): int {
        // Validate required fields
        if (empty($data['name']) || empty($data['url'])) {
            throw new \InvalidArgumentException("Name and URL are required fields");
        }

        // Validate URL format
        if (!filter_var($data['url'], FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("Invalid URL format");
        }

        try {
            $sql = "INSERT INTO external_databases (name, description, url, category, icon_path) 
                    VALUES (:name, :description, :url, :category, :icon_path)";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute([
                'name' => htmlspecialchars($data['name']),
                'description' => htmlspecialchars($data['description'] ?? ''),
                'url' => $data['url'],
                'category' => htmlspecialchars($data['category'] ?? ''),
                'icon_path' => $data['icon_path'] ?? null
            ]);

            return (int)$this->getDB()->lastInsertId();
        } catch (\PDOException $e) {
            error_log("Error creating database entry: " . $e->getMessage());
            throw new \Exception("Database error occurred while creating entry");
        }
    }

    /**
     * Update a database entry
     *
     * @param int $id Database ID
     * @param array $data Database data to update
     * @return bool True on success
     * @throws \InvalidArgumentException If validation fails
     * @throws \Exception If database error occurs
     */
    public function update(int $id, array $data): bool {
        // Validate required fields
        if (empty($data['name']) || empty($data['url'])) {
            throw new \InvalidArgumentException("Name and URL are required fields");
        }

        // Validate URL format
        if (!filter_var($data['url'], FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("Invalid URL format");
        }

        try {
            $sql = "UPDATE external_databases 
                    SET name = :name, description = :description, url = :url,
                        category = :category, icon_path = :icon_path
                    WHERE id = :id";

            $stmt = $this->getDB()->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'name' => htmlspecialchars($data['name']),
                'description' => htmlspecialchars($data['description'] ?? ''),
                'url' => $data['url'],
                'category' => htmlspecialchars($data['category'] ?? ''),
                'icon_path' => $data['icon_path'] ?? null
            ]);
        } catch (\PDOException $e) {
            error_log("Error updating database entry: " . $e->getMessage());
            throw new \Exception("Database error occurred while updating entry");
        }
    }

    /**
     * Delete a database entry
     *
     * @param int $id Database ID
     * @return bool True on success
     * @throws \Exception If database error occurs
     */
    public function delete(int $id): bool {
        try {
            $sql = "DELETE FROM external_databases WHERE id = :id";
            $stmt = $this->getDB()->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (\PDOException $e) {
            error_log("Error deleting database entry: " . $e->getMessage());
            throw new \Exception("Database error occurred while deleting entry");
        }
    }
}