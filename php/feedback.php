<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "final";

$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Student Data using prepared statement
$sql = "SELECT ID, NAME, EMAIL, IMAGE, FEEDBACK FROM feedback";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Check for messages from redirects
$message = "";
if (isset($_GET['msg'])) {
    $messages = [
        "update_success" => "Record updated successfully.",
        "delete_success" => "Record deleted successfully.",
        "error" => "An error occurred."
    ];
    $message = $messages[$_GET['msg']] ?? "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Feedback Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/stud_reg.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #e9ecef;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .logo span {
            color: var(--success-color);
        }
        
        .page-title {
            font-size: 18px;
            opacity: 0.9;
            margin-top: 5px;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            flex: 1;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .card-header {
            background-color: var(--accent-color);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 20px;
            font-weight: 600;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .message {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        
        .message i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .success {
            background-color: rgba(76, 201, 240, 0.15);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }
        
        .error {
            background-color: rgba(247, 37, 133, 0.15);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: white;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--gray-color);
        }
        
        th {
            background-color: rgba(67, 97, 238, 0.05);
            color: var(--primary-color);
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
        }
        
        tr:hover {
            background-color: rgba(67, 97, 238, 0.03);
        }
        
        .feedback-cell {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .feedback-cell:hover {
            white-space: normal;
            overflow: visible;
        }
        
        .student-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent-color);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
            border: none;
            color: white;
            text-decoration: none;
        }
        
        .btn i {
            margin-right: 5px;
        }
        
        .btn-edit {
            background-color: var(--accent-color);
        }
        
        .btn-edit:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.2);
        }
        
        .btn-delete {
            background-color: var(--danger-color);
        }
        
        .btn-delete:hover {
            background-color: #d61a6c;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(247, 37, 133, 0.2);
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 0;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #dee2e6;
        }
        
        footer {
            background-color: var(--dark-color);
            color: var(--light-color);
            text-align: center;
            padding: 20px;
            margin-top: auto;
        }
        
        .search-bar {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        
        .search-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(72, 149, 239, 0.2);
        }
        
        .btn-search {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-search:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-add {
            background-color: var(--success-color);
            color: white;
            display: inline-block;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-add:hover {
            background-color: #3db4d8;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(76, 201, 240, 0.2);
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            .card-header {
                flex-direction: column;
                gap: 10px;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
            
            .btn {
                width: 100%;
                text-align: center;
            }
            
            th, td {
                padding: 10px;
            }
            
            .hide-mobile {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        
        <div class="container">
            <?php if ($message): ?>
                <div class="message <?php echo ($_GET['msg'] == 'update_success' || $_GET['msg'] == 'delete_success') ? 'success' : 'error'; ?>">
                    <i class="fas fa-<?php echo ($_GET['msg'] == 'update_success' || $_GET['msg'] == 'delete_success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-comments"></i> Customer Feedback List
                    </h2>
                    
                </div>
                <div class="card-body">
                    <?php if ($result->num_rows > 0): ?>
                        <table id="feedbackTable">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="15%">Name</th>
                                    <th width="20%">Email</th>
                                    <th width="10%">Image</th>
                                    <th width="30%">Feedback</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['ID']; ?></td>
                                        <td><?php echo htmlspecialchars($row['NAME']); ?></td>
                                        <td><?php echo htmlspecialchars($row['EMAIL']); ?></td>
                                        <td>
                                        <img class="student-img" 
                                                 src="uploads/<?php echo !empty($row['IMAGE']) ? htmlspecialchars($row['IMAGE']) : 'default-avatar.png'; ?>" 
                                                 
                                                 alt="Student Image">
                                        </img>         
                                        </td>
                                        <td class="feedback-cell"><?php echo htmlspecialchars($row['FEEDBACK']); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="update.php?id=<?php echo $row['ID']; ?>" class="btn btn-edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="delete.php?id=<?php echo $row['ID']; ?>" 
                                                   onclick="return confirm('Are you sure you want to delete this record?');" 
                                                   class="btn btn-delete">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>No feedback records found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
    </div>

    <script>
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('feedbackTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const nameCell = rows[i].getElementsByTagName('td')[1];
                const emailCell = rows[i].getElementsByTagName('td')[2];
                
                if (nameCell && emailCell) {
                    const nameText = nameCell.textContent || nameCell.innerText;
                    const emailText = emailCell.textContent || emailCell.innerText;
                    
                    if (nameText.toUpperCase().indexOf(filter) > -1 || emailText.toUpperCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }

        // Add hover effect to show full feedback text
        document.querySelectorAll('.feedback-cell').forEach(cell => {
            cell.addEventListener('mouseover', function() {
                this.style.position = 'relative';
                this.style.zIndex = '1';
                
                if (this.offsetWidth < this.scrollWidth) {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'tooltip';
                    tooltip.textContent = this.textContent;
                    tooltip.style.position = 'absolute';
                    tooltip.style.backgroundColor = 'white';
                    tooltip.style.padding = '10px';
                    tooltip.style.border = '1px solid #ddd';
                    tooltip.style.borderRadius = '4px';
                    tooltip.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';
                    tooltip.style.maxWidth = '300px';
                    tooltip.style.top = '100%';
                    tooltip.style.left = '0';
                    tooltip.style.zIndex = '2';
                    
                    this.appendChild(tooltip);
                }
            });
            
            cell.addEventListener('mouseout', function() {
                this.style.position = '';
                this.style.zIndex = '';
                const tooltip = this.querySelector('.tooltip');
                if (tooltip) {
                    tooltip.remove();
                }
            });
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>