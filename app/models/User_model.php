<?php

class User_model {
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllUsers()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function login($username, $password)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
        $this->db->bind('username', $username);
        $user = $this->db->single();

        if ($user) {
            // Check if password matches (handling both plain text for legacy and hash for new)
            if (password_verify($password, $user['password']) || $password == $user['password']) {
                return $user;
            }
        }
        return false;
    }

    public function register($data)
    {
        $query = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        // Hash password for security
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind('role', $data['role'] ?? 'user');

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusDataUser($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahDataUser($data)
    {
        $query = "UPDATE users SET 
                    username = :username,
                    role = :role";
        
        // Only update password if provided
        if (!empty($data['password'])) {
            $query .= ", password = :password";
        }
        
        $query .= " WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('role', $data['role']);
        $this->db->bind('id', $data['id']);
        
        if (!empty($data['password'])) {
            $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        }

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function checkUsername($username)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
        $this->db->bind('username', $username);
        return $this->db->single();
    }

    public function cekUsername($username)
    {
        return $this->checkUsername($username);
    }
}
