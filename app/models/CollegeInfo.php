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
            $stmt = $this->getDB()->query("SELECT * FROM college_info ORDER BY section");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($results)) {
                error_log("CollegeInfo: No college sections found in database");
                return [];
            }
            
            return $results;
        } catch (Exception $e) {
            error_log("Error in CollegeInfo->getAllSections(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            throw $e;
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