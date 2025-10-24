<?php
/**
 * Base Model Class
 * Handles database connections and common model operations
 */

namespace Core;

use PDO;
use PDOException;

class Model {
    protected static $db = null;
    protected $table;

    /**
     * Initialize database connection
     */
    public function __construct() {
        if (self::$db === null) {
            try {
                $config = require CONFIG_PATH . '/database.php';
                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
                self::$db = new PDO($dsn, $config['username'], $config['password'], $config['options']);
            } catch (PDOException $e) {
                error_log("Database Connection Error: " . $e->getMessage());
                throw new \Exception("Database connection failed");
            }
        }
    }

    /**
     * Get database connection instance
     * @return PDO
     */
    protected function getDB(): PDO {
        return self::$db;
    }

    /**
     * Find all records in the table
     * @param array $conditions Optional WHERE conditions
     * @return array
     */
    public function findAll(array $conditions = []): array {
        try {
            $sql = "SELECT * FROM {$this->table}";
            
            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $whereClauses = [];
                foreach ($conditions as $key => $value) {
                    $whereClauses[] = "$key = :$key";
                }
                $sql .= implode(" AND ", $whereClauses);
            }

            $stmt = $this->getDB()->prepare($sql);
            
            if (!empty($conditions)) {
                foreach ($conditions as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }
            }

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database Query Error: " . $e->getMessage());
            throw new \Exception("Error retrieving records");
        }
    }

    /**
     * Find a single record by ID
     * @param int $id
     * @return array|false
     */
    public function findById(int $id) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
            $stmt = $this->getDB()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Database Query Error: " . $e->getMessage());
            throw new \Exception("Error retrieving record");
        }
    }

    /**
     * Create a new record
     * @param array $data
     * @return int|false Last insert ID or false on failure
     */
    public function create(array $data): int {
        try {
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            $stmt = $this->getDB()->prepare($sql);
            
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            $stmt->execute();
            return (int)$this->getDB()->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database Insert Error: " . $e->getMessage());
            throw new \Exception("Error creating record");
        }
    }

    /**
     * Update a record
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool {
        try {
            $setClauses = [];
            foreach ($data as $key => $value) {
                $setClauses[] = "$key = :$key";
            }
            
            $sql = "UPDATE {$this->table} SET " . implode(', ', $setClauses) . " WHERE id = :id";
            $stmt = $this->getDB()->prepare($sql);
            
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Update Error: " . $e->getMessage());
            throw new \Exception("Error updating record");
        }
    }

    /**
     * Delete a record
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->getDB()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Delete Error: " . $e->getMessage());
            throw new \Exception("Error deleting record");
        }
    }
}