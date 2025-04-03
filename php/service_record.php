<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Records Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #3498db;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --dark: #34495e;
            --light: #f8f9fa;
            --text: #2c3e50;
            --border: #dfe6e9;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: var(--text);
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px 0;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        
        h1 {
            text-align: center;
            color: var(--dark);
            font-size: 28px;
        }
        
        .subtitle {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        .data-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow-x: auto;
        }
        
        .message {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .message.success {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--success);
        }
        
        .message.error {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--danger);
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        
        th {
            background-color: var(--light);
            color: var(--dark);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .status-pill {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .vehicle-type {
            font-weight: 600;
        }
        
        .vehicle-number {
            color: var(--primary);
            font-family: monospace;
            font-size: 14px;
            letter-spacing: 1px;
        }
        
        .date-display {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .price-display {
            font-weight: bold;
            color: var(--dark);
        }
        
        .button-container {
            display: flex;
            gap: 5px;
        }
        
        button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        
        .accept {
            background-color: var(--success);
            color: white;
        }
        
        .accept:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
        }
        
        .decline {
            background-color: var(--danger);
            color: white;
        }
        
        .decline:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }
        
        .no-records {
            text-align: center;
            padding: 40px 0;
            color: #7f8c8d;
            font-size: 18px;
        }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 0;
        }
        
        .empty-state i {
            font-size: 60px;
            color: #bdc3c7;
            margin-bottom: 20px;
        }
        
        .empty-state p {
            font-size: 18px;
            color: #7f8c8d;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            th, td {
                padding: 8px;
            }
            
            .container {
                width: 95%;
                padding: 10px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            /* Stack the button container on small screens */
            .button-container {
                flex-direction: column;
            }
        }
    </style>
    <script>
        // Function to handle button clicks
        function handleAction(action, id) {
            // Use Fetch API for AJAX request
            fetch('process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=${action}&id=${id}`
            })
            .then(response => response.text())
            .then(data => {
                const messageElement = document.getElementById('message');
                messageElement.textContent = data;
                
                // Add appropriate class for styling
                if (action === 'accept') {
                    messageElement.className = 'message success';
                    messageElement.innerHTML = `<i class="fas fa-check-circle"></i> Service request #${id} has been accepted successfully!`;
                } else {
                    messageElement.className = 'message error';
                    messageElement.innerHTML = `<i class="fas fa-times-circle"></i> Service request #${id} has been declined.`;
                }

                // Remove the row dynamically after action with animation
                const row = document.getElementById(`row-${id}`);
                if (row) {
                    row.style.backgroundColor = action === 'accept' ? 'rgba(46, 204, 113, 0.2)' : 'rgba(231, 76, 60, 0.2)';
                    setTimeout(() => {
                        row.style.opacity = '0';
                        row.style.transition = 'opacity 0.5s';
                        setTimeout(() => {
                            row.remove();
                            
                            // Check if there are no more rows
                            const tableBody = document.querySelector('tbody');
                            if (tableBody.children.length === 0) {
                                document.getElementById('data-table').style.display = 'none';
                                document.getElementById('empty-state').style.display = 'flex';
                            }
                        }, 500);
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const messageElement = document.getElementById('message');
                messageElement.textContent = 'An error occurred. Please try again.';
                messageElement.className = 'message error';
            });
        }

        // Format date to be more readable
        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString(undefined, options);
        }

        // Format currency
        function formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);
        }

        // Initialize page when loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Format dates and prices
            document.querySelectorAll('.date-value').forEach(el => {
                el.textContent = formatDate(el.textContent);
            });
            
            document.querySelectorAll('.price-value').forEach(el => {
                el.textContent = formatCurrency(el.textContent);
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Service Request Dashboard</h1>
            <p class="subtitle">Manage incoming vehicle service requests</p>
        </header>
        
        <div id="message" class="message"></div>
        
        <?php
        include 'signup.php';
        error_reporting(E_ALL);

        // Fetch records from the database
        $query = "SELECT * FROM service";
        $run = mysqli_query($con, $query);
        $count = mysqli_num_rows($run);

        if ($count > 0) {
        ?>
        <div class="data-container">
            <table id="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vehicle</th>
                        <th>Contact Info</th>
                        <th>Service Details</th>
                        <th>Date & Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($call = mysqli_fetch_assoc($run)) { ?>
                        <tr id="row-<?php echo $call['ID']; ?>">
                            <td>#<?php echo htmlspecialchars($call['ID']); ?></td>
                            <td>
                                <div class="vehicle-type"><?php echo htmlspecialchars($call['V_TYPE']); ?></div>
                                <div class="vehicle-number"><?php echo htmlspecialchars($call['V_NUMBER']); ?></div>
                            </td>
                            <td>
                                <div><?php echo htmlspecialchars($call['EMAIL']); ?></div>
                                <div><?php echo htmlspecialchars($call['PHONE']); ?></div>
                            </td>
                            <td>
                                <div><strong>Service:</strong> <?php echo htmlspecialchars($call['WANT']); ?></div>
                                <div><strong>Qty:</strong> <?php echo htmlspecialchars($call['QUANTITY']); ?></div>
                                <div class="price-display">Price: <span class="price-value"><?php echo htmlspecialchars($call['PRICE']); ?></span></div>
                            </td>
                            <td>
                                <div class="date-display">
                                    <i class="far fa-calendar-alt"></i> 
                                    <span class="date-value"><?php echo htmlspecialchars($call['DATE']); ?></span>
                                </div>
                                <div><small><?php echo htmlspecialchars($call['ADDRESS']); ?></small></div>
                            </td>
                            <td>
                                <div class="button-container">
                                    <button class="accept" onclick="window.location.href='orderaccept.php?id=<?php echo $call['ID']; ?>'">
                                       <i class="fas fa-check"></i> Accept
                                    </button>
                                    <button class="decline" onclick="window.location.href='orderdecline.php?id=<?php echo $call['ID']; ?>'">
                                        <i class="fas fa-times"></i> Decline
                                    </button>

                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div id="empty-state" class="empty-state" style="display: none;">
                <i class="fas fa-clipboard-check"></i>
                <p>All service requests have been processed</p>
            </div>
        </div>
        <?php
        } else {
        ?>
        <div class="data-container">
            <div class="empty-state">
                <i class="fas fa-clipboard-check"></i>
                <p>No service requests available at this time</p>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</body>
</html>