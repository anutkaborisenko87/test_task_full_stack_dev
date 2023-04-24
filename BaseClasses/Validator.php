<?php

namespace testFullStackDev\BaseClasses;

class Validator
{

    /**
     * @var array
     */
    private $data;
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $field
     * @param int $minLength
     * @param int $maxLength
     * @return void
     */
    public function validateString(string $field, int $minLength, int $maxLength)
    {
        if (!isset($this->errors[$field])) {
            $value = trim($this->data[$field]);
            if (empty($value)) {
                $this->addError($field, "Field cannot be empty.");
            } else {
                $length = strlen($value);
                if ($length < $minLength || $length > $maxLength) {
                    $this->addError($field, "Field must be between $minLength and $maxLength characters.");
                }
            }
        }

    }

    /**
     * @param string $field
     * @return void
     */

    public function requiredField(string $field)
    {
        if (!isset($this->errors[$field])) {
            if (!isset($this->data[$field]) || empty($this->data[$field])) {
                $this->addError($field, "Field $field is required.");
            }
        }
    }

    /**
     * @param $field
     * @param $message
     * @return void
     */
    public function addError($field, $message)
    {
        $this->errors[$field] = $message;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }
}