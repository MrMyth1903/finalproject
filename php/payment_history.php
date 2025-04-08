<?php
// Database connection
$host = 'localhost';
$db   = 'final';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current date for report header
$current_date = date("F j, Y");

// Fetch payment records with the actual payment date
$sql = "SELECT id, email, working_days, amount_paid FROM payments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Records</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #3e8e41;
            --accent-color: #f8f9fa;
            --text-color: #333;
            --border-color: #ddd;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            color: var(--text-color);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        h2 {
            color: var(--primary-color);
            margin: 0;
            font-size: 28px;
            display: flex;
            align-items: center;
        }
        
        h2 i {
            margin-right: 10px;
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-print {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-print:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            margin: auto;
            background-color: white;
        }
        
        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 14px;
        }
        
        tbody tr {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        
        tbody tr:hover {
            background-color: #f9f9f9;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .amount {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .no-records {
            text-align: center;
            padding: 30px;
            font-style: italic;
            color: #777;
        }
        
        .date-cell {
            white-space: nowrap;
        }
        
        .report-info {
            margin-bottom: 20px;
            display: none;
        }
        
        .report-info div {
            margin-bottom: 5px;
        }
        
        /* Print styles */
        @media print {
            body {
                background-color: white;
                padding: 0;
                margin: 0;
            }
            
            .container {
                box-shadow: none;
                max-width: 100%;
                padding: 0;
            }
            
            .actions {
                display: none;
            }
            
            .report-info {
                display: block;
                margin-bottom: 20px;
                padding: 15px 0;
                border-bottom: 1px solid #eee;
            }
            
            tbody tr:hover {
                background-color: transparent;
                transform: none;
                box-shadow: none;
            }
            
            .table-container {
                box-shadow: none;
            }
            
            h2 {
                margin-bottom: 10px;
            }
            
            @page {
                margin: 1cm;
            }
        }
        
        /* Responsive styles */
        @media screen and (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .actions {
                width: 100%;
                justify-content: flex-end;
            }
            
            th, td {
                padding: 10px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><i class="fas fa-file-invoice-dollar"></i> Worker Payment Records</h2>
            <div class="actions">
                <button class="btn btn-print" onclick="printReport()">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>
        </div>
        
        <div class="report-info">
            <div><strong>Report Generated:</strong> <?php echo $current_date; ?></div>
            <div><strong>Company:</strong> Meri Gaddi</div>
            <div><strong>Payment Summary Report</strong></div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Working Days</th>
                        <th>Amount Paid</th>
                        <th>Paid On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $count = 1;
                        $total_amount = 0;
                        
                        while ($row = $result->fetch_assoc()) {
                            $total_amount += $row['amount_paid'];
                            
                            // Format the date if it exists, otherwise use current date
                            $payment_date = isset($row['created_at']) ? date("d M Y, h:i A", strtotime($row['created_at'])) : date("d M Y, h:i A");
                            
                            echo "<tr class='record-row'>";
                            echo "<td>" . $count++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . $row['working_days'] . "</td>";
                            echo "<td class='amount'>₹" . number_format($row['amount_paid'], 2) . "</td>";
                            echo "<td class='date-cell'>" . $payment_date . "</td>";
                            echo "</tr>";
                        }
                        
                        // Add total row
                        echo "<tr style='font-weight: bold; background-color: #f0f0f0;'>";
                        echo "<td colspan='3' style='text-align: right;'>Total:</td>";
                        echo "<td class='amount'>₹" . number_format($total_amount, 2) . "</td>";
                        echo "<td></td>";
                        echo "</tr>";
                        
                    } else {
                        echo "<tr><td colspan='5' class='no-records'>No payment records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Fade in animation for rows
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.record-row');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.animation = `fadeIn 0.5s ease forwards`;
                }, index * 100);
            });
        });
        
        function printReport() {
            window.print();
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>