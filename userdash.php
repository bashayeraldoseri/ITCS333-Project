<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <div class = "userdash-container">
        <?php
        session_start();
        include('database/db.php');
        $sql = "SELECT ProfilePic FROM users WHERE ID = ?";
        $statement = $pdo->prepare($sql);
        $id = $_SESSION['user_id'];
        $statement->execute([$id]);
        $picture = $statement->fetch();

        if (!isset($picture)){
            echo "picture not found";
        } else {
            echo "<img src=\"" . $picture ."\"". " alt=\"Photo from database\">";
        }
        ?>
    </div>
</body>
</html>