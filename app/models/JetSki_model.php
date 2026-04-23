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

    public function getActiveJetSkis()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE is_available = 1');
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
        $query = "INSERT INTO jetskis (name, brand, model, year, rider_type, route, price_per_hour, image_url, description, is_available) 
                  VALUES (:name, :brand, :model, :year, :rider_type, :route, :price_per_hour, :image_url, :description, :is_available)";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('brand', $data['brand'] ?: 'Yamaha');
        $this->db->bind('model', $data['model'] ?: 'Mahakam Series');
        $this->db->bind('year', (int)($data['year'] ?: date('Y')));
        $this->db->bind('rider_type', $data['rider_type']);
        $this->db->bind('route', $data['route']);
        $this->db->bind('price_per_hour', (float)$data['price_per_hour']);
        $this->db->bind('image_url', $data['image_url']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('is_available', (int)($data['is_available'] ?? 1));

        try {
            $this->db->execute();
            return $this->db->rowCount();
        } catch (PDOException $e) {
            // Lempar exception agar tertangkap di Controller/API
            throw new Exception("Database Error: " . $e->getMessage());
        }
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
                    rider_type = :rider_type,
                    route = :route,
                    price_per_hour = :price_per_hour,
                    image_url = :image_url,
                    description = :description,
                    is_available = :is_available
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('brand', $data['brand'] ?: 'Yamaha');
        $this->db->bind('model', $data['model'] ?: 'Mahakam Series');
        $this->db->bind('year', (int)($data['year'] ?: date('Y')));
        $this->db->bind('rider_type', $data['rider_type']);
        $this->db->bind('route', $data['route']);
        $this->db->bind('price_per_hour', (float)$data['price_per_hour']);
        $this->db->bind('image_url', $data['image_url']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('is_available', (int)($data['is_available'] ?? 1));
        $this->db->bind('id', $data['id']);

        try {
            $this->db->execute();
            return $this->db->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Database Error: " . $e->getMessage());
        }
    }
}
