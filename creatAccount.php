<?php

?>
<?php
session_start();
include "conectdb.php";
if (isset($_POST['submit'])) {

    if (isset($_SESSION["mem_id"])) {
        $member_id = $_SESSION["mem_id"];
        $username = $_POST['username'];
        $password = $_POST['password'];
        echo $_SESSION["mem_id"];

        // Insert the user name and password into the database
        $query = "INSERT INTO `users` (`member_id`, `username`, `password`) VALUES (:member_id, :username, :password);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':member_id', $member_id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        echo $stmt->fetch();
        header("Location: index.php");
    }

    exit;

}
include "header.php";

?>
<link rel="stylesheet" href="css/account.css">
<section>
    <h1>Create eAccount</h1>

    <form action="" method="post" enctype="multipart/form-data">

        <fieldset>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" requiredmaxlength="5"> <br>
            <input type="submit" name="submit" value="Create Account">

        </fieldset>
    </form>
</section>
<?php
include "footer.php"
    ?>