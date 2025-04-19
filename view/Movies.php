<h3>Movie List</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Genre</th>
        <th>Duration (minutes)</th>
        <th>Rating</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($movie->getAllMovies() as $m): ?>
    <tr>
        <td><?= $m['id'] ?></td>
        <td><?= $m['title'] ?></td>
        <td><?= $m['genre'] ?></td>
        <td><?= $m['duration'] ?></td>
        <td><?= $m['rating'] ?></td>
        <td>
            <a href="?page=Movies&edit=<?= $m['id'] ?>" class="btn-edit">Edit</a>
            <a href="?page=Movies&delete=<?= $m['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this movie? This will also delete all related schedules and tickets.')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
// Handle delete operation
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if ($movie->deleteMovie($_GET['delete'])) {
        echo "<div class='alert success'>Movie deleted successfully!</div>";
    } else {
        echo "<div class='alert error'>Failed to delete movie. It may have related schedules or tickets.</div>";
    }
    // Refresh the page to show updated data
    echo "<script>setTimeout(function(){ window.location.href = '?page=Movies'; }, 1500);</script>";
}

// Check if we're in edit mode
$editMode = false;
$movieToEdit = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $editMode = true;
    $movieToEdit = $movie->getMovieById($_GET['edit']);
}
?>

<h3><?= $editMode ? 'Update' : 'Add' ?> Movie</h3>
<form method="POST" class="movie-form">
    <?php if($editMode): ?>
        <input type="hidden" name="movie_id" value="<?= $movieToEdit['id'] ?>">
    <?php endif; ?>

    <div class="form-group">
        <label>Title:</label>
        <input type="text" name="title" placeholder="Movie Title" value="<?= $editMode ? $movieToEdit['title'] : '' ?>" required>
    </div>

    <div class="form-group">
        <label>Genre:</label>
        <input type="text" name="genre" placeholder="Genre (e.g. Action, Comedy)" value="<?= $editMode ? $movieToEdit['genre'] : '' ?>">
    </div>

    <div class="form-group">
        <label>Duration (minutes):</label>
        <input type="number" name="duration" placeholder="Duration in minutes" value="<?= $editMode ? $movieToEdit['duration'] : '' ?>">
    </div>

    <div class="form-group">
        <label>Rating:</label>
        <input type="text" name="rating" placeholder="Rating (e.g. PG-13, R)" value="<?= $editMode ? $movieToEdit['rating'] : '' ?>">
    </div>

    <button type="submit" name="<?= $editMode ? 'update_movie' : 'add_movie' ?>" class="btn-primary">
        <?= $editMode ? 'Update' : 'Add' ?> Movie
    </button>
    
    <?php if($editMode): ?>
        <a href="?page=Movies" class="btn-cancel">Cancel</a>
    <?php endif; ?>
</form>

<?php 
// Handle add operation
if (isset($_POST['add_movie'])) {
    if ($movie->addMovie($_POST['title'], $_POST['genre'], $_POST['duration'], $_POST['rating'])) {
        echo "<div class='alert success'>Movie added successfully!</div>";
    } else {
        echo "<div class='alert error'>Failed to add movie.</div>";
    }
    echo "<script>setTimeout(function(){ window.location.href = '?page=Movies'; }, 1500);</script>";
}

// Handle update operation
if (isset($_POST['update_movie'])) {
    if ($movie->updateMovie($_POST['movie_id'], $_POST['title'], $_POST['genre'], $_POST['duration'], $_POST['rating'])) {
        echo "<div class='alert success'>Movie updated successfully!</div>";
    } else {
        echo "<div class='alert error'>Failed to update movie.</div>";
    }
    echo "<script>setTimeout(function(){ window.location.href = '?page=Movies'; }, 1500);</script>";
}
?>