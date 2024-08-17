<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$posts = json_decode(file_get_contents('./data/posts.json'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    foreach ($posts as &$post) {
        if ($post['id'] == $id && $post['author'] == $_SESSION['username']) {
            $post['title'] = $_POST['title'];
            $post['content'] = $_POST['content'];
            break;
        }
    }
    file_put_contents('./data/posts.json', json_encode($posts));
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];
foreach ($posts as $post) {
    if ($post['id'] == $id) {
        $title = $post['title'];
        $content = $post['content'];
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
    <title>Edit Post</title>
</head>
<body>


<div class="container">
    <h1 class="my-4">Edit Post</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($title) ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required><?= htmlspecialchars($content) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary" href="index.html">Update Post</button>
        <a href="index.html" class="btn btn-secondary">Cancel</a>

    </form>
</div>
</body>
</html>
