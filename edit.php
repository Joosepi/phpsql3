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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label, input {
            display: block;
            margin: 10px 0;
        }

        input[type="submit"] {
            background-color: #262626;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Change database</h1>

    <form action="/edit.php?id=<?= $id; ?>" method="POST">
        <label for="title">Title:</label>
        <input value="<?= $book['title']; ?>" type="text" name="title">
        
        <label for="author_first_name">Author First Name:</label>
        <input value="<?= $book['first_name']; ?>" type="text" name="author_first_name">
        
        <label for="author_last_name">Author Last Name:</label>
        <input value="<?= $book['last_name']; ?>" type="text" name="author_last_name">
        
        <label for="year">Year:</label>
        <input value="<?= $book['release_date']; ?>" type="text" name="year">
        
        <input type="submit" value="Submit" name="submit">
    </form>
</body>
</html>
