<?php
/**
 * Base Model Class
 * Handles database connections and common model operations with enhanced security
 */

namespace Core;

use PDO;
use PDOException;
use Core\QueryBuilder;
use Core\Security;

class Model {
    protected static $db = null;
    protected static $queryBuilder = null;
    protected $table;
    
    /**
     * Required fields for this model
     * @var array
     */
    protected $required = [];
    
    /**
     * Schema definition for data validation
     * @var array
     */
    protected $schema = [];

    /**
     * Initialize database connection with secure configuration
     */
    public function __construct() {
        if (self::$db === null) {
            try {
                $config = require CONFIG_PATH . '/database.php';
                
                // Ensure required configuration exists
                if (!isset($config['host'], $config['dbname'], $config['username'], $config['password'])) {
                    throw new \Exception('Invalid database configuration');
                }
                
                // Set secure default options
                $defaultOptions = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                    PDO::ATTR_STRINGIFY_FETCHES => false
                ];
                
                // Merge with user options, but don't allow overriding critical security settings
                $options = array_merge(
                    $config['options'] ?? [],
                    $defaultOptions
                );
                
                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
                self::$db = new PDO($dsn, $config['username'], $config['password'], $options);
                
                // Initialize QueryBuilder
                self::$queryBuilder = new QueryBuilder(self::$db);
                
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
     * Find all records in the table with secure query building
     * @param array $conditions Optional WHERE conditions
     * @param array $orderBy Optional ORDER BY conditions ['column' => 'ASC|DESC']
     * @param int|null $limit Optional LIMIT value
     * @param int $offset Optional OFFSET value
     * @return array
     */
    public function findAll(array $conditions = [], array $orderBy = [], ?int $limit = null, int $offset = 0): array {
        try {
            // Start query
            $query = self::$queryBuilder->select('*', $this->table);
            
            // Add conditions
            foreach ($conditions as $column => $value) {
                // Sanitize column name to prevent SQL injection in identifiers
                $column = str_replace(['`', "'", '"'], '', $column);
                $query->where($column, '=', Security::sanitize($value));
            }
            
            // Add ordering
            foreach ($orderBy as $column => $direction) {
                // Sanitize column name
                $column = str_replace(['`', "'", '"'], '', $column);
                $query->orderBy($column, $direction);
            }
            
            // Add limit if specified
            if ($limit !== null) {
                $query->limit($limit, $offset);
            }
            
            return $query->getAll();
            
        } catch (PDOException $e) {
            error_log("Database Query Error: " . $e->getMessage());
            throw new \Exception("Error retrieving records");
        }
    }

    /**
     * Find a single record by ID with secure query building
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array {
        try {
            // Validate ID
            if ($id <= 0) {
                throw new \InvalidArgumentException("Invalid ID provided");
            }
            
            return self::$queryBuilder
                ->select('*', $this->table)
                ->where('id', '=', $id)
                ->getOne();
                
        } catch (PDOException $e) {
            error_log("Database Query Error: " . $e->getMessage());
            throw new \Exception("Error retrieving record");
        }
    }

    /**
     * Create a new record with input sanitization
     * @param array $data
     * @return int Last insert ID
     * @throws \Exception on validation or database errors
     */
    public function create(array $data): int {
        try {
            // Validate required fields if defined
            if (isset($this->required) && is_array($this->required)) {
                foreach ($this->required as $field) {
                    if (!isset($data[$field]) || empty($data[$field])) {
                        throw new \InvalidArgumentException("Missing required field: {$field}");
                    }
                }
            }
            
            // Sanitize all input data
            $sanitizedData = Security::sanitize($data);
            
            // Validate data types if schema is defined
            if (isset($this->schema) && is_array($this->schema)) {
                foreach ($sanitizedData as $field => $value) {
                    if (isset($this->schema[$field])) {
                        $type = $this->schema[$field];
                        if (!$this->validateDataType($value, $type)) {
                            throw new \InvalidArgumentException("Invalid data type for field {$field}");
                        }
                    }
                }
            }
            
            return self::$queryBuilder->insert($this->table, $sanitizedData);
            
        } catch (PDOException $e) {
            error_log("Database Insert Error: " . $e->getMessage());
            throw new \Exception("Error creating record");
        }
    }
    
    /**
     * Validate data type of a field
     * @param mixed $value The value to validate
     * @param string $type Expected type (int, string, email, url, etc.)
     * @return bool
     */
    protected function validateDataType($value, string $type): bool {
        switch ($type) {
            case 'int':
                return is_numeric($value) && (int)$value == $value;
            case 'float':
                return is_numeric($value);
            case 'string':
                return is_string($value);
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            case 'url':
                return filter_var($value, FILTER_VALIDATE_URL) !== false;
            case 'date':
                return strtotime($value) !== false;
            case 'bool':
                return is_bool($value) || in_array($value, [0, 1, '0', '1']);
            default:
                return true;
        }
    }

    /**
     * Update a record with input validation and sanitization
     * @param int $id
     * @param array $data
     * @return bool
     * @throws \Exception on validation or database errors
     */
    public function update(int $id, array $data): bool {
        try {
            // Validate ID
            if ($id <= 0) {
                throw new \InvalidArgumentException("Invalid ID provided");
            }
            
            // Log the update attempt
            error_log("Attempting to update record {$id} in table {$this->table}");
            error_log("Update data: " . print_r($data, true));
            
            // Sanitize input data
            $sanitizedData = Security::sanitize($data);
            error_log("Sanitized data: " . print_r($sanitizedData, true));
            
            // Validate data types if schema is defined
            if (!empty($this->schema)) {
                foreach ($sanitizedData as $field => $value) {
                    if (isset($this->schema[$field])) {
                        $type = $this->schema[$field];
                        if (!$this->validateDataType($value, $type)) {
                            throw new \InvalidArgumentException("Invalid data type for field {$field}");
                        }
                    }
                }
            }
            
            // Check if the record exists
            $exists = self::$queryBuilder
                ->select('id', $this->table)
                ->where('id', '=', $id)
                ->getOne();
                
            if (!$exists) {
                error_log("Record with ID {$id} not found in table {$this->table}");
                throw new \Exception("Record not found");
            }
            
            // Reset the query builder for the update operation
            self::$queryBuilder = new QueryBuilder(self::$db);
            
            // Perform update
            $result = self::$queryBuilder
                ->update($this->table, $sanitizedData)
                ->where('id', '=', $id)
                ->execute();
            
            if ($result === 0) {
                error_log("Update operation affected 0 rows");
                return false;
            }
            
            error_log("Successfully updated record {$id} in table {$this->table}");
            return true;
                
        } catch (PDOException $e) {
            error_log("Database Update Error in table {$this->table}: " . $e->getMessage());
            error_log("SQL State: " . $e->errorInfo[0]);
            error_log("Driver Error Code: " . $e->errorInfo[1]);
            error_log("Driver Error Message: " . $e->errorInfo[2]);
            throw new \Exception("Error updating record: " . $e->getMessage());
        } catch (\Exception $e) {
            error_log("Error updating record in table {$this->table}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a record with validation
     * @param int $id
     * @return bool
     * @throws \Exception if record doesn't exist or on database error
     */
    public function delete(int $id): bool {
        try {
            // Validate ID
            if ($id <= 0) {
                throw new \InvalidArgumentException("Invalid ID provided");
            }
            
            // Check if record exists before deletion
            $exists = self::$queryBuilder
                ->select('id', $this->table)
                ->where('id', '=', $id)
                ->getOne();
                
            if (!$exists) {
                throw new \Exception("Record not found");
            }
            
            // Perform deletion
            return (bool) self::$queryBuilder
                ->delete($this->table)
                ->where('id', '=', $id)
                ->execute();
                
        } catch (PDOException $e) {
            error_log("Database Delete Error: " . $e->getMessage());
            throw new \Exception("Error deleting record");
        }
    }
    
    /**
     * Get error information
     * @return array Array containing error info
     */
    protected function getErrorInfo(): array {
        return self::$db->errorInfo();
    }
    
    /**
     * Check if a value already exists in a column
     * @param string $column Column name
     * @param mixed $value Value to check
     * @param int|null $excludeId Optional ID to exclude from check (for updates)
     * @return bool True if value exists
     */
    protected function valueExists(string $column, $value, ?int $excludeId = null): bool {
        try {
            $query = self::$queryBuilder->select('id', $this->table)->where($column, '=', $value);
            
            if ($excludeId !== null) {
                $query->where('id', '!=', $excludeId);
            }
            
            return $query->getOne() !== null;
            
        } catch (PDOException $e) {
            error_log("Database Query Error: " . $e->getMessage());
            throw new \Exception("Error checking value existence");
        }
    }
}