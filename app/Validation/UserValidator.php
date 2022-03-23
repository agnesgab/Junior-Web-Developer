<?php

namespace App\Validation;

use App\Database;

class UserValidator
{
    private array $inputData;
    private array $errors = [];

    public function __construct(array $inputData)
    {
        $this->inputData = $inputData;
    }

    public function validateForm(): array
    {
        $this->validateName();
        $this->validateEmail();
        return $this->errors;
    }

    private function validateName(): void
    {
        $value = trim($this->inputData['name']);

        if (empty($value)) {
            $this->addError('name', 'Name field is required');
        } else {
            if (!preg_match("/^([a-zA-Z' ]+)$/", $value)) {
                $this->addError('name', 'Name contains unauthorized characters');
            }
        }
    }

    private function validateEmail(): void
    {
        $value = trim($this->inputData['email']);

        if (empty($value)) {
            $this->addError('email', 'Email field is required');
        } else {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->addError('email', 'Invalid e-mail');
            } else {
                $emailRowsQuery = Database::connection()
                    ->createQueryBuilder()
                    ->select('email')
                    ->from('users')
                    ->where('email = ?')
                    ->setParameter(0, $value)
                    ->executeQuery()
                    ->rowCount();

                if ($emailRowsQuery > 0) {
                    $this->addError('email', 'E-mail is already used');
                }
            }
        }
    }

    private function addError(string $key, string $value): void
    {
        $this->errors[$key] = $value;
    }
}