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
        // Order by: status 'deleted' at the bottom, others by date desc
        $query = 'SELECT r.*, j.name as jetski_name 
                  FROM ' . $this->table . ' r 
                  JOIN jetskis j ON r.jetski_id = j.id 
                  ORDER BY (r.status = "deleted") ASC, r.rental_date DESC';
        
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
        if (!preg_match('/^[0-9]+$/', $data['customer_phone'])) {
            return 0;
        }

        $query = "INSERT INTO rentals (jetski_id, customer_name, customer_phone, rental_date, duration, total_price, payment_proof, status) 
                  VALUES (:jetski_id, :customer_name, :customer_phone, :rental_date, :duration, :total_price, :payment_proof, :status)";
        
        $this->db->query($query);
        $this->db->bind('jetski_id', $data['jetski_id']);
        $this->db->bind('customer_name', $data['customer_name']);
        $this->db->bind('customer_phone', $data['customer_phone']);
        $this->db->bind('rental_date', $data['rental_date']);
        $this->db->bind('duration', $data['duration']);
        $this->db->bind('total_price', $data['total_price']);
        $this->db->bind('payment_proof', $data['payment_proof'] ?? null);
        $this->db->bind('status', $data['status']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusDataRental($id)
    {
        // Soft delete: update status to 'deleted' instead of actual delete
        $query = "UPDATE rentals SET status = 'deleted' WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahDataRental($data)
    {
        if (!preg_match('/^[0-9]+$/', $data['customer_phone'])) {
            return 0;
        }

        // Prevent modification if already deleted
        $existing = $this->getRentalById($data['id']);
        if ($existing && $existing['status'] === 'deleted') {
            return 0;
        }

        $query = "UPDATE rentals SET 
                    jetski_id = :jetski_id,
                    customer_name = :customer_name,
                    customer_phone = :customer_phone,
                    rental_date = :rental_date,
                    duration = :duration,
                    total_price = :total_price,
                    payment_proof = :payment_proof,
                    status = :status
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('jetski_id', $data['jetski_id']);
        $this->db->bind('customer_name', $data['customer_name']);
        $this->db->bind('customer_phone', $data['customer_phone']);
        $this->db->bind('rental_date', $data['rental_date']);
        $this->db->bind('duration', $data['duration']);
        $this->db->bind('total_price', $data['total_price']);
        $this->db->bind('payment_proof', $data['payment_proof']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }
}
