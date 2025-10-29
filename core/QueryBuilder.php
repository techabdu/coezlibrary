<?php
namespace Core;

/**
 * QueryBuilder Class
 * Provides a safe way to build and execute SQL queries using PDO
 */
class QueryBuilder {
    private $pdo;
    private $query;
    private $params = [];

    /**
     * Constructor
     * @param \PDO $pdo PDO database connection
     */
    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Begin a SELECT query
     * @param string|array $columns Columns to select
     * @param string $table Table name
     * @return self
     */
    public function select($columns, string $table): self {
        $cols = is_array($columns) ? implode(', ', $columns) : $columns;
        $this->query = "SELECT {$cols} FROM {$table}";
        return $this;
    }

    /**
     * Add WHERE clause
     * @param string $column Column name
     * @param string $operator Comparison operator (=, >, <, etc.)
     * @param mixed $value Value to compare against
     * @return self
     */
    public function where(string $column, string $operator, $value): self {
        $paramName = 'where_' . str_replace('.', '_', $column);
        
        // Handle first WHERE vs AND
        if (strpos($this->query, 'WHERE') === false) {
            $this->query .= ' WHERE';
        } else {
            $this->query .= ' AND';
        }
        
        $this->query .= " {$column} {$operator} :{$paramName}";
        $this->params[":{$paramName}"] = $value;
        
        return $this;
    }

    /**
     * Add OR WHERE clause
     * @param string $column Column name
     * @param string $operator Comparison operator
     * @param mixed $value Value to compare
     * @return self
     */
    public function orWhere(string $column, string $operator, $value): self {
        $paramName = ':' . str_replace('.', '_', $column);
        
        $this->query .= $this->query ? ' OR' : ' WHERE';
        $this->query .= " {$column} {$operator} {$paramName}";
        $this->params[$paramName] = $value;
        
        return $this;
    }

    /**
     * Add ORDER BY clause
     * @param string $column Column to order by
     * @param string $direction ASC or DESC
     * @return self
     */
    public function orderBy(string $column, string $direction = 'ASC'): self {
        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'])) {
            $direction = 'ASC';
        }
        
        $this->query .= " ORDER BY {$column} {$direction}";
        return $this;
    }

    /**
     * Add LIMIT clause
     * @param int $limit Number of rows to return
     * @param int $offset Starting position
     * @return self
     */
    public function limit(int $limit, int $offset = 0): self {
        $this->query .= " LIMIT :limit OFFSET :offset";
        $this->params[':limit'] = $limit;
        $this->params[':offset'] = $offset;
        return $this;
    }

    /**
     * Execute a SELECT query and return all results
     * @return array
     */
    public function getAll(): array {
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Execute a SELECT query and return first result
     * @return array|null
     */
    public function getOne(): ?array {
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->params);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result !== false ? $result : null;
    }

    /**
     * Insert a new record
     * @param string $table Table name
     * @param array $data Associative array of column => value pairs
     * @return int Last insert ID
     */
    public function insert(string $table, array $data): int {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        
        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        $stmt = $this->pdo->prepare($query);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        
        $stmt->execute();
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Update records
     * @param string $table Table name
     * @param array $data Data to update
     * @return self For method chaining
     * @throws \Exception if no WHERE clause is present
     */
    public function update(string $table, array $data): self {
        $this->params = []; // Reset params before building new query
        $set = [];
        foreach ($data as $column => $value) {
            $paramName = "set_{$column}";
            $set[] = "{$column} = :{$paramName}";
            $this->params[":{$paramName}"] = $value;
        }
        
        $this->query = "UPDATE {$table} SET " . implode(', ', $set);
        return $this;
    }
    
    /**
     * Execute the prepared statement
     * @return int Number of affected rows
     * @throws \Exception if no WHERE clause in UPDATE/DELETE or on database error
     */
    public function execute(): int {
        try {
            if ((strpos($this->query, 'UPDATE') === 0 || strpos($this->query, 'DELETE') === 0) && 
                strpos($this->query, 'WHERE') === false) {
                throw new \Exception('UPDATE/DELETE queries must include a WHERE clause');
            }
            
            $stmt = $this->pdo->prepare($this->query);
            
            // Log the query and parameters for debugging
            error_log("Executing query: " . $this->query);
            error_log("Parameters: " . print_r($this->params, true));
            
            // Execute and check the result
            if (!$stmt->execute($this->params)) {
                $error = $stmt->errorInfo();
                throw new \PDOException("Query execution failed: " . $error[2]);
            }
            
            $affectedRows = $stmt->rowCount();
            if ($affectedRows === 0) {
                error_log("Warning: Query affected 0 rows");
            }
            
            return $affectedRows;
            
        } catch (\PDOException $e) {
            error_log("Database error in QueryBuilder::execute(): " . $e->getMessage());
            throw new \Exception("Database error: " . $e->getMessage());
        } catch (\Exception $e) {
            error_log("Error in QueryBuilder::execute(): " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete records
     * @param string $table Table name
     * @return self For method chaining
     */
    public function delete(string $table): self {
        $this->query = "DELETE FROM {$table}";
        return $this;
    }

    /**
     * Count records
     * @param string $table Table name
     * @param string $column Column to count (defaults to *)
     * @return int
     */
    public function count(string $table, string $column = '*'): int {
        $this->query = "SELECT COUNT({$column}) as count FROM {$table}";
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->params);
        return (int) $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }
}