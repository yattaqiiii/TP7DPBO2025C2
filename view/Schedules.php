<h3>Schedule List</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Movie</th>
        <th>Date</th>
        <th>Time</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($schedule->getAllSchedules() as $s): ?>
    <tr>
        <td><?= $s['id'] ?></td>
        <td><?= $s['title'] ?></td>
        <td><?= $s['date'] ?></td>
        <td><?= $s['time'] ?></td>
        <td>
            <a href="?page=Schedules&edit=<?= $s['id'] ?>" class="btn-edit">Edit</a>
            <a href="?page=Schedules&delete=<?= $s['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this schedule?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
// Handle delete operation
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if ($schedule->deleteSchedule($_GET['delete'])) {
        echo "<div class='alert success'>Schedule deleted successfully!</div>";
    } else {
        echo "<div class='alert error'>Failed to delete schedule.</div>";
    }
    // Refresh the page to show updated data
    echo "<script>setTimeout(function(){ window.location.href = '?page=Schedules'; }, 1500);</script>";
}

// Check if we're in edit mode
$editMode = false;
$scheduleToEdit = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $editMode = true;
    $scheduleToEdit = $schedule->getScheduleById($_GET['edit']);
}
?>

<h3><?= $editMode ? 'Update' : 'Add' ?> Schedule</h3>
<form method="POST" class="schedule-form">
    <?php if($editMode): ?>
        <input type="hidden" name="schedule_id" value="<?= $scheduleToEdit['id'] ?>">
    <?php endif; ?>

    <div class="form-group">
        <label>Movie:</label>
        <select name="movie_id" required>
            <option value="">Select Movie</option>
            <?php foreach ($movie->getAllMovies() as $m): ?>
                <option value="<?= $m['id'] ?>" <?= ($editMode && $scheduleToEdit['movie_id'] == $m['id']) ? 'selected' : '' ?>>
                    <?= $m['title'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Date:</label>
        <input type="date" name="date" value="<?= $editMode ? $scheduleToEdit['date'] : '' ?>" required>
    </div>

    <div class="form-group">
        <label>Time:</label>
        <input type="time" name="time" value="<?= $editMode ? $scheduleToEdit['time'] : '' ?>" required>
    </div>

    <button type="submit" name="<?= $editMode ? 'update_schedule' : 'add_schedule' ?>">
        <?= $editMode ? 'Update' : 'Add' ?> Schedule
    </button>
    
    <?php if($editMode): ?>
        <a href="?page=Schedules" class="btn-cancel">Cancel</a>
    <?php endif; ?>
</form>

<?php 
// Handle add operation
if (isset($_POST['add_schedule'])) {
    if ($schedule->addSchedule($_POST['movie_id'], $_POST['date'], $_POST['time'])) {
        echo "<div class='alert success'>Schedule added successfully!</div>";
    } else {
        echo "<div class='alert error'>Failed to add schedule.</div>";
    }
    echo "<script>setTimeout(function(){ window.location.href = '?page=Schedules'; }, 1500);</script>";
}

// Handle update operation
if (isset($_POST['update_schedule'])) {
    if ($schedule->updateSchedule($_POST['schedule_id'], $_POST['movie_id'], $_POST['date'], $_POST['time'])) {
        echo "<div class='alert success'>Schedule updated successfully!</div>";
    } else {
        echo "<div class='alert error'>Failed to update schedule.</div>";
    }
    echo "<script>setTimeout(function(){ window.location.href = '?page=Schedules'; }, 1500);</script>";
}
?>