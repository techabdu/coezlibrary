<?php
/**
 * CarouselImage.php
 * Model for handling carousel/slider images
 */

namespace App\Models;

use Core\Model;
use PDO;
use PDOException;
use Exception;

class CarouselImage extends Model {
    protected $table = 'carousel_images';
    /**
     * Get all active carousel images ordered by display order
     * 
     * @return array Array of active carousel images
     */
    public function getActiveImages() {
        try {
            $sql = "SELECT id, image_path, caption, display_order 
                   FROM carousel_images 
                   WHERE is_active = 1 
                   ORDER BY display_order ASC";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in CarouselImage->getActiveImages(): " . $e->getMessage());
            throw new Exception('Failed to fetch carousel images');
        }
    }

    /**
     * Add a new carousel image
     * 
     * @param array $data Image data (image_path, caption, display_order)
     * @return int|false The ID of the newly created image or false on failure
     */
    public function addImage($data) {
        try {
            $sql = "INSERT INTO carousel_images (image_path, caption, display_order, is_active) 
                   VALUES (:image_path, :caption, :display_order, 1)";
            
            $stmt = $this->getDB()->prepare($sql);
            
            $stmt->bindValue(':image_path', $data['image_path'], PDO::PARAM_STR);
            $stmt->bindValue(':caption', $data['caption'], PDO::PARAM_STR);
            $stmt->bindValue(':display_order', $data['display_order'], PDO::PARAM_INT);
            
            $stmt->execute();
            return $this->getDB()->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error in CarouselImage->addImage(): " . $e->getMessage());
            throw new Exception('Failed to add carousel image');
        }
    }

    /**
     * Update carousel image status
     * 
     * @param int $id Image ID
     * @param bool $active New active status
     * @return bool True on success, false on failure
     */
    public function updateStatus($id, $active) {
        try {
            $sql = "UPDATE carousel_images 
                   SET is_active = :active 
                   WHERE id = :id";
            
            $stmt = $this->getDB()->prepare($sql);
            
            $stmt->bindValue(':active', $active, PDO::PARAM_BOOL);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in CarouselImage->updateStatus(): " . $e->getMessage());
            throw new Exception('Failed to update carousel image status');
        }
    }
}