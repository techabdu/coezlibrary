<?php
/**
 * LibrarianInfo.php
 * Handles librarian information data operations
 */

namespace App\Models;

use Core\Model;
use PDO;
use Exception;

class LibrarianInfo extends Model {
    /**
     * Get the head librarian's information
     * @return array|null
     */
    public function getLibrarianInfo(): ?array {
        try {
            $stmt = $this->getDB()->query("SELECT * FROM librarian_info LIMIT 1");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result === false) {
                error_log("LibrarianInfo: No librarian data found in database");
                return null;
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in LibrarianInfo->getLibrarianInfo(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Get librarian's social links
     * @return array
     */
    public function getSocialLinks(): array {
        try {
            $stmt = $this->db->query("SELECT social_links FROM librarian_info LIMIT 1");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? json_decode($result['social_links'], true) : [];
        } catch (Exception $e) {
            error_log("Error in LibrarianInfo->getSocialLinks(): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Update librarian information
     * @param array $data Updated librarian data
     * @return bool Success status
     */
    public function updateLibrarianInfo(array $data): bool {
        try {
            $params = [
                'name' => $data['name'],
                'title' => $data['title'],
                'qualification' => $data['qualification'],
                'message' => $data['message'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'office_hours' => $data['office_hours'],
                'social_links' => json_encode($data['social_links'] ?? [])
            ];

            $sql = "UPDATE librarian_info 
                    SET name = :name,
                        title = :title,
                        qualification = :qualification,
                        message = :message,
                        email = :email,
                        phone = :phone,
                        office_hours = :office_hours,
                        social_links = :social_links";

            if (!empty($data['image_path'])) {
                $sql .= ", image_path = :image_path";
            }

            $sql .= " WHERE id = 1";

            $params = [
                'name' => $data['name'],
                'title' => $data['title'],
                'qualification' => $data['qualification'],
                'message' => $data['message'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'office_hours' => $data['office_hours'],
                'social_links' => json_encode($data['social_links'] ?? [])
            ];

            if (!empty($data['image_path'])) {
                $params['image_path'] = $data['image_path'];
            }

            $stmt = $this->getDB()->prepare($sql);
            return $stmt->execute($params);
        } catch (Exception $e) {
            error_log("Error in LibrarianInfo->updateLibrarianInfo(): " . $e->getMessage());
            return false;
        }
    }
}