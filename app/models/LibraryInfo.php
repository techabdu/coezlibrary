<?php
/**
 * LibraryInfo.php
 * Model for handling library information (singleton table)
 */

namespace App\Models;

use Core\Model;
use PDO;
use PDOException;
use Exception;

class LibraryInfo extends Model {
    protected $table = 'library_info';
    /**
     * Get library information
     * Returns singleton row from library_info table
     * 
     * @return array|false Library information or false if not found
     */
    public function getLibraryInfo() {
        try {
            $sql = "SELECT hours, location, phone, email, address 
                   FROM library_info 
                   WHERE id = 1 
                   LIMIT 1";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in LibraryInfo->getLibraryInfo(): " . $e->getMessage());
            throw new Exception('Failed to fetch library information');
        }
    }

    /**
     * Update library information
     * 
     * @param array $data Array containing library information fields
     * @return bool True on success, false on failure
     */
    public function updateLibraryInfo($data) {
        try {
            $sql = "UPDATE library_info 
                   SET hours = :hours, 
                       location = :location, 
                       phone = :phone, 
                       email = :email, 
                       address = :address 
                   WHERE id = 1";
            
            $stmt = $this->getDB()->prepare($sql);
            
            $stmt->bindValue(':hours', $data['hours'], PDO::PARAM_STR);
            $stmt->bindValue(':location', $data['location'], PDO::PARAM_STR);
            $stmt->bindValue(':phone', $data['phone'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':address', $data['address'], PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in LibraryInfo->updateLibraryInfo(): " . $e->getMessage());
            throw new Exception('Failed to update library information');
        }
    }
}