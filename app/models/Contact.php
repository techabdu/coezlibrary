<?php
/**
 * Contact Model
 * Handles database operations for contact form submissions
 */

namespace App\Models;

use Core\Model;
use PDO;

class Contact extends Model {
    /**
     * Table name for contact submissions
     * @var string
     */
    protected $table = 'contact_submissions';

    /**
     * Save a new contact form submission
     * @param array $data Form submission data
     * @return bool True if successful, false otherwise
     */
    public function saveSubmission(array $data): bool {
        try {
            // Begin transaction
            $this->getDB()->beginTransaction();

            $sql = "INSERT INTO contact_submissions (name, email, subject, message, status) 
                    VALUES (:name, :email, :subject, :message, 'pending')";
                
            $stmt = $this->getDB()->prepare($sql);
            $result = $stmt->execute([
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message']
            ]);

            if ($result) {
                $this->getDB()->commit();
                error_log("Successfully inserted contact submission with ID: " . $this->getDB()->lastInsertId());
                return true;
            } else {
                $this->getDB()->rollBack();
                error_log("Failed to insert contact submission: " . print_r($stmt->errorInfo(), true));
                return false;
            }
        } catch (\PDOException $e) {
            $this->getDB()->rollBack();
            error_log("Database error saving contact submission: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all submissions for admin viewing
     * @param string|null $status Filter by status (pending, responded, archived)
     * @param string|null $search Search term for name, email, or subject
     * @return array Array of all contact submissions
     */
    public function getAllSubmissions(?string $status = null, ?string $search = null): array {
        try {
            $sql = "SELECT * FROM contact_submissions";
            $params = [];
            $conditions = [];

            if ($status) {
                $conditions[] = "status = :status";
                $params[':status'] = $status;
            }

            if ($search) {
                $searchTerm = "%$search%";
                $conditions[] = "(name LIKE :search OR email LIKE :search OR subject LIKE :search)";
                $params[':search'] = $searchTerm;
            }

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $sql .= " ORDER BY submitted_at DESC";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error retrieving contact submissions: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a specific submission by ID
     * @param int $id The submission ID
     * @return array|false The submission data or false if not found
     */
    public function getSubmissionById(int $id) {
        try {
            $sql = "SELECT * FROM contact_submissions WHERE id = :id";
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error retrieving contact submission {$id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update the status of a contact submission
     * @param int $id The submission ID
     * @param string $status The new status
     * @return bool True if successful, false otherwise
     */
    public function updateStatus(int $id, string $status): bool {
        try {
            $sql = "UPDATE contact_submissions SET status = :status WHERE id = :id";
            $stmt = $this->getDB()->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'status' => $status
            ]);
        } catch (\PDOException $e) {
            error_log("Error updating contact submission status: " . $e->getMessage());
            return false;
        }
    }
}