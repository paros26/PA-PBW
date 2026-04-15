<?php

class JetSki_model {
    private $table = 'jetskis';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllJetSkis()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getJetSkiById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataJetSki($data)
    {
        $query = "INSERT INTO jetskis (name, brand, model, year, price_per_hour, image_url, description, is_available) 
                  VALUES (:name, :brand, :model, :year, :price_per_hour, :image_url, :description, :is_available)";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('brand', $data['brand']);
        $this->db->bind('model', $data['model']);
        $this->db->bind('year', $data['year']);
        $this->db->bind('price_per_hour', $data['price_per_hour']);
        $this->db->bind('image_url', $data['image_url']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('is_available', $data['is_available']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusDataJetSki($id)
    {
        $query = "DELETE FROM jetskis WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahDataJetSki($data)
    {
        $query = "UPDATE jetskis SET 
                    name = :name,
                    brand = :brand,
                    model = :model,
                    year = :year,
                    price_per_hour = :price_per_hour,
                    image_url = :image_url,
                    description = :description,
                    is_available = :is_available
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('brand', $data['brand']);
        $this->db->bind('model', $data['model']);
        $this->db->bind('year', $data['year']);
        $this->db->bind('price_per_hour', $data['price_per_hour']);
        $this->db->bind('image_url', $data['image_url']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('is_available', $data['is_available']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }
}
