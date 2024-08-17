<?php
session_start();
$posts = json_decode(file_get_contents('./data/posts.json'), true);
$id = $_GET['id'];

foreach ($posts as $post) {
    if ($post['id'] == $id) {
        $title = $post['title'];
        $author = $post['author'];
        $content = $post['content'];
        $date = $post['date'];
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= htmlspecialchars($title) ?></title>
</head>
<body>



<div class="container">
    <h1 class="my-4"><?= htmlspecialchars($title) ?></h1>
    <p class="text-muted">By <?= htmlspecialchars($author) ?> on <?= htmlspecialchars($date) ?></p>
    <div class="card">
        <div class="card-body">
            <p><?= nl2br(htmlspecialchars($content)) ?></p>
        </div>
    </div>

    <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $author): ?>
        <!-- Edit and Delete Buttons for the Author -->
        <a href="edit.php?id=<?= $id ?>" class="btn btn-primary mt-3">Edit</a>
        <a href="delete.php?id=<?= $id ?>" class="btn btn-danger mt-3" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
    <?php endif; ?>
    
    <a href="index.php" class="btn btn-secondary mt-3">Back to Blog</a>
</div>
</body>
</html>
