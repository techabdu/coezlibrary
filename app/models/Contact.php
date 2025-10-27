<?php
namespace App\Models;

use Core\Model;
use PDO;

class Contact extends Model {
    /**
     * Table name for this model
     * @var string
     */
    protected $table = 'contact_submissions';

    /**
     * Save a new contact form submission
     * @param array $data Form submission data
     * @return bool True if successful, false otherwise
     */
    public function saveSubmission(array $data): bool {
        $sql = "INSERT INTO contact_submissions (name, email, subject, message) 
                VALUES (:name, :email, :subject, :message)";
                
        try {
            $stmt = $this->getDB()->prepare($sql);
            return $stmt->execute([
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message']
            ]);
        } catch (\PDOException $e) {
            error_log("Error saving contact submission: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all contact submissions ordered by submission date
     * @return array Array of contact submissions
     */
    /**
     * Get all contact submissions with optional filtering
     * @param string|null $status Filter by status ('pending', 'responded', 'archived')
     * @param string|null $search Search in name, email, or subject
     * @return array Array of contact submissions
     */
    public function getAllSubmissions(?string $status = null, ?string $search = null): array {
        $params = [];
        $sql = "SELECT * FROM contact_submissions WHERE 1=1";

        if ($status) {
            $sql .= " AND status = :status";
            $params['status'] = $status;
        }

        if ($search) {
            $sql .= " AND (name LIKE :search OR email LIKE :search OR subject LIKE :search)";
            $params['search'] = "%{$search}%";
        }

        $sql .= " ORDER BY submitted_at DESC";

        try {
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error getting contact submissions: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Update submission status
     * @param int $id Submission ID
     * @param string $status New status ('pending', 'responded', 'archived')
     * @return bool True if successful, false otherwise
     */
    public function updateStatus(int $id, string $status): bool {
        $sql = "UPDATE contact_submissions SET status = :status WHERE id = :id";
        try {
            $stmt = $this->getDB()->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'status' => $status
            ]);
        } catch (\PDOException $e) {
            error_log("Error updating submission status: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get a specific contact submission by ID
     * @param int $id Submission ID
     * @return array|false The submission data or false if not found
     */
    public function getSubmissionById(int $id) {
        $sql = "SELECT * FROM contact_submissions WHERE id = :id";
        try {
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error getting submission by ID: " . $e->getMessage());
            return false;
        }
    }
}