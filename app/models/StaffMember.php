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
            $stmt = $this->db->query(
                "SELECT * FROM staff_members 
                WHERE is_active = 1 
                ORDER BY display_order, name"
            );
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error in StaffMember->getAllActiveStaff(): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get staff member by ID
     * @param int $id Staff member ID
     * @return array|null
     */
    public function getStaffMemberById(int $id): ?array {
        try {
            $stmt = $this->db->prepare("SELECT * FROM staff_members WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
        } catch (Exception $e) {
            error_log("Error in StaffMember->getStaffMemberById(): " . $e->getMessage());
            return null;
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