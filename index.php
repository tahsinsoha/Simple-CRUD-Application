<?php
require_once "pdo.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sabiha Tahsin Soha</title>
</head>
<h1>Welcome to Automobiles Database</h1>

<body>
    <?php
    if (!isset($_SESSION['pp'])) {
        echo ('<a href="login.php">Please log in</a>');
        echo ('<p>Attempt to <a href="add.php">add data</a>without logging in</p>');
    } else {

        if (isset($_SESSION['success'])) {
            echo ('<p style="color: green;">' . htmlentities($_SESSION["success"]) . "</p>\n");
            unset($_SESSION["success"]);
        }
        echo ('<br><a href="add.php">Add New Entry</a></br>');
        echo ('<br><a href="logout.php">Logout</a></br>');

        $stmt = $pdo->query("SELECT make, model, year,mileage, autos_id FROM autos");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if($row==0){
            $_SESSION['error'] = 'No rows found';
            header( 'Location: index.php' ) ;
            return;
          }
           else {
        echo ('<table border="1">' . "\n");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>";
            echo (htmlentities($row['make']));
            echo ("</td><td>");
            echo (htmlentities($row['model']));
            echo ("</td><td>");
            echo (htmlentities($row['year']));
            echo ("</td><td>");
            echo (htmlentities($row['mileage']));
            echo ("</td><td>");
            echo ('<a href="edit.php?autos_id=' . $row['autos_id'] . '">Edit</a> / ');
            echo ('<a href="delete.php?autos_id=' . $row['autos_id'] . '">Delete</a>');
            echo ("</td></tr>\n");
        }
    }
    }



    ?>
    </table>
</body>

</html>