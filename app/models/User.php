<?php
namespace App\Models;

use Core\Model;
use PDO;

class User extends Model {
    /**
     * Table name for this model
     * @var string
     */
    protected $table = 'users';

    /**
     * Get user by username
     * @param string $username The username to look up
     * @return array|false User data or false if not found
     */
    public function getUserByUsername(string $username) {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Verify password against hash
     * @param string $password Plain text password
     * @param string $hash Stored password hash
     * @return bool True if password matches, false otherwise
     */
    public function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }

    /**
     * Hash a password using bcrypt
     * @param string $password Plain text password to hash
     * @return string Hashed password
     */
    public function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Check if a user has admin role
     * @param int $userId User ID to check
     * @return bool True if user is admin, false otherwise
     */
    public function isAdmin(int $userId): bool {
        $sql = "SELECT role FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute(['id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['role'] === 'admin';
    }
}