<?php
/**
 * CollegeInfo.php
 * Handles college information data operations
 */

namespace App\Models;

use Core\Model;
use PDO;
use Exception;

class CollegeInfo extends Model {
    /**
     * Get all college information sections
     * @return array
     */
    public function getAllSections(): array {
        try {
            $stmt = $this->db->query("SELECT * FROM college_info ORDER BY section");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in CollegeInfo->getAllSections(): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get college information by section
     * @param string $section Section identifier (history, mission, vision, overview)
     * @return array|null
     */
    public function getBySection(string $section): ?array {
        try {
            $stmt = $this->db->prepare("SELECT * FROM college_info WHERE section = :section");
            $stmt->execute(['section' => $section]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Exception $e) {
            error_log("Error in CollegeInfo->getBySection(): " . $e->getMessage());
            return null;
        }
    }
}