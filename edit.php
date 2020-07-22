<?php
require_once "pdo.php";
session_start();

if (
    isset($_POST['make']) && isset($_POST['model'])
    && isset($_POST['year']) && isset($_POST['mileage']) &&  isset($_POST['id'])
) {
    if (empty($_POST["make"]) || empty($_POST["model"]) || empty($_POST["year"]) || empty($_POST["mileage"])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?autos_id=" . $_REQUEST['id']);
        return;
    } elseif (!is_numeric($_POST['year'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?autos_id=" . $_REQUEST['id']);
        return;
    } elseif (!is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?autos_id=" . $_REQUEST['id']);
        return;
    }

    $sql = "UPDATE autos SET make = :make, model= :model,
            year = :year, mileage = :mileage
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':autos_id' => $_POST['id']
    ));
    $_SESSION["success"] = "Record edited";
    header('Location: index.php');
    return;
}

// Guardian: Make sure that user_id is present
if (!isset($_GET['autos_id'])) {

    $_SESSION['error'] = "All fields are required";
    header("Location: edit.php?autos_id=" . $_REQUEST['id']);
    return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = "All fields are required";
    header("Location: edit.php?autos_id=" . $_REQUEST['id']);
    return;
}

// Flash pattern
if (isset($_SESSION['error'])) {
    echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
    unset($_SESSION['error']);
}

$n = htmlentities($row['make']);
$e = htmlentities($row['model']);
$p = htmlentities($row['year']);
$q = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>
<p>Edit User</p>
<form method="post">
    <p>Make:
        <input type="text" name="make" value="<?= $n ?>"></p>
    <p>Model:
        <input type="text" name="model" value="<?= $e ?>"></p>
    <p>Year:
        <input type="text" name="year" value="<?= $p ?>"></p>
    <p>Mileage:
        <input type="text" name="mileage" value="<?= $q ?>"></p>
    <input type="hidden" name="id" value="<?= $autos_id ?>">
    <p><input type="submit" value="Save" />
        <a href="index.php">Cancel</a></p>
</form>