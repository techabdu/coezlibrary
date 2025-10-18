<?php
/**
 * StaticPage.php
 * Model for handling static page content
 */

namespace App\Models;

use Core\Model;
use PDO;
use PDOException;
use Exception;

class StaticPage extends Model {
    protected $table = 'static_pages';

    /**
     * Get a page by its slug
     * 
     * @param string $slug The page slug
     * @return array|false Page data or false if not found
     * @throws Exception on database error
     */
    public function getPageBySlug($slug) {
        try {
            $sql = "SELECT id, page_name, slug, content, last_updated 
                   FROM {$this->table} 
                   WHERE slug = :slug";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result === false) {
                error_log("Page not found with slug: " . $slug);
                throw new Exception("Page not found: " . $slug);
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Database error in StaticPage->getPageBySlug(): " . $e->getMessage());
            error_log("SQL: " . $sql . ", Slug: " . $slug);
            throw new Exception('Database error while fetching page content');
        } catch (Exception $e) {
            error_log("Error in StaticPage->getPageBySlug(): " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create or update a static page
     * 
     * @param array $data Page data (page_name, slug, content)
     * @param int|null $id Page ID for update, null for create
     * @return bool True on success
     * @throws Exception on validation or database error
     */
    public function savePage($data, $id = null) {
        try {
            // Validate required fields
            if (empty($data['page_name']) || empty($data['slug']) || empty($data['content'])) {
                throw new Exception('Missing required fields');
            }

            if ($id === null) {
                // Insert new page
                $sql = "INSERT INTO {$this->table} (page_name, slug, content) 
                       VALUES (:page_name, :slug, :content)";
            } else {
                // Update existing page
                $sql = "UPDATE {$this->table} 
                       SET page_name = :page_name, 
                           slug = :slug, 
                           content = :content 
                       WHERE id = :id";
            }

            $stmt = $this->getDB()->prepare($sql);
            
            $stmt->bindValue(':page_name', $data['page_name'], PDO::PARAM_STR);
            $stmt->bindValue(':slug', $data['slug'], PDO::PARAM_STR);
            $stmt->bindValue(':content', $data['content'], PDO::PARAM_STR);
            
            if ($id !== null) {
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in StaticPage->savePage(): " . $e->getMessage());
            throw new Exception('Failed to save page');
        }
    }

    /**
     * Delete a static page
     * 
     * @param int $id Page ID
     * @return bool True on success
     * @throws Exception on database error
     */
    public function deletePage($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in StaticPage->deletePage(): " . $e->getMessage());
            throw new Exception('Failed to delete page');
        }
    }

    /**
     * Get all static pages
     * 
     * @return array Array of pages
     * @throws Exception on database error
     */
    public function getAllPages() {
        try {
            $sql = "SELECT id, page_name, slug, last_updated 
                   FROM {$this->table} 
                   ORDER BY page_name ASC";
            
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in StaticPage->getAllPages(): " . $e->getMessage());
            throw new Exception('Failed to fetch pages');
        }
    }
}