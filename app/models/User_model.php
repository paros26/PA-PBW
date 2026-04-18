<?php

class User_model {
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
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
        $this->db->bind('role', 'user');

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
