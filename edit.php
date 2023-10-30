<?php

require_once('connect.php');

$id = $_GET['id'];

if (isset($_POST['submit'])) {
    $newTitle = $_POST['title'];
    $newAuthorFirstName = $_POST['author_first_name'];
    $newAuthorLastName = $_POST['author_last_name'];
    $newYear = $_POST['year'];
    
    
    $stmt = $pdo->prepare('UPDATE books SET title = :title, release_date = :year WHERE id = :id');
    $stmt->execute(['title' => $newTitle, 'year' => $newYear, 'id' => $id]);
    
    
    $stmt = $pdo->prepare('UPDATE authors SET first_name = :author_first_name, last_name = :author_last_name WHERE id IN (SELECT author_id FROM book_authors WHERE book_id = :id)');
    $stmt->execute(['author_first_name' => $newAuthorFirstName, 'author_last_name' => $newAuthorLastName, 'id' => $id]);
}

$stmt = $pdo->prepare('SELECT books.*, authors.first_name, authors.last_name FROM books JOIN book_authors ON books.id = book_authors.book_id JOIN authors ON book_authors.author_id = authors.id WHERE books.id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Editing</title>
</head>
<body>
    <h1>Change database</h1>

    <form action="/edit.php?id=<?= $id; ?>" method="POST">
        <label for="title">Title:</label>
        <input value="<?= $book['title']; ?>" type="text" name="title"><br><br>
        
        <label for="author_first_name">Author First Name:</label>
        <input value="<?= $book['first_name']; ?>" type="text" name="author_first_name"><br><br>
        
        <label for="author_last_name">Author Last Name:</label>
        <input value="<?= $book['last_name']; ?>" type="text" name="author_last_name"><br><br>
        
        <label for="year">Year:</label>
        <input value="<?= $book['release_date']; ?>" type="text" name="year"><br><br>
        
        <input type="submit" value="Submit" name="submit">
    </form>
</body>
</html>