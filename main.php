<?php
require_once('connect.php');

$stmt = $pdo->query('SELECT id, title FROM books');
$stmt->setFetchMode(PDO::FETCH_ASSOC);
    ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <ul>
        <?php
        while ($row = $stmt->fetch()) {
            echo "<li><a href='book.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></li>";
        }
        ?>
    </ul>


</body>

</html>