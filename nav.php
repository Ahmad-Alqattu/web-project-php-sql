        <?php
        include "conectdb.php";

        $Now = new DateTime('now');
        $Now = $Now->format('Y-m-d');
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE  status !=3 and due_date < '$Now' ");
        $stmt->execute();
        $late = $stmt->fetchColumn();

        // Get all tasks with a due date in the past
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE status =1 and due_date >= '$Now' ");
        $stmt->execute();
        $pending = $stmt->fetchColumn();


        // Get all tasks with a due date in the past
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE  status =2 and due_date > '$Now' ");
        $stmt->execute();
        $active = $stmt->fetchColumn();
        ?>
        <link rel="stylesheet" href="css/nav.css" />
        <main id="content">
            <nav id="main-nav">
                <ul>
                    <li><a href="Home.php">Home page</a></li>
                    <li><a href="search.php">Search page</a></li>
                    <li><a href="add-task.php">Add new task</a></li>
                    <li><a href="late-tasks.php">Late tasks > <span><?php echo $late ?></span></a></li>
                    <li><a href="pending-tasks.php">Pending tasks > <span><?php echo $pending ?></span></a></li>
                    <li><a href="active-tasks.php">Active tasks > <span><?php echo $active ?></span></a></li>
                </ul>
            </nav>