<?php
require_once('connect.php');

$hello = "Books Category";


if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $pdo->prepare('SELECT id, title FROM books WHERE title LIKE ?');
    $stmt->execute(["%$search%"]);
} else {
    $stmt = $pdo->query('SELECT id, title FROM books');
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: black;
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            text-align: center;
        }

        .header {
            background-color: black;
            text-align: center;
            padding: 40px;
        }

        .header h1 {
            font-size: 48px;
            margin: 0;
            color: white;
            animation: coolAnimation 2s infinite alternate;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
            padding: 0;
            list-style-type: none;
            margin-top: 20px;
        }

        li {
            text-align: center;
        }

        a {
            color: white;
            text-decoration: none;
        }

        @keyframes coolAnimation {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.1);
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Books Category</h1>
    </div>

    <div class="container">
        <form method="get">
            <input type="text" name="search" placeholder="Search for a book" value="<?php echo isset($search) ? $search : ''; ?>">
            <button type="submit">Search</button>
        </form>
        <ul class="list">
            <?php
            while ($row = $stmt->fetch()) {
                echo "<li><a href='book.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></li>";
            }
            ?>
        </ul>
    </div>
</body>

</html>