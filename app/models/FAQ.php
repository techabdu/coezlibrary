<?php
namespace App\Models;

use Core\Model;
use PDO;

class FAQ extends Model {
    /**
     * Table name for this model
     * @var string
     */
    protected $table = 'faq';

    /**
     * Get all FAQs ordered by display order
     * @return array Array of FAQ items
     */
    public function getAllFAQs(): array {
        $sql = "SELECT * FROM faq ORDER BY display_order, category";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get FAQs by category
     * @param string $category Category name
     * @return array Array of FAQ items in the specified category
     */
    public function getFAQsByCategory(string $category): array {
        $sql = "SELECT * FROM faq WHERE category = :category ORDER BY display_order";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute(['category' => $category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all unique FAQ categories
     * @return array Array of category names
     */
    public function getAllCategories(): array {
        $sql = "SELECT DISTINCT category FROM faq ORDER BY category";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}