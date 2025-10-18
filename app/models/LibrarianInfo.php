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
            $stmt = $this->db->query("SELECT * FROM librarian_info LIMIT 1");
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Exception $e) {
            error_log("Error in LibrarianInfo->getLibrarianInfo(): " . $e->getMessage());
            return null;
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
}