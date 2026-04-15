<?php

class Gallery_model {
    private $table = 'gallery';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllGallery()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY upload_date DESC');
        return $this->db->resultSet();
    }

    public function getGalleryById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataGallery($data)
    {
        $query = "INSERT INTO gallery (image_url, caption, upload_date) VALUES (:image_url, :caption, :upload_date)";
        $this->db->query($query);
        $this->db->bind('image_url', $data['image_url']);
        $this->db->bind('caption', $data['caption']);
        $this->db->bind('upload_date', date('Y-m-d'));
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahDataGallery($data)
    {
        $query = "UPDATE gallery SET 
                    image_url = :image_url,
                    caption = :caption
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('image_url', $data['image_url']);
        $this->db->bind('caption', $data['caption']);
        $this->db->bind('id', $data['id']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusDataGallery($id)
    {
        $query = "DELETE FROM gallery WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        
        $this->db->execute();
        return $this->db->rowCount();
    }
}
