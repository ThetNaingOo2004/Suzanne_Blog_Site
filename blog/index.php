<?php
session_start(); // Start the session to manage user login state
$posts = json_decode(file_get_contents('./data/posts.json'), true);
$isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Suzanne_Blog_Site</title>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Suzanne_Blog_Site</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <?php if ($isLoggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="post.php">Create Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="singup.php">Signup</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container">
    <h1 class="my-4">Suzanne_Blog_Site</h1>
    
    <?php foreach ($posts as $post): ?>
        <div class="card my-4">
            <div class="card-body">
                <h2 class="card-title"><?= htmlspecialchars($post['title']) ?></h2>

                <!-- Display a snippet of the content with a 'Read More' button -->
                <p class="card-text">
                    <?php 
                    $contentSnippet = substr($post['content'], 0, 50);
                    echo nl2br(htmlspecialchars($contentSnippet));
                    if (strlen($post['content']) > 100): 
                    ?>
                        ... <a href="read.php?id=<?= $post['id'] ?>">Read More</a>
                    <?php endif; ?>
                </p>

                <p class="text-muted">By : <?= htmlspecialchars($post['author']) ?> on <?= htmlspecialchars($post['date']) ?></p>
                
                <?php if ($isLoggedIn && $_SESSION['username'] === $post['author']): ?>
                    <!-- Edit and Delete Buttons for the Author -->
                    <a href="edit.php?id=<?= $post['id'] ?>" class="btn btn-primary">Edit</a>
                    <a href="delete.php?id=<?= $post['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>