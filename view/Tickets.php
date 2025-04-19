<h3>Ticket List</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Movie</th>
        <th>Date</th>
        <th>Time</th>
        <th>Name</th>
        <th>Seat Number</th>
    </tr>
    <?php foreach ($ticket->getAllTickets() as $t): ?>
    <tr>
        <td><?= $t['id'] ?></td>
        <td><?= $t['title'] ?></td>
        <td><?= $t['date'] ?></td>
        <td><?= $t['time'] ?></td>
        <td><?= $t['name'] ?></td>
        <td><?= $t['seat_number'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Buy Ticket</h3>
<form method="POST">
    <label>Schedule:</label>
    <select name="schedule_id">
        <?php foreach ($schedule->getAllSchedules() as $s): ?>
            <option value="<?= $s['id'] ?>"><?= $s['title'] ?> - <?= $s['date'] ?> <?= $s['time'] ?></option>
        <?php endforeach; ?>
    </select>
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="text" name="seat_number" placeholder="Seat (e.g. A1)" required>
    <button type="submit" name="buy">Buy</button>
</form>
