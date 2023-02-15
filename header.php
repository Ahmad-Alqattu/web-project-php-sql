<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" type="txt/css" href="css/style.css">

    <title>Ahmad AL-Qattu</title>
</head>

<body>
    <header>
        <div>
            <a href="Home.php" class="logo"><img src="img\clipart-transparent-team-work-1.png" alt="">Tasks.com</a>

        </div>

        <nav class="navigation">
            <nav>
                <ul>
                    <li><a href="#biography">About us</a></li>
                    <li><a href="#time-table">Contact us</a></li>
                </ul>

            </nav>
            <?php
            if (isset($_SESSION['logged_in'])) {
                if ($_SESSION['logged_in']) {
                    include "conectdb.php";
                    $username = $_SESSION['member_id'];
                    $query = "SELECT photo , name from members WHERE id =$username";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $row = $stmt->fetch();
                    ?>
            <div>

                <a href="logout.php"><img src="img\logout.png" alt="">log out</a>
                <a href="Home.php">
                    <?php echo $row["name"]  ?>
                    <img src="<?php
                                    echo $row["photo"];
                                    ?>" alt="">
                </a>


            </div>
            <?php
                }
            } ?>
        </nav>

    </header>