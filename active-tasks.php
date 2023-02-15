<?php
session_start();    
   if (isset($_SESSION['logged_in'])) {
} else {
        header("location:notallowed.php");
}
include "header.php";
   include "conectdb.php";
?>
<link rel="stylesheet" href="css/table.css">
<?php include "nav.php" ?>
<section>
    <?php

    $Now = new DateTime('now');
    $Now = $Now->format('Y-m-d');

// Get all tasks with a due date in the past
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE  status =2 and due_date > $Now ");
$stmt->execute();
$total_records  = $stmt->fetchColumn();

        // $total_records = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();

        if($total_records == 0){
    echo '<br><br><br><center><h2>Thare is no tasks Active</h2></center>';
    
        }else{

        echo "    <table>
        <tr>
            <th>Task Title</th>
            <th>start_date</th>
            <th>due_date</th>
            <th>assigned_by</th>
            <th>Assigned To</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>";
        $late = 0;

        // Construct the SQL query based on the form inputs
        $query = "SELECT task_id,title ,start_date,due_date, assigned_to,assigned_by, byy.photo as byph, too.photo as toph, byy.name as byname, too.name as toname, priority, status FROM tasks t, members too, members byy WHERE 1=1 and too.id=t.assigned_to and byy.id=t.assigned_by and due_date > '$Now' AND status !=3 and status =2 " ;


        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        // Number of records to display per page
        $records_per_page = 10;
        // Calculate the start record
        $start_from = ($page - 1) * $records_per_page;
        // Add the limit clause to the query
        $query . " LIMIT $start_from, $records_per_page";

        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        // Fetch the results
        $tasks = $stmt->fetchAll();

        // // Count the total number of records
        // $total_records = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();
        // // Calculate the total number of pages
        // $total_pages = ceil($total_records / $records_per_page);
        // for ($i = 1; $i <= $total_pages; $i++) {
        //     echo "<a href='search.php?page=" . $i . "'>" . $i . "</a> ";

        // }

        foreach ($tasks as $row) { ?>
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
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['start_date']; ?></td>
        <td><?php echo $row['due_date']; ?></td>
        <td>
            <img src="<?php echo $row['byph']; ?>">
            </img> <?php echo $row['byname']; ?>
        </td>
        <td> <img src="<?php echo $row['toph']; ?>">
            </img><?php echo $row['toname']; ?></td>
        <td><?php echo $pr ?></td>
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
        echo '</tbody>';
        echo "</table>";
    }
    
            ?>

</section>
<?php include "footer.php" ?>