<?php

namespace Helper;

class Validator
{
    protected $errors = [];

    public function customError($field,$msg){
        $this->errors[$field] = $msg;
        return $this;
    }

    public function required($field, $value, $field_name = null)
    {
        if (empty($value)) {
            $this->errors[$field] = ($field_name ?? $field) . " is required.";
        }
        return $this;
    }

    public function string($field, $value, $field_name = null)
    {
        if (!is_string($value)) {
            $this->errors[$field] = ($field_name ?? $field) . " must be a string.";
        }
        return $this;
    }

    public function integer($field, $value, $field_name = null)
    {
        if (!is_int($value)) {
            $this->errors[$field] = ($field_name ?? $field) . " must be an integer.";
        }
        return $this;
    }

    public function minLength($field, $value, $min, $field_name = null)
    {
        if (strlen($value) < $min) {
            $this->errors[$field] = ($field_name ?? $field) . " must be at least $min characters long.";
        }
        return $this;
    }

    public function maxLength($field, $value, $max, $field_name = null)
    {
        if (strlen($value) > $max) {
            $this->errors[$field] = ($field_name ?? $field) . " must be no more than $max characters long.";
        }
        return $this;
    }

    public function email($field, $value, $field_name = null)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = ($field_name ?? $field) . " must be a valid email address.";
        }
        return $this;
    }

    public function emailRegex($field, $value, $field_name = null) {
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        if (!preg_match($pattern, $value)) {
            $this->errors[$field] = ($field_name ?? $field) . " must match the format example@example.com.";
        }
        return $this;
    }

    public function fileType($field, $fileTmpName, $allowedTypes, $field_name = null)
    {
        $fileType = mime_content_type($fileTmpName);
        if (!in_array($fileType, $allowedTypes)) {
            $this->errors[$field] = ($field_name ?? $field) . " must be one of the following types: " . implode(", ", $allowedTypes);
        }
        return $this;
    }

    public function fileExtension($field, $fileName, $allowedExtensions, $field_name = null)
    {
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!in_array($fileExtension, $allowedExtensions)) {
            $this->errors[$field] = ($field_name ?? $field) . " must have one of the following extensions: " . implode(", ", $allowedExtensions);
        }
        return $this;
    }

    public function between($field, $value, $min, $max, $field_name = null)
    {
        if ($value < $min || $value > $max) {
            $this->errors[$field] = ($field_name ?? $field) . " must be between $min and $max.";
        }
        return $this;
    }

    public function enum($field, $value, $allowedValues, $field_name = null)
    {
        if (!in_array($value, $allowedValues)) {
            $this->errors[$field] = ($field_name ?? $field) . " must be one of the following values: " . implode(", ", $allowedValues);
        }
        return $this;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function passes()
    {
        return empty($this->errors);
    }
}
