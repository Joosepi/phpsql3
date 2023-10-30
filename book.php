<?php
require_once('connect.php');

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('SELECT * FROM book_authors ba LEFT JOIN authors a ON ba.author_id=a.id WHERE book_id = :id');
$stmt->execute(['id' => $id]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $book['title']; ?> - Book Presentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
        }

        span {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1><?php echo $book['title']; ?></h1>
        <?php
        echo '<span>Author(s): ';
        $authors = array(); 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $authors[] = $row['first_name'] . ' ' . $row['last_name'];
        }
        echo implode(', ', $authors); 
        echo '</span>';
        ?>
        <span><?php echo 'Year: ' . $book['release_date']; ?></span>
    </div>


    <a href="./edit.php?id=<?= $id; ?>">muuda</a>

</html>
</body>

</html>
