<?php
require_once 'config/db.php';

class Movies {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllMovies() {
        $stmt = $this->db->query("SELECT * FROM Movies");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMovieById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Movies WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMovieByTitle($title) {
        $stmt = $this->db->prepare("SELECT * FROM Movies WHERE title LIKE ?");
        $stmt->execute(["%$title%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMovie($title, $genre, $duration, $rating) {
        $stmt = $this->db->prepare("INSERT INTO Movies (title, genre, duration, rating) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $genre, $duration, $rating]);
    }

    public function deleteMovie($id) {
        $stmt = $this->db->prepare("DELETE FROM Movies WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateMovie($id, $title, $genre, $duration, $rating) {
        $stmt = $this->db->prepare("UPDATE Movies SET title = ?, genre = ?, duration = ?, rating = ? WHERE id = ?");
        return $stmt->execute([$title, $genre, $duration, $rating, $id]);
    }
}
?>

<!-- 
__construct()
getAllMovies()
getMovieById()
getMovieByTitle()
addMovie($title, $genre, $duration, $rating)
deleteMovie($id)
updateMovie($id, $title, $genre, $duration, $rating)
-->