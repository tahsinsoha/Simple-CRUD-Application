<?php
// Demand a GET parameter
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['who']) ) {
    die('ACCESS DENIED');
}
// If the user requested logout go back to index.php


elseif (isset($_POST['make']) && isset($_POST['year'])
    && isset($_POST['mileage']) && isset($_POST['model'])) {
        if (empty($_POST["make"]) || empty($_POST["model"]) || empty($_POST["year"]) || empty($_POST["mileage"])) {
            $_SESSION["error"] = "All fields are required";
            header('Location: add.php');
            return;
        }

	elseif (!is_numeric($_POST['year'])) {
        $_SESSION["error"] = "Year must be numeric";
        header('Location: add.php');
        return;
       // $failure = 'Mileage and year must be numeric';
    }	
    elseif (!is_numeric($_POST['mileage'])) {
        $_SESSION["error"] = "Mileage must be numeric";
        header('Location: add.php');
        return;
       // $failure = 'Mileage and year must be numeric';
    }	
    

	else{
       
		
        $sql = "INSERT INTO autos (make, model, year,mileage)
        VALUES (:make, :model, :year, :mileage)";
          $stmt = $pdo->prepare($sql);
			$stmt->execute(array(
                ':make' => $_POST['make'],
                ':model' => $_POST['model'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage']));
            $_SESSION["success"] = "Record added";
            header('Location: index.php');
            return;
			
		}
    }



?>
<!DOCTYPE html>
<html>
<head>
<title>Sabiha Tahsin Soha</title>
<?php  ?>
</head>
<body>
<div class="container">
 <h1>Tracking Autos for <?php echo $_SESSION['who']; ?></h1>
 
 <?php
    if ( isset($_SESSION["error"])) {
        echo ('<p style="color: red;">' . htmlentities($_SESSION["error"]) . "</p>\n");
            unset($_SESSION["error"]);
    }
   
    ?>
 

<form method="post">
        <p>Make:
            <input type="text" name="make" size="40"></p>
            <p>Model:
            <input type="text" name="model"></p>
        <p>Year:
            <input type="text" name="year"></p>
        <p>Mileage:
            <input type="text" name="mileage"></p>
        <p><input type="submit" value="Add"  name= "add"/>
        
      
</form>

</div>
</body>	