<?php
class Image
{
    private $conn;
    private $table_name = "images";

    public $id;
    public $image_name;
    public $category;
    public $s3_url;
    public $uploaded_by;
    public $uploaded_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function uploadImage()
    {
        $query = "INSERT INTO " . $this->table_name . " (image_name, category, s3_url, uploaded_by, uploaded_at) VALUES (:image_name, :category, :s3_url, :uploaded_by, :uploaded_at)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':image_name', $this->image_name);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':s3_url', $this->s3_url);
        $stmt->bindParam(':uploaded_by', $this->uploaded_by);
        $stmt->bindParam(':uploaded_at', $this->uploaded_at);

        return $stmt->execute();
    }

    public function getAllImages()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getImageById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }
}
?>
