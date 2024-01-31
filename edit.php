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
$book = $stmt
