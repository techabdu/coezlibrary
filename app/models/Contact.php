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
    public function getAllSubmissions(): array {
        $sql = "SELECT * FROM contact_submissions ORDER BY submitted_at DESC";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}