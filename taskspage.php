<!DOCTYPE html>
<html>
<head>
    <title>TaskTrack</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background-color: #121212; color: #e0e0e0; padding: 30px 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .box { background: #1e1e1e; padding: 25px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #2d2d2d; }
        h2, h3 { margin-bottom: 15px; color: #ffffff; }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"], textarea, select { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #3d3d3d; border-radius: 4px; background: #2a2a2a; color: #ffffff; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #3498db; }
        button, .btn { display: inline-block; width: 100%; padding: 12px; background-color: #3498db; color: #fff; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; text-decoration: none; text-align: center; }
        button:hover, .btn:hover { background-color: #2980b9; }
        .btn-secondary { background-color: #555; }
        .btn-secondary:hover { background-color: #666; }
        .header-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .logout-btn { color: #e74c3c; text-decoration: none; font-weight: bold; border: 1px solid #e74c3c; padding: 6px 12px; border-radius: 4px; }
        .logout-btn:hover { background: #e74c3c; color: #fff; }
        .task-card { background: #1e1e1e; padding: 15px; border-radius: 6px; margin-bottom: 15px; border-left: 4px solid #3498db; border-top: 1px solid #2d2d2d; border-right: 1px solid #2d2d2d; border-bottom: 1px solid #2d2d2d; }
        .task-card.high { border-left-color: #e74c3c; }
        .task-card.medium { border-left-color: #f1c40f; }
        .task-card.low { border-left-color: #2ecc71; }
        .badge { display: inline-block; padding: 3px 6px; font-size: 11px; font-weight: bold; border-radius: 3px; color: #fff; margin-bottom: 8px; text-transform: uppercase; }
        .badge.pending { background-color: #e67e22; }
        .badge.inprogress { background-color: #2980b9; }
        .badge.completed { background-color: #27ae60; }
        .task-meta { font-size: 13px; color: #aaa; display: flex; justify-content: space-between; margin-top: 10px; }
        .edit-btn { color: #3498db; cursor: pointer; font-weight: bold; margin-right: 10px; }
        .delete-btn { color: #e74c3c; text-decoration: none; font-weight: bold; }
        .filter-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 10px; margin-bottom: 10px; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); justify-content: center; align-items: center; z-index: 100; }
        .modal-content { background: #1e1e1e; padding: 25px; border-radius: 8px; max-width: 500px; width: 100%; border: 1px solid #3d3d3d; }
    </style>
</head>
<body>

<div class="container">

<div class="header-bar">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <a href="?logout=1" class="logout-btn">Logout</a>
</div>

<div class="box">
    <h3>Add Task</h3>
    <form method="POST">
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        
        <label style="font-size:13px; color:#aaa;">Deadline</label>
        <input type="date" name="deadline"><br>

        <label style="font-size:13px; color:#aaa;">Priority Level</label>
        <select name="priority">
            <option value="Low">Low</option>
            <option value="Medium" selected>Medium</option>
            <option value="High">High</option>
        </select>

        <label style="font-size:13px; color:#aaa;">Task Status</label>
        <select name="status">
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select>

        <button type="submit" name="add_task">Add Task</button>
    </form>
</div>

<div class="box">
    <h3>Search and Filter Tasks</h3>
    <form method="GET">
        <div class="filter-grid">
            <input type="text" name="search" placeholder="Search by title..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            
            <select name="filter_status">
                <option value="">All Statuses</option>
                <option value="Pending" <?php echo (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="In Progress" <?php echo (isset($_GET['filter_status']) && $_GET['filter_status'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                <option value="Completed" <?php echo (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
            </select>

            <select name="filter_priority">
                <option value="">All Priorities</option>
                <option value="Low" <?php echo (isset($_GET['filter_priority']) && $_GET['filter_priority'] == 'Low') ? 'selected' : ''; ?>>Low</option>
                <option value="Medium" <?php echo (isset($_GET['filter_priority']) && $_GET['filter_priority'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                <option value="High" <?php echo (isset($_GET['filter_priority']) && $_GET['filter_priority'] == 'High') ? 'selected' : ''; ?>>High</option>
            </select>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="width: auto; padding: 10px 20px;">Apply Filters</button>
            <a href="index.php" class="btn btn-secondary" style="width: auto; padding: 10px 20px;">Clear</a>
        </div>
    </form>
</div>

<div class="box">
    <h3>Your Tasks</h3>

    <?php
    $uid = $_SESSION['user_id'];
    
    $show_id_result = $conn->query("SHOW COLUMNS FROM tasks LIKE 'task_id'");
    $id_column = ($show_id_result && $show_id_result->num_rows > 0) ? "task_id" : "id";

    $query = "SELECT * FROM tasks WHERE user_id = ?";
    $params = [$uid];
    $types = "i";

    if (!empty($_GET['search'])) {
        $query .= " AND title LIKE ?";
        $searchTerm = "%" . $_GET['search'] . "%";
        $params[] = $searchTerm;
        $types .= "s";
    }

    if (!empty($_GET['filter_status'])) {
        $query .= " AND status = ?";
        $params[] = $_GET['filter_status'];
        $types .= "s";
    }

    if (!empty($_GET['filter_priority'])) {
        $query .= " AND priority = ?";
        $params[] = $_GET['filter_priority'];
        $types .= "s";
    }

    $query .= " ORDER BY $id_column DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $tasks = $stmt->get_result();
    $stmt->close();

    if (!$tasks || $tasks->num_rows === 0):
        echo "<p style='color:#aaa; font-style:italic;'>No tasks found.</p>";
    else:
        while ($row = $tasks->fetch_assoc()):
            $task_id = isset($row[$id_column]) ? $row[$id_column] : null;
            $rawPriority = isset($row['priority']) ? $row['priority'] : 'Low';
            $rawStatus = isset($row['status']) ? $row['status'] : 'Pending';
            
            $priorityClass = strtolower($rawPriority);
            $statusClass = strtolower(str_replace(' ', '', $rawStatus));
        ?>

            <div class="task-card <?php echo $priorityClass; ?>">
                <span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($rawStatus); ?></span><br>
                <b><?php echo htmlspecialchars($row['title']); ?></b><br>
                <span style="display:block; margin-top:5px; color:#ccc;"><?php echo htmlspecialchars($row['description']); ?></span>
                
                <div class="task-meta">
                    <span>Deadline: <?php echo !empty($row['deadline']) ? htmlspecialchars($row['deadline']) : 'No deadline'; ?> | Priority: <?php echo htmlspecialchars($rawPriority); ?></span>
                    <div>
                        <span class="edit-btn" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($row)); ?>, '<?php echo $id_column; ?>')">Edit</span>
                        <a href="?delete=<?php echo $task_id; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </div>
            </div>

        <?php 
        endwhile;
    endif; 
    ?>
</div>

<div class="modal" id="editModal">
    <div class="modal-content">
        <h3>Edit Task</h3>
        <form method="POST">
            <input type="hidden" name="task_id" id="edit_task_id">
            
            <label style="font-size:13px; color:#aaa;">Title</label>
            <input type="text" name="title" id="edit_title" required>
            
            <label style="font-size:13px; color:#aaa;">Description</label>
            <textarea name="description" id="edit_description"></textarea>
            
            <label style="font-size:13px; color:#aaa;">Deadline</label>
            <input type="date" name="deadline" id="edit_deadline">
            
            <label style="font-size:13px; color:#aaa;">Priority Level</label>
            <select name="priority" id="edit_priority">
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>

            <label style="font-size:13px; color:#aaa;">Task Status</label>
            <select name="status" id="edit_status">
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="submit" name="update_task">Save Changes</button>
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(task, idColumn) {
        document.getElementById('edit_task_id').value = task[idColumn];
        document.getElementById('edit_title').value = task.title;
        document.getElementById('edit_description').value = task.description;
        document.getElementById('edit_deadline').value = task.deadline || '';
        document.getElementById('edit_priority').value = task.priority || 'Low';
        document.getElementById('edit_status').value = task.status || 'Pending';
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target === modal) {
            closeEditModal();
        }
    }
</script>

</div>

</body>
</html>