<?php
namespace App\Models;

use Core\Model;
use PDO;

class FAQ extends Model {
    /**
     * Table name for this model
     * @var string
     */
    protected $table = 'faqs';

    /**
     * Get all FAQs ordered by display order
     * @return array Array of FAQ items
     */
    public function getAllFAQs(): array {
        $sql = "SELECT * FROM faqs ORDER BY display_order, category";
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
        $sql = "SELECT * FROM faqs WHERE category = :category ORDER BY display_order";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute(['category' => $category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all unique FAQ categories
     * @return array Array of category names
     */
    public function getAllCategories(): array {
        $sql = "SELECT DISTINCT category FROM faqs ORDER BY category";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Get FAQ by ID
     * @param int $id FAQ ID
     * @return array|false FAQ data or false if not found
     */
    public function getFAQById(int $id) {
        $sql = "SELECT * FROM faqs WHERE id = :id";
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new FAQ
     * @param array $data FAQ data
     * @return bool Success status
     */
    public function createFAQ(array $data): bool {
        $sql = "INSERT INTO faqs (question, answer, category, display_order) 
                VALUES (:question, :answer, :category, :display_order)";
        
        $stmt = $this->getDB()->prepare($sql);
        return $stmt->execute([
            'question' => $data['question'],
            'answer' => $data['answer'],
            'category' => $data['category'],
            'display_order' => intval($data['display_order'] ?? 0)
        ]);
    }

    /**
     * Update an existing FAQ
     * @param int $id FAQ ID
     * @param array $data Updated FAQ data
     * @return bool Success status
     */
    public function updateFAQ(int $id, array $data): bool {
        $sql = "UPDATE faqs 
                SET question = :question,
                    answer = :answer,
                    category = :category,
                    display_order = :display_order
                WHERE id = :id";
        
        $stmt = $this->getDB()->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'question' => $data['question'],
            'answer' => $data['answer'],
            'category' => $data['category'],
            'display_order' => intval($data['display_order'] ?? 0)
        ]);
    }

    /**
     * Delete a FAQ
     * @param int $id FAQ ID
     * @return bool Success status
     */
    public function deleteFAQ(int $id): bool {
        $sql = "DELETE FROM faqs WHERE id = :id";
        $stmt = $this->getDB()->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}