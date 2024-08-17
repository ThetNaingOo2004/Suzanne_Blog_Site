<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$posts = json_decode(file_get_contents('./data/posts.json'), true);
$id = $_GET['id'];

foreach ($posts as $key => $post) {
    if ($post['id'] == $id) {
        $postToDelete = $post;
        $postKey = $key;
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Remove the post from the array
    unset($posts[$postKey]);

    // Reindex the array to ensure it has consecutive keys
    $posts = array_values($posts);

    // Save the updated posts back to the JSON file
    file_put_contents('./data/posts.json', json_encode($posts, JSON_PRETTY_PRINT));

    // Redirect to the dashboard after deleting
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<div class="container">
    <h2>Delete Post</h2>
    <form method="POST" action="">
        <div class="alert alert-warning">
            Are you sure you want to delete this post?
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($postToDelete['title']); ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" disabled><?php echo htmlspecialchars($postToDelete['content']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-danger">Delete Post</button>
        <a href="index.html" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
