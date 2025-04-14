<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #6366f1;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --light: #f3f4f6;
            --dark: #1f2937;
            --gray: #9ca3af;
            --white: #ffffff;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Roboto, -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f9fafb;
            color: var(--dark);
            line-height: 1.5;
        }
        
        .dashboard {
            min-height: 100vh;
            display: grid;
            grid-template-rows: auto 1fr auto;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            padding: 1.5rem 2rem;
            box-shadow: var(--shadow);
            position: relative;
            z-index: 10;
        }
        
        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 0.75rem;
            font-size: 1.5em;
        }
        
        .logo span {
            color: #a5b4fc;
        }
        
        .header-actions {
            display: flex;
            gap: 1rem;
        }
        
        .btn-add {
            display: inline-flex;
            align-items: center;
            background-color: var(--white);
            color: var(--primary);
            border: none;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            gap: 0.5rem;
        }
        
        .btn-add:hover {
            background-color: #f3f4f6;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .subtitle {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 400;
            margin-top: 0.25rem;
        }
        
        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .card {
            background-color: var(--white);
            border-radius: 0.5rem;
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        
        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .search-container {
            display: flex;
            align-items: center;
            position: relative;
            max-width: 20rem;
            width: 100%;
        }
        
        .search-input {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        
        .search-icon {
            position: absolute;
            left: 0.75rem;
            color: var(--gray);
            pointer-events: none;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.875rem;
        }
        
        thead {
            background-color: #f9fafb;
        }
        
        th {
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: var(--dark);
            border-bottom: 2px solid #e5e7eb;
            white-space: nowrap;
        }
        
        td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }
        
        tbody tr {
            transition: background-color 0.2s;
        }
        
        tbody tr:hover {
            background-color: #f3f4f6;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            gap: 0.375rem;
            text-decoration: none;
        }
        
        .btn-edit {
            background-color: var(--warning);
            color: var(--white);
        }
        
        .btn-edit:hover {
            background-color: #d97706;
        }
        
        .btn-delete {
            background-color: var(--danger);
            color: var(--white);
        }
        
        .btn-delete:hover {
            background-color: #dc2626;
        }
        
        .action-cell {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: 9999px;
        }
        
        .badge-primary {
            background-color: rgba(99, 102, 241, 0.1);
            color: var(--primary);
        }
        
        .badge-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }
        
        .badge-warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            text-align: center;
            color: var(--gray);
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #d1d5db;
        }
        
        .empty-state p {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }
        
        /* Password Cell */
        .password-cell {
            position: relative;
        }
        
        .password-hidden {
            letter-spacing: 0.2em;
            font-family: monospace;
            user-select: none;
        }
        
        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray);
            transition: color 0.2s;
            background: none;
            border: none;
        }
        
        .toggle-password:hover {
            color: var(--primary);
        }
        
        /* Message */
        .message {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .message-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }
        
        .message-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }
        
        /* Footer */
        .footer {
            background-color: var(--white);
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem;
            text-align: center;
            color: var(--gray);
            margin-top: auto;
        }
        
        .footer a {
            color: var(--primary);
            text-decoration: none;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            
            .header-actions {
                width: 100%;
                justify-content: flex-end;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .search-container {
                width: 100%;
                max-width: none;
            }
            
            .action-cell {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
            
            .hide-mobile {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Header -->
        

        <!-- Main Content -->
        <main class="main-content">
            <?php
            if (isset($_GET['message'])) {
                $message_type = isset($_GET['type']) ? $_GET['type'] : 'success';
                $message_text = htmlspecialchars($_GET['message']);
                echo '<div class="message message-' . $message_type . '">';
                echo '<i class="fas fa-' . ($message_type == 'success' ? 'check-circle' : 'exclamation-circle') . '"></i>';
                echo $message_text;
                echo '</div>';
            }
            ?>

            <h1 class="page-title">
                <i class="fas fa-user-friends"></i>
                User Management
            </h1>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-list"></i>
                        User Records
                    </h2>
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="search-input" placeholder="Search users...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <?php
                        include 'signup.php';
                        error_reporting(E_ALL);
                        $query = "SELECT * FROM user";
                        $run = mysqli_query($con, $query);
                        $count = mysqli_num_rows($run);

                        if ($count > 0) {
                        ?>
                            <table id="usersTable">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Date of Birth</th>
                                        <th>City</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($call = mysqli_fetch_assoc($run)) { ?>
                                        <tr>
                                            <td><?= htmlspecialchars($call['ID']); ?></td>
                                            <td><?= htmlspecialchars($call['FirstName']); ?></td>
                                            <td><?= htmlspecialchars($call['LastName']); ?></td>
                                            <td><?= htmlspecialchars($call['Phone']); ?></td>
                                            <td><?= htmlspecialchars($call['Mail']); ?></td>
                                            <td class="password-cell">
                                                <span class="password-hidden" data-password="<?= htmlspecialchars($call['Password']); ?>">
                                                    ••••••••
                                                </span>
                                                <button class="toggle-password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                            <td><?= htmlspecialchars($call['DOB']); ?></td>
                                            <td><?= htmlspecialchars($call['City']); ?></td>
                                            <td class="text-center">
                                                <div class="action-cell">
                                                    <a href="user_update.php?id=<?= $call['ID']; ?>" class="btn btn-edit">
                                                        <i class="fas fa-edit"></i>
                                                        <span class="hide-mobile">Edit</span>
                                                    </a>
                                                    <a href="user_delete.php?id=<?= $call['ID']; ?>" 
                                                       onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.');" 
                                                       class="btn btn-delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                        <span class="hide-mobile">Delete</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php
                        } else {
                        ?>
                            <div class="empty-state">
                                <i class="far fa-user-circle"></i>
                                <p>No user records found in the database.</p>
                                <a href="user_create.php" class="btn btn-primary">
                                    <i class="fas fa-user-plus"></i>
                                    Add Your First User
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> User Management System | All Rights Reserved</p>
        </footer>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#usersTable tbody tr');
            
            tableRows.forEach(row => {
                let matchFound = false;
                const cells = row.querySelectorAll('td');
                
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().indexOf(searchValue) > -1) {
                        matchFound = true;
                    }
                });
                
                if (matchFound) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Password toggle functionality
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const passwordSpan = this.previousElementSibling;
                const icon = this.querySelector('i');
                
                if (passwordSpan.classList.contains('password-hidden')) {
                    passwordSpan.textContent = passwordSpan.getAttribute('data-password');
                    passwordSpan.classList.remove('password-hidden');
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordSpan.textContent = '••••••••';
                    passwordSpan.classList.add('password-hidden');
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>