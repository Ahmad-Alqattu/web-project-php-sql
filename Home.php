<?php
session_start();
if (isset($_SESSION['logged_in'])) {
} else {
    header("location:notallowed.php");
}
include "conectdb.php";

?>

<link rel="stylesheet" href="css/home.css" />

<body>
    <?php include 'header.php';
    ?>

    <main id="contant">
        <?php include 'nav.php'; ?>

        <section class=>
            <table>
                <thead>
                    <tr>
                        <th>Task Title</th>
                        <th>start_date</th>
                        <th>due_date</th>
                        <th>Assigned To</th>
                        <th>assigned_by</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "conectdb.php";
                    $Now = new DateTime('now');
                    $Now = $Now->format('Y-m-d');
                    $query = "SELECT task_id,title ,start_date,due_date, assigned_to,assigned_by, byy.photo as byph, too.photo as toph, byy.name as byname, too.name as toname, priority, status FROM tasks t, members too, members byy WHERE 1=1 and too.id=t.assigned_to and byy.id=t.assigned_by and t.due_date = '$Now'";

        $total_records = $pdo->query("SELECT COUNT(*)  FROM tasks t, members too, members byy WHERE 1=1 and too.id=t.assigned_to and byy.id=t.assigned_by and t.due_date = '$Now' ")->fetchColumn();
        if ($total_records == 0)
            echo "<center><h1>  No tasks today found </h1></center> ";
                    else {
                        echo "<center> <h3>  yeu have ($total_records)  tasks today </h3> </center> ";
                        $result = $pdo->prepare($query);
                        $result->execute();
                        while ($row = $result->fetch()) {

                            ?>
                    <?php $st;
                    $pr = 1;
                    if (($row['status'] != 3) && $row['due_date'] < $Now) {
                        $st = 'Late';
                    } else if ($row['status'] == 2)
                        $st = 'Active';
                    else if ($row['status'] == 1)
                        $st = 'pending';
                    else
                        $st = 'Finished';
                    if ($late == 1) {
                        if ($st != 'Late') {
                            continue;
                        }
                    } else if ($late == 2) {
                        if ($st == 'Late') {
                            continue;
                        }
                    }
                    //  }else if($active){
            
                    //  }
            

                    if ($row['priority'] === 1)
                        $pr = 'Low';
                    else if ($row['priority'] == 2)
                        $pr = 'Medium';
                    else
                        $pr = 'High';
                    ?>
                    <tr>
                        <td>
                            <?php echo $row['title']; ?>
                        </td>
                        <td>
                            <?php echo $row['start_date']; ?>
                        </td>
                        <td>
                            <?php echo $row['due_date']; ?>
                        </td>
                        <td>
                            <img src="<?php echo $row['byph']; ?>">
                            </img>
                            <?php echo $row['byname']; ?>
                        </td>
                        <td> <img src="<?php echo $row['toph']; ?>">
                            </img>
                            <?php echo $row['toname']; ?>
                        </td>
                        <td>
                            <?php echo $pr ?>
                        </td>
                        <td class=<?php echo $st ?>><?php echo $st; ?></td>
                        <td>
                            <a href=" view_task.php?task_id=<?php echo $row['task_id']; ?>">
                                <?php if ($_SESSION['member_id'] == $row['assigned_by'] || $_SESSION['member_id'] == $row['assigned_to'])
                                    echo 'View & Edit';
                                else
                                    echo 'View'
                                        ?>
                            </a>
                        </td>
                    </tr>
                    <?php
                        }
                    }

                    ?>
                </tbody>
            </table>

        </section>
    </main>
    <?php include 'footer.php'; ?>

</body>

</html>