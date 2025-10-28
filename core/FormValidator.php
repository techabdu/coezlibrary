<?php
/**
 * FormValidator Class
 * Handles server-side form validation with consistent rules
 */

namespace Core;

class FormValidator {
    /**
     * Validation errors
     * @var array
     */
    private $errors = [];

    /**
     * Required fields that were validated
     * @var array
     */
    private $fields = [];

    /**
     * Add an error message
     * @param string $field The field name
     * @param string $message The error message
     */
    public function addError($field, $message) {
        $this->errors[$field] = $message;
    }

    /**
     * Get all error messages
     * @return array Array of error messages
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Check if validation passed
     * @return bool True if no errors, false otherwise
     */
    public function isValid() {
        return empty($this->errors);
    }

    /**
     * Validate a required field
     * @param string $field The field name
     * @param string $value The field value
     * @param string $label The field label for error messages
     * @return bool True if valid, false otherwise
     */
    public function required($field, $value, $label = null) {
        $label = $label ?? ucfirst(str_replace('_', ' ', $field));
        $this->fields[$field] = true;

        if (empty($value) && $value !== '0') {
            $this->addError($field, "$label is required");
            return false;
        }
        return true;
    }

    /**
     * Validate an email address
     * @param string $field The field name
     * @param string $value The email address
     * @param bool $required Whether the field is required
     * @return bool True if valid, false otherwise
     */
    public function email($field, $value, $required = true) {
        if ($required) {
            $this->required($field, $value, 'Email address');
        }

        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'Please enter a valid email address');
            return false;
        }
        return true;
    }

    /**
     * Validate a URL
     * @param string $field The field name
     * @param string $value The URL
     * @param bool $required Whether the field is required
     * @return bool True if valid, false otherwise
     */
    public function url($field, $value, $required = true) {
        if ($required) {
            $this->required($field, $value, 'URL');
        }

        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
            $this->addError($field, 'Please enter a valid URL (include http:// or https://)');
            return false;
        }
        return true;
    }

    /**
     * Validate minimum string length
     * @param string $field The field name
     * @param string $value The value
     * @param int $min The minimum length
     * @param string $label The field label for error messages
     * @return bool True if valid, false otherwise
     */
    public function minLength($field, $value, $min, $label = null) {
        $label = $label ?? ucfirst(str_replace('_', ' ', $field));
        
        if (strlen($value) < $min) {
            $this->addError($field, "$label must be at least $min characters long");
            return false;
        }
        return true;
    }

    /**
     * Validate maximum string length
     * @param string $field The field name
     * @param string $value The value
     * @param int $max The maximum length
     * @param string $label The field label for error messages
     * @return bool True if valid, false otherwise
     */
    public function maxLength($field, $value, $max, $label = null) {
        $label = $label ?? ucfirst(str_replace('_', ' ', $field));
        
        if (strlen($value) > $max) {
            $this->addError($field, "$label must not exceed $max characters");
            return false;
        }
        return true;
    }

    /**
     * Validate password strength
     * @param string $field The field name
     * @param string $value The password
     * @param int $minLength Minimum length requirement (default 8)
     * @return bool True if valid, false otherwise
     */
    public function password($field, $value, $minLength = 8) {
        if (!$this->minLength($field, $value, $minLength, 'Password')) {
            return false;
        }

        // Check for at least one number
        if (!preg_match('/\d/', $value)) {
            $this->addError($field, 'Password must contain at least one number');
            return false;
        }

        // Check for at least one letter
        if (!preg_match('/[a-zA-Z]/', $value)) {
            $this->addError($field, 'Password must contain at least one letter');
            return false;
        }

        return true;
    }

    /**
     * Validate password confirmation
     * @param string $password The password
     * @param string $confirmation The password confirmation
     * @return bool True if valid, false otherwise
     */
    public function passwordConfirmation($password, $confirmation) {
        if ($password !== $confirmation) {
            $this->addError('password_confirmation', 'Passwords do not match');
            return false;
        }
        return true;
    }

    /**
     * Validate file upload
     * @param string $field The field name
     * @param array $file The $_FILES array element
     * @param array $options Array of validation options (maxSize, allowedTypes)
     * @param bool $required Whether the file is required
     * @return bool True if valid, false otherwise
     */
    public function file($field, $file, $options = [], $required = true) {
        if ($required && (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE)) {
            $this->addError($field, 'Please select a file to upload');
            return false;
        }

        if (isset($file) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            // Check file size
            if (isset($options['maxSize']) && $file['size'] > $options['maxSize']) {
                $maxSizeMB = $options['maxSize'] / (1024 * 1024);
                $this->addError($field, "File size must not exceed {$maxSizeMB}MB");
                return false;
            }

            // Check file type
            if (isset($options['allowedTypes']) && !in_array($file['type'], $options['allowedTypes'])) {
                $types = implode(', ', array_map(function($type) {
                    return strtoupper(str_replace('image/', '', $type));
                }, $options['allowedTypes']));
                $this->addError($field, "Only $types files are allowed");
                return false;
            }
        }

        return true;
    }

    /**
     * Validate a date
     * @param string $field The field name
     * @param string $value The date string
     * @param string $format The expected date format (default Y-m-d)
     * @param bool $required Whether the field is required
     * @return bool True if valid, false otherwise
     */
    public function date($field, $value, $format = 'Y-m-d', $required = true) {
        if ($required) {
            $this->required($field, $value, 'Date');
        }

        if (!empty($value)) {
            $d = \DateTime::createFromFormat($format, $value);
            if (!$d || $d->format($format) !== $value) {
                $this->addError($field, "Please enter a valid date in $format format");
                return false;
            }
        }
        return true;
    }

    /**
     * Validate numeric value
     * @param string $field The field name
     * @param mixed $value The value
     * @param bool $required Whether the field is required
     * @return bool True if valid, false otherwise
     */
    public function numeric($field, $value, $required = true) {
        if ($required) {
            $this->required($field, $value, 'Number');
        }

        if (!empty($value) && !is_numeric($value)) {
            $this->addError($field, 'Please enter a valid number');
            return false;
        }
        return true;
    }

    /**
     * Sanitize data for safe storage
     * @param array $data Array of data to sanitize
     * @return array Sanitized data
     */
    public function sanitize($data) {
        $clean = [];
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                // Trim whitespace
                $value = trim($value);
                
                // Convert special characters to HTML entities
                $clean[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            } else {
                $clean[$key] = $value;
            }
        }
        return $clean;
    }
}