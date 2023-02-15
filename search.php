<?php session_start();
       if (isset($_SESSION['logged_in'])) {
   } else {
          header("location:notallowed.php");
   }
include "header.php";
    $Now = new DateTime('now');
    $Now = $Now->format('Y-m-d');
// $stmt = $pdo->prepare("SELECT task_id FROM tasks WHERE due_date < $Now AND status != 3");
// $stmt->execute();
// $tasks = $stmt->fetchAll();
// foreach ($tasks as $task) {
//     // Update the status of each task to "Late"
//     $iid = $task['task_id'];
//     $stmt = $pdo->prepare("UPDATE tasks SET status = 4 WHERE ID = $iid");
//     $stmt->execute();
// }
?>

<link rel="stylesheet" href="css/search.css">
<?php include "nav.php" ?>
<section class="search">
    <form action="" method="post">
        <fieldset>
            <div>
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date">
            </div>
            <div>
                <label for="due_date">Due Date:</label>
                <input type="date" id="due_date" name="due_date">
            </div>
            <div>
                <label for="priority">Priority:</label>
                <select id="priority" name="priority">
                    <option value="">All</option>
                    <option value="1">Low</option>
                    <option value="2">Medium</option>
                    <option value="3">High</option>
                </select>
            </div>
            <div>
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="All">All</option>
                    <option value="1">pending</option>
                    <option value="2">Active</option>
                    <option value="3">Finished</option>
                    <option value="4">Late</option>


                </select>
            </div>
            <div>
                <label for="member_name">Member Name:</label>
                <input type="text" id="member_name" name="member_name">
            </div>
            <input type="submit" value="Search">
        </fieldset>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $start_date = $_POST['start_date'];
        $due_date = $_POST['due_date'];
        $priority = $_POST['priority'];
        $status = $_POST['status'];
        $member_name = $_POST['member_name'];

        $late = 0;

        // Construct the SQL query based on the form inputs
        $sql = "SELECT task_id,title ,start_date,due_date, assigned_to,assigned_by, byy.photo as byph, too.photo as toph, byy.name as byname, too.name as toname, priority, status FROM tasks t, members too, members byy ";
        $query = " WHERE 1=1 and too.id=t.assigned_to and byy.id=t.assigned_by";

        if (!empty($start_date)) {
            $query .= " AND start_date='$start_date'";
        }
        if (!empty($due_date)) {
            $query .= " AND due_date='$due_date'";
        }
        if (!empty($priority) && $priority != 'All') {
            $query .= " AND priority=$priority";
        }
        if (!empty($status) && $status != 'All') {
            if ($status != 4) {
                $query .= " AND status=$status";
                $late = 2;
            } else
                $late = 1;
        }

        if (!empty($member_name)) {
            $query .= " AND too.name like '%$member_name%'";
            ;
        }

        // $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        // // Number of records to display per page
        // $records_per_page = 10;
        // // Calculate the start record
        // $start_from = ($page - 1) * $records_per_page;
        // // Add the limit clause to the query
        // $query . " LIMIT $start_from, $records_per_page";
    
        // Prepare and execute the query
    
        $total_records = $pdo->query("SELECT COUNT(*)  FROM tasks t, members too, members byy  $query ")->fetchColumn();
        if ($total_records == 0)
            echo "<h2>  No records found </h2> ";
        else {
            echo "<h4>  $total_records  records found </h4> ";
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

            $stmt = $pdo->prepare($sql . $query);
            $stmt->execute();

            // Fetch the results
            $tasks = $stmt->fetchAll();

            // Count the total number of records
    

            // Calculate the total number of pages
            // $total_pages = ceil($total_records / $records_per_page);
            // for ($i = 1; $i <= $total_pages; $i++) {
            //     echo "<a href='search.php?page=" . $i . "'>" . $i . "</a> ";
    
            // }
    
            foreach ($tasks as $row) { ?>
    <?php $st;
                    $pr = 1;
                    if (($row['status'] != 3) && ($row['due_date'] < $Now)) {
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
    }
    
            ?>

</section>
<?php include "footer.php" ?>