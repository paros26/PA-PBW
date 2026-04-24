<?php

class Rental_model {
    private $table = 'rentals';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllRentals()
    {
        $query = 'SELECT r.*, j.name as jetski_name 
                  FROM ' . $this->table . ' r 
                  LEFT JOIN jetskis j ON r.jetski_id = j.id 
                  ORDER BY (r.status = "deleted") ASC, r.id DESC';
        
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getRentalById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataRental($data)
    {
        $phone = preg_replace('/[^0-9]/', '', $data['customer_phone']);
        if (empty($phone)) return 0;

        $query = "INSERT INTO rentals (jetski_id, customer_name, customer_phone, rental_date, duration, total_price, payment_proof, status, token) 
                  VALUES (:jetski_id, :customer_name, :customer_phone, :rental_date, :duration, :total_price, :payment_proof, :status, :token)";
        
        $this->db->query($query);
        $this->db->bind('jetski_id', $data['jetski_id']);
        $this->db->bind('customer_name', $data['customer_name']);
        $this->db->bind('customer_phone', $phone);
        $this->db->bind('rental_date', $data['rental_date']);
        $this->db->bind('duration', $data['sesi']); 
        $this->db->bind('total_price', $data['total_price']);
        $this->db->bind('payment_proof', $data['payment_proof'] ?? null);
        $this->db->bind('status', $data['status'] ?? 'active');
        $this->db->bind('token', $data['token'] ?? null);

        try {
            $this->db->execute();
            return $this->db->rowCount();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function ubahDataRental($data)
    {
        $phone = preg_replace('/[^0-9]/', '', $data['customer_phone']);
        $existing = $this->getRentalById($data['id']);
        if ($existing && $existing['status'] === 'deleted') return 0;

        $query = "UPDATE rentals SET 
                    jetski_id = :jetski_id,
                    customer_name = :customer_name,
                    customer_phone = :customer_phone,
                    rental_date = :rental_date,
                    duration = :duration, 
                    total_price = :total_price,
                    payment_proof = :payment_proof,
                    status = :status,
                    token = :token
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('jetski_id', $data['jetski_id']);
        $this->db->bind('customer_name', $data['customer_name']);
        $this->db->bind('customer_phone', $phone);
        $this->db->bind('rental_date', $data['rental_date']);
        $this->db->bind('duration', $data['sesi']); 
        $this->db->bind('total_price', $data['total_price']);
        $this->db->bind('payment_proof', $data['payment_proof'] ?? ($existing['payment_proof'] ?? null));
        $this->db->bind('status', $data['status']);
        $this->db->bind('token', $data['token'] ?? ($existing['token'] ?? null));
        $this->db->bind('id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusDataRental($id)
    {
        $query = "UPDATE rentals SET status = 'deleted' WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
