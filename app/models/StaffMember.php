<?php
/**
 * StaffMember.php
 * Handles library staff data operations
 */

namespace App\Models;

use Core\Model;
use PDO;
use Exception;

class StaffMember extends Model {
    /**
     * Get all active staff members
     * @return array
     */
    public function getAllActiveStaff(): array {
        try {
            $stmt = $this->getDB()->query(
                "SELECT * FROM staff_members 
                WHERE is_active = 1 
                ORDER BY display_order, name"
            );
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if (empty($results)) {
                error_log("StaffMember: No active staff members found in database");
                throw new Exception("No active staff members found");
            }
            
            return $results;
        } catch (Exception $e) {
            error_log("Error in StaffMember->getAllActiveStaff(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Get staff member by ID
     * @param int $id Staff member ID
     * @return array|null
     */
    public function getStaffMemberById(int $id): ?object {
        try {
            $stmt = $this->getDB()->prepare("SELECT * FROM staff_members WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            if (!$result) {
                error_log("StaffMember: No staff member found with ID: " . $id);
                return null;
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in StaffMember->getStaffMemberById(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Get staff members by department
     * @param string $department Department name
     * @return array
     */
    public function getStaffByDepartment(string $department): array {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM staff_members 
                WHERE department = :department AND is_active = 1 
                ORDER BY display_order, name"
            );
            $stmt->execute(['department' => $department]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in StaffMember->getStaffByDepartment(): " . $e->getMessage());
            return [];
        }
    }
}