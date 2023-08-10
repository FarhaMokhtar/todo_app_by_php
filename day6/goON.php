
<?php
session_start();

// Function to retrieve tasks for a specific user
function getUserTasks($userId) {
    $tasks = json_decode(file_get_contents('tasks.json'), true);
    return isset($tasks[$userId]) ? $tasks[$userId] : [];
}

// Get logged in user's tasks
$loggedInUserTasks = getUserTasks($_SESSION['email']);


// Add task to user's tasks
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $newTask = $_POST['task'];
    $tasks = json_decode(file_get_contents('tasks.json'), true);
    $tasks[$_SESSION['email']][] = $newTask;
    file_put_contents('tasks.json', json_encode($tasks));
    header('Location: goON.php');
    exit();
}

//delete 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $taskId = $_POST['delete'];
    $tasks = json_decode(file_get_contents('tasks.json'), true);
    if (isset($tasks[$_SESSION['email']][$taskId])) {
        unset($tasks[$_SESSION['email']][$taskId]);
        file_put_contents('tasks.json', json_encode($tasks));
        header('Location: goON.php');
        exit();
    }
}

//edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $taskId = $_POST['edit'];
    $tasks = json_decode(file_get_contents('tasks.json'), true);
    if (isset($tasks[$_SESSION['email']][$taskId])) {
        $editedTask = $_POST['edited_task'];
        $tasks[$_SESSION['email']][$taskId] = $editedTask;
        file_put_contents('tasks.json', json_encode($tasks));
        header('Location: goON.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  <h2>Tasks:</h2>
  <ul>
            <?php foreach ($loggedInUserTasks as $taskId => $task): ?>
                <li>
                    <?php echo $task; ?>
                    <form method="POST" action="goON.php" style="display: inline;">
                        <input type="hidden" name="delete" value="<?php echo $taskId; ?>">
                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                    </form>
                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal<?php echo $taskId; ?>">Edit</button>
                </li>

                <!-- Edit Task Modal -->
                <div class="modal fade" id="editModal<?php echo $taskId; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="editModalLabel">Edit Task</h4>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="goON.php">
                                    <input type="hidden" name="edit" value="<?php echo $taskId; ?>">
                                    <div class="form-group">
                                        <label for="edited_task">Task:</label>
                                        <input type="text" class="form-control" name="edited_task" id="edited_task" value="<?php echo $task; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </ul>



    <h2>Add a new task:</h2>
    <form method="POST" action="goON.php">
        <input type="text" name="task" placeholder="Task name" required >
        <input type="submit" value="Add Task">

    </form>

</body>
</html>


