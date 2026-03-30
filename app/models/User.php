<?php

require_once "../app/core/Model.php";

class User extends Model
{
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function create($name, $lastname, $email, $company, $role, $password)
    {
        $sql = "INSERT INTO users (name, lastname, email, company, role, password) 
                VALUES (:name, :lastname, :email, :company, :role, :password)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':password', $password);

        return $stmt->execute();
    }
}