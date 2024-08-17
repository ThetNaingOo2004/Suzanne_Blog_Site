<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posts = json_decode(file_get_contents('./data/posts.json'), true);
    $id = end($posts)['id'] + 1;
    $posts[] = [
        'id' => $id,
        'title' => $_POST['title'],
        'author' => $_SESSION['username'],
        'content' => $_POST['content'],
        'date' => date('Y-m-d')
    ];
    file_put_contents('./data/posts.json', json_encode($posts));
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>New Post</title>
</head>
<body>


<div class="container">
    <h1 class="my-4">New Post</h1>
    <form method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>
</body>
</html>
