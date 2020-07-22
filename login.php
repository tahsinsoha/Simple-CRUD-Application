<?php
session_start();
if (isset($_POST['cancel'])) {

    header("Location: index.php");
    return;
}
if (isset($_POST["email"]) && isset($_POST["pass"])) {
    unset($_SESSION["who"]);
    $_SESSION["who"] = $_POST["email"];
    $_SESSION["error"] = false;
    $_SESSION["success"] = false;
    if (empty($_POST["email"]) || empty($_POST["pass"])) {
        $_SESSION["error"] = "Email and password are required";
        header('Location: login.php');
        return;
    } elseif (strpos($_POST["email"], '@') == false) {
        $_SESSION["error"] = "Email must have an at-sign (@)";
        header('Location: login.php');
        return;
    } else {
        $salt = 'XyZzy12*_';
        $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
        $n = $salt . $_POST['pass'];
        $md5 = hash('md5', $n);

        if ($md5 ==  $stored_hash) {

            $_SESSION["who"] = $_POST["email"];
            $_SESSION["pp"] = true;
            header('Location: index.php');
            return;
        } else {
            $_SESSION["error"] = "Incorrect Password";
            header('Location: login.php');
            return;
        }
    }
}

?>
<html>

<head>
    <title>Sabiha Tahsin Soha</title>
    <link href="style.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <h1>Please Log In</h1>
        <?php
        if (isset($_SESSION["error"])) {
            echo ('<p style="color: red;">' . htmlentities($_SESSION["error"]) . "</p>\n");
            unset($_SESSION["error"]);
        }
        ?>
        <form method="POST">
            <label for="nam">User Name</label>
            <input type="text" name="email" id="nam"><br />
            <label for="id_1723">Password</label>
            <input type="text" name="pass" id="id_1723"><br />
            <input type="submit" value="Log In">
            <input type="submit" name="cancel" value="Cancel">
        </form>
        </p>
    </div>
</body>

</html>