<?php
session_start();
include "conectdb.php";
// Get the form data


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Prepare the SQL statement
    $query = "SELECT  * from users WHERE username = ? AND password = ? limit 1;";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array($username, $password));
    $row = $stmt->fetch();
    $count = $stmt->rowcount();

    if ($count > 0) {
        // The password is correct, set the session variable
        $_SESSION['logged_in'] = true;
        $_SESSION['member_id'] = $row['member_id'];

        // Redirect to the protected page
        header("location:Home.php");
        exit();
    } else {
        // The password is incorrect, return an error message
        $errors['password'] = 'Password or User Name is incorrect';
    }
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/login.css" />
    <title>Tasks</title>
</head>

<body>
    <?php include 'header.php' ?>

    <section class="login">
        <h1>login</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <fieldset id="login">
                <?php if (isset($errors['password'])): ?>
                <br><span class="error">*
                    <?php echo $errors['password']; ?>
                </span>
                <?php endif; ?>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <input type="submit" name="submit" value="Submit">
                <a href="reg.php">Signin</a>

            </fieldset>
        </form>
    </section>

    <?php include "footer.php" ?>
</body>

</html>