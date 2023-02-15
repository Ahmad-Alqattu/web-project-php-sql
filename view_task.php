<title>Task Details</title>
<?php
session_start();
if (isset($_SESSION['logged_in'])) {
} else {
    header("location:notallowed.php");
}
include "header.php";
include "conectdb.php";
$task_id = $_GET['task_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $st = $_POST['status'];
    $ds = $_POST['description'];
    $sql = "UPDATE tasks SET status = $st , description = '$ds' where task_id= $task_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $task = $stmt->fetch();
}


$sql = "SELECT task_id,title ,start_date,due_date, description, assigned_to,assigned_by, byy.photo as byph, too.photo as toph, byy.name as byname, too.name as toname, priority, status FROM tasks t, members too, members byy WHERE 1=1 and too.id=t.assigned_to and byy.id=t.assigned_by and task_id = :task_id limit 1;";

// Prepare the SELECT statement
$stmt = $pdo->prepare($sql);
// Bind the task ID parameter
$stmt->bindParam(':task_id', $task_id);
$stmt->execute();
$task = $stmt->fetch();



?>

<link rel="stylesheet" href="css/task.css">

<?php include "nav.php" ?>

<section class="task-details">
    <h2>Task Details</h2>

    <table>
        <?php
        if ($_SESSION["member_id"] == $task['assigned_by'] || $_SESSION["member_id"] == $task['assigned_to']) {
            echo '<form action="" method="post">';
        }
        ?>
        <tr>
            <th>Task Title</th>
            <td>
                <?php echo $task['title']; ?>
            </td>
        </tr>
        <tr>
            <th>Assigned By</th>
            <td><img src="<?php echo $task['byph'] ?>" alt="">
                <?php echo $task['byname'] . '(' . $task['assigned_by'] . ')'; ?></td>
        </tr>

        <tr>
            <th>Task Description</th>
            <td> <?php if ($_SESSION["member_id"] == $task['assigned_by'] || $_SESSION["member_id"] == $task['assigned_to']) {
                ?>
                <textarea id="description" name="description"
                    value='<?php echo $task['description']; ?>'><?php echo $task['description']; ?></textarea>
                <?php
                }else{
                echo $task['description'];
                }?>

            </td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td>
                <?php echo $task['start_date']; ?>
            </td>
        </tr>
        <tr>
            <th>Due/End Date</th>
            <td>
                <?php echo $task['due_date']; ?>
            </td>
        </tr>
        <tr>
            <th>Priority</th>
            <td>
                <?php echo $task['priority']; ?>
            </td>
        </tr>
        <tr>
            <th>Assigned To</th>
            <td><img src="<?php echo $task['byph'] ?>" alt="">
                <?php echo $task['byname'] . '(' . $task['assigned_by'] . ')'; ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <?php
                if ($_SESSION["member_id"] == $task['assigned_by'] || $_SESSION["member_id"] == $task['assigned_to']) {
                    ?>

                <select name="status">
                    <option value="1">
                        <?php echo $task['status'] == 1 ? '(selected) ' : ''; ?> pending
                    </option>
                    <option value="2">
                        <?php echo $task['status'] == 2 ? '(selected) ' : ''; ?>Active
                    </option>
                    <option value="3">
                        <?php echo $task['status'] == 3 ? '(selected) ' : ''; ?>Finished
                    </option>
                </select>

                <?php } else {
                    echo $task['status'] == 1 ? 'pending' : '';
                    echo $task['status'] == 2 ? 'Active' : '';
                    echo $task['status'] == 3 ? 'Finished' : '';
                }
                ?>

            </td>
        </tr>
        <?php
        if ($_SESSION["member_id"] == $task['assigned_by'] || $_SESSION["member_id"] == $task['assigned_to']) {
            echo ' <input type="submit" value="save Change">        </form>';
        }
        ?>

    </table>

</section>

<?php
include "footer.php";
?>