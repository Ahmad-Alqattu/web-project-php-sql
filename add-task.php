<?php 
session_start();
   if (isset($_SESSION['logged_in'])) {
   } else {
          header("location:notallowed.php");
   }
include "header.php";

?>

<?php
include "conectdb.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_title = $_POST['task_title'];
    $task_description = $_POST['task_description'];
    $start_date = $_POST['start_date'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $assigned_to = $_POST['assigned_to'];
    $assigning_member = $_SESSION['member_id'];;

    $sql = "INSERT INTO tasks (title,description, start_date, due_date, priority, assigned_to, assigned_by)
VALUES ('$task_title', '$task_description', '$start_date', '$due_date', '$priority', '$assigned_to',
'$assigning_member')";


    if ($pdo->query($sql) == TRUE) {
        $secess['add'] = "Task added successfully!";
    } else {

        $errors['add'] = 'Task not added. Please try again.';
    }
}
?>
<link rel="stylesheet" href="css/search.css">

<main id="content">
    <?php include "nav.php" ?>

    <link rel="stylesheet" href="css/addtask.css">

    <section id="task-container">
        <?php if (isset($errors['add'])) : ?>
        <div class="message error">
            <?php echo $errors['add'] ?>
        </div>
        <?php endif; ?>
        <?php if (isset($secess['add'])) : ?>
        <div class="message success "> <?php echo $secess['add'] ?>
        </div>
        <?php endif; ?>

        <!-- Add form to create a task -->
        <form action="" method="post">
            <h1>Create Task</h1>
            <Fieldset>
                <div class="task-title">
                    <label>Task Title:</label>
                    <input type="text" name="task_title" laceholder="Enter task title" required>
                </div>
                <div class="task-description">
                    <label>Task Description:</label>
                    <textarea placeholder="Enter task description" name="task_description"></textarea>
                </div>
                <div class="date">
                    <label>Start Date:</label> <input type="date" name="start_date" required>
                </div>
                <div class="date">
                    <label>Due/End Date:</label>
                    <input type="date" name="due_date" required>
                </div>
                <div class="task-priority">
                    <label>Priority:</label>
                    <select name="priority" required>
                        <option value="0">non</option>
                        <option value="1">Low</option>
                        <option value="2">Medium</option>
                        <option value="3">High</option>
                    </select>
                </div>
                <div class="assigned-to">
                    <label for="assigned">Assigned-to Member:</label>
                    <select name="assigned_to" id="assigned_to_member" name="assigned_to" required>
                        <option value="0">Select a member</option>
                        <?php
                        $sql = 'select name,id,photo from members ';
                        $result = $pdo->query($sql);
                        while ($row = $result->fetch()) {
                            echo '<option value=' . $row['id'] . '';
                            echo '>';
                            echo $row['name'];
                            echo ' (' . $row['id'] . ')';
                            echo '</option>';
                        }

                        ?>
                    </select>
                </div id="submit">
                <input type="submit" value="Create Task">
                </div>
            </Fieldset>
        </form>
    </section>
</main>
<?php
include "footer.php";
?>