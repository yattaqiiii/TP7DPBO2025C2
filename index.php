<?php
require_once 'class/Movies.php';
require_once 'class/Schedules.php';
require_once 'class/Tickets.php';

$movie = new Movies();
$schedule = new Schedules();
$ticket = new Tickets();

// Tambah tiket (penonton beli tiket)
if (isset($_POST['buy'])) {
    $ticket->addTicket($_POST['schedule_id'], $_POST['name'], $_POST['seat_number']);
}

// Search film
$search_result = [];
$searched = false;
if (isset($_GET['search_title']) && !empty($_GET['search_title'])) {
    $searched = true;
    $search_result = $ticket->getViewersByMovieTitle($_GET['search_title']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cinema Booking System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'view/header.php'; ?>
    <main>
        <h2>Welcome to Cinema Booking System</h2>
        <nav>
            <a href="?page=Movies">Movies</a> |
            <a href="?page=Schedules">Schedules</a> |
            <a href="?page=Tickets">Tickets</a>
        </nav>

        <!-- Search section -->
        <section>
            <h3>Search Viewers by Movie Title</h3>
            <form method="get" class="search-form">
                <input type="text" name="search_title" placeholder="Enter movie title..." value="<?= $_GET['search_title'] ?? '' ?>" required>
                <button type="submit" class="btn-primary">Search</button>
            </form>
            
            <?php if ($searched): ?>
                <?php if (!empty($search_result)): ?>
                    <div class="search-results success">
                        <h4>Search Result for "<?= htmlspecialchars($_GET['search_title']) ?>":</h4>
                        <ul class="viewer-list">
                            <?php foreach ($search_result as $viewer): ?>
                                <li class="viewer-item">
                                    <span class="viewer-name"><?= htmlspecialchars($viewer['name']) ?></span>
                                    <span class="seat-number">Seat <?= $viewer['seat_number'] ?></span>
                                    <span class="movie-info"><?= $viewer['title'] ?> @ <?= $viewer['date'] ?> <?= $viewer['time'] ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="search-results warning">
                        <p>No viewers found for the movie title "<?= htmlspecialchars($_GET['search_title']) ?>". Please try another search term.</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </section>

        <!-- Load dynamic page -->
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == 'Movies') include 'view/Movies.php';
            elseif ($page == 'Schedules') include 'view/Schedules.php';
            elseif ($page == 'Tickets') include 'view/Tickets.php';
        }
        ?>
    </main>
    <?php include 'view/footer.php'; ?>
</body>
</html>