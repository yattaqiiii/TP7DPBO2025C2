<?php
require_once 'config/db.php';

class Schedules {
    private $db;
    
    public function __construct() {
        $this->db = (new Database())->conn;
    }
    
    public function getAllSchedules() {
        $stmt = $this->db->query("SELECT Schedules.*, Movies.title FROM Schedules JOIN Movies ON Schedules.movie_id = Movies.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getScheduleById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Schedules WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function addSchedule($movie_id, $date, $time) {
        $stmt = $this->db->prepare("INSERT INTO Schedules (movie_id, date, time) VALUES (?, ?, ?)");
        return $stmt->execute([$movie_id, $date, $time]);
    }
    
    public function deleteSchedule($id) {
        $stmt = $this->db->prepare("DELETE FROM Schedules WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function updateSchedule($id, $movie_id, $date, $time) {
        $stmt = $this->db->prepare("UPDATE Schedules SET movie_id = ?, date = ?, time = ? WHERE id = ?");
        return $stmt->execute([$movie_id, $date, $time, $id]);
    }
}
?>

<!-- 
__construct()
getAllSchedules()
getScheduleById($id)
addSchedule($movie_id, $date, $time)
deleteSchedule($id)
updateSchedule($id, $movie_id, $date, $time)
-->