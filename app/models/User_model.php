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
            if ($password == $user['password']) {
                return $user;
            }
        }
        return false;
    }

    public function register($data)
    {
        $query = "INSERT INTO " . $this->table . " (username, password, role) VALUES (:username, :password, :role)";
        
        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('password', $data['password']); // Mengikuti pola asli (plain text)
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
}
