<?php
require_once 'config/db.php';

class Tickets {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllTickets() {
        $stmt = $this->db->query("SELECT Tickets.*, Movies.title, Schedules.date, Schedules.time
                                  FROM Tickets
                                  JOIN Schedules ON Tickets.schedule_id = Schedules.id
                                  JOIN Movies ON Schedules.movie_id = Movies.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTicket($schedule_id, $name, $seat_number) {
        $stmt = $this->db->prepare("INSERT INTO Tickets (schedule_id, name, seat_number) VALUES (?, ?, ?)");
        return $stmt->execute([$schedule_id, $name, $seat_number]);
    }

    public function deleteTicket($id) {
        $stmt = $this->db->prepare("DELETE FROM Tickets WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getViewersByMovieTitle($title) {
        $stmt = $this->db->prepare("
            SELECT Tickets.name, Tickets.seat_number, Movies.title, Schedules.date, Schedules.time
            FROM Tickets
            JOIN Schedules ON Tickets.schedule_id = Schedules.id
            JOIN Movies ON Schedules.movie_id = Movies.id
            WHERE Movies.title LIKE ?
        ");
        $stmt->execute(["%$title%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!-- 
__construct()
getAllTickets()
addTicket($schedule_id, $name, $seat_number)
deleteTicket($id)
getViewersByMovieTitle($title)
-->