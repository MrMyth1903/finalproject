<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get today's date or selected date
$date = isset($_POST['date']) ? $_POST['date'] : date("Y-m-d");

// Extract month and year
$month = date("m", strtotime($date));
$year = date("Y", strtotime($date));

// Fetch all members
$result = $conn->query("SELECT * FROM members");

// Re-run query to loop twice
$members = [];
while ($row = $result->fetch_assoc()) {
    $members[] = $row;
}

// Get attendance data for current date to show pre-selected values
$current_attendance = [];
$att_today_query = "SELECT email, status FROM attendance WHERE date = '$date'";
$att_today_result = $conn->query($att_today_query);
if ($att_today_result && $att_today_result->num_rows > 0) {
    while ($att_row = $att_today_result->fetch_assoc()) {
        $current_attendance[$att_row['email']] = $att_row['status'];
    }
}

// Count total days in current month
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap5.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css">
    <!-- Custom CSS -->
    <style>
         :root {
            --primary-color: #4361ee;
            --secondary-color: #3bc14a;
            --danger-color: #ef476f;
            --warning-color: #ffd166;
            --info-color: #06d6a0;
            --dark-color: #073b4c;
            --light-color: #f8f9fa;
            --muted-color: #6c757d;
            --border-radius: 10px;
            --box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f5f7fa;
            overflow-x: hidden;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c9d2;
            border-radius: 10px;
            transition: var(--transition);
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }
        
        .navbar {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: white;
            letter-spacing: 0.5px;
        }
        
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
            overflow: hidden;
            transition: var(--transition);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .header-icon {
            margin-right: 0.75rem;
            color: var(--primary-color);
        }
        
        .btn {
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: var(--transition);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-primary:hover {
            background-color: #3a56d4;
            border-color: #3a56d4;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        }
        
        .btn-success {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            box-shadow: 0 4px 15px rgba(59, 193, 74, 0.3);
        }
        
        .btn-success:hover {
            background-color: #34ad40;
            border-color: #34ad40;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(59, 193, 74, 0.4);
        }
        
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table thead th {
            background-color: rgba(67, 97, 238, 0.05);
            color: var(--dark-color);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            padding: 15px;
            border: none;
        }
        
        .table tbody tr {
            transition: var(--transition);
        }
        
        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.03);
        }
        
        .table td {
            padding: 15px;
            vertical-align: middle;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .select-status {
            border: 2px solid #e9ecef;
            border-radius: 50px;
            padding: 8px 20px;
            width: 100%;
            font-weight: 600;
            transition: var(--transition);
            text-align: center;
            background: white;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: calc(100% - 15px) center;
            background-size: 12px;
            padding-right: 40px;
        }
        
        .select-status:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
        }
        
        .select-status.present {
            border-color: var(--secondary-color);
            color: var(--secondary-color);
            background-color: rgba(59, 193, 74, 0.1);
        }
        
        .select-status.absent {
            border-color: var(--danger-color);
            color: var(--danger-color);
            background-color: rgba(239, 71, 111, 0.1);
        }
        
        .select-status.half-day {
            border-color: var(--warning-color);
            color: #e9b526;
            background-color: rgba(255, 209, 102, 0.1);
        }
        
        .select-status.leave {
            border-color: var(--info-color);
            color: var(--info-color);
            background-color: rgba(6, 214, 160, 0.1);
        }
        
        .progress {
            height: 8px;
            border-radius: 50px;
            margin-top: 8px;
            background-color: #e9ecef;
            overflow: hidden;
        }
        
        .progress-bar {
            border-radius: 50px;
        }
        
        .stats-card {
            border-radius: var(--border-radius);
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }
        
        .stats-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            transition: var(--transition);
        }
        
        .stats-card:hover:before {
            width: 10px;
        }
        
        .stats-card.present:before {
            background-color: var(--secondary-color);
        }
        
        .stats-card.absent:before {
            background-color: var(--danger-color);
        }
        
        .stats-card.percentage:before {
            background-color: var(--info-color);
        }
        
        .stats-icon {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.5rem;
            margin-left: auto;
        }
        
        .stats-card.present .stats-icon {
            background-color: rgba(59, 193, 74, 0.1);
            color: var(--secondary-color);
        }
        
        .stats-card.absent .stats-icon {
            background-color: rgba(239, 71, 111, 0.1);
            color: var(--danger-color);
        }
        
        .stats-card.percentage .stats-icon {
            background-color: rgba(6, 214, 160, 0.1);
            color: var(--info-color);
        }
        
        .stats-text {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--muted-color);
            letter-spacing: 0.5px;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-top: 5px;
            margin-bottom: 0;
        }
        
        .date-selector {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
        }
        
        .calendar-container {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
        }
        
        .calendar {
            width: 100%;
            border-collapse: separate;
            border-spacing: 3px;
        }
        
        .calendar th {
            padding: 10px;
            text-align: center;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--muted-color);
        }
        
        .calendar td {
            padding: 10px;
            text-align: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: var(--transition);
            font-weight: 600;
            position: relative;
        }
        
        .calendar td:not(.empty):not(.selected):hover {
            background-color: rgba(67, 97, 238, 0.1);
            cursor: pointer;
        }
        
        .calendar td.today {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .calendar td.selected {
            background-color: var(--primary-color);
            color: white;
        }
        
        .calendar td.empty {
            color: #ccc;
        }
        
        .calendar td.has-attendance:after {
            content: '';
            position: absolute;
            bottom: 3px;
            left: 50%;
            transform: translateX(-50%);
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background-color: var(--secondary-color);
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .action-btn {
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: var(--transition);
            border: 2px solid transparent;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .action-btn i {
            font-size: 0.9rem;
        }
        
        .btn-present {
            background-color: rgba(59, 193, 74, 0.1);
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-present:hover {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .btn-absent {
            background-color: rgba(239, 71, 111, 0.1);
            color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .btn-absent:hover {
            background-color: var(--danger-color);
            color: white;
        }
        
        .btn-half-day {
            background-color: rgba(255, 209, 102, 0.1);
            color: #e9b526;
            border-color: var(--warning-color);
        }
        
        .btn-half-day:hover {
            background-color: var(--warning-color);
            color: white;
        }
        
        /* Custom DataTables styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--primary-color) !important;
            color: white !important;
            border: none !important;
            border-radius: 50px;
            padding: 5px 15px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(67, 97, 238, 0.1) !important;
            border-color: transparent !important;
            color: var(--primary-color) !important;
            border-radius: 50px;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e9ecef;
            border-radius: 50px;
            padding: 8px 15px;
            margin-left: 10px;
            transition: var(--transition);
        }
        
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
        }
        
        /* Flatpickr customization */
        .flatpickr-calendar {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: none;
        }
        
        .flatpickr-day.selected {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .flatpickr-day.today {
            border-color: var(--primary-color);
        }
        
        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-badge.present {
            background-color: rgba(59, 193, 74, 0.1);
            color: var(--secondary-color);
        }
        
        .status-badge.absent {
            background-color: rgba(239, 71, 111, 0.1);
            color: var(--danger-color);
        }
        
        .status-badge.half-day {
            background-color: rgba(255, 209, 102, 0.1);
            color: #e9b526;
        }
        
        .status-badge.leave {
            background-color: rgba(6, 214, 160, 0.1);
            color: var(--info-color);
        }
        
        /* Page transition */
        .page-transition {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .stats-card {
                margin-bottom: 15px;
            }
            
            .calendar td {
                width: 30px;
                height: 30px;
                padding: 5px;
                font-size: 0.8rem;
            }
            
            .action-buttons {
                justify-content: center;
            }
        }
        
        /* Pulse animation for buttons */
        .btn-pulse {
            animation: pulse 2s infinite;
        }
        
        /* Floating action button */
        .floating-action-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 20px rgba(67, 97, 238, 0.4);
            cursor: pointer;
            transition: var(--transition);
            z-index: 1000;
        }
        
        .floating-action-btn:hover {
            transform: translateY(-5px) rotate(360deg);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.5);
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Date Selector Card -->
        <div class="row animate-in" style="animation-delay: 0.1s;">
            <div class="col-lg-12">
                <div class="date-selector">
                    <h5 class="mb-3"><i class="fas fa-calendar-alt header-icon"></i>Select Date</h5>
                    <form method="POST" id="dateForm" class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" class="form-control" name="date" id="attendance-date" value="<?php echo $date; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sync-alt me-2"></i>Load Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row animate-in" style="animation-delay: 0.2s;">
            <?php
            // Calculate total stats for the selected month
            $total_present = 0;
            $total_absent = 0;
            $total_records = 0;
            
            $monthly_stats_query = "SELECT status, COUNT(*) as count FROM attendance 
                                   WHERE MONTH(date) = $month AND YEAR(date) = $year 
                                   GROUP BY status";
            $monthly_stats_result = $conn->query($monthly_stats_query);
            
            if ($monthly_stats_result && $monthly_stats_result->num_rows > 0) {
                while ($stat = $monthly_stats_result->fetch_assoc()) {
                    if ($stat['status'] == 'Present') {
                        $total_present = $stat['count'];
                    } elseif ($stat['status'] == 'Absent') {
                        $total_absent = $stat['count'];
                    }
                    $total_records += $stat['count'];
                }
            }
            
            $attendance_percentage = $total_records > 0 ? round(($total_present / $total_records) * 100, 2) : 0;
            ?>
            
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 stats-card present h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="stats-text text-success mb-1">Present</div>
                                <div class="stats-number"><?php echo $total_present; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-check stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 stats-card absent h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="stats-text text-danger mb-1">Absent</div>
                                <div class="stats-number"><?php echo $total_absent; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-times stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 stats-card percentage h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="stats-text text-info mb-1">Attendance Rate</div>
                                <div class="stats-number"><?php echo $attendance_percentage; ?>%</div>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $attendance_percentage; ?>%" 
                                         aria-valuenow="<?php echo $attendance_percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row animate-in" style="animation-delay: 0.3s;">
            <!-- Mark Attendance Card -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0 font-weight-bold">
                            <i class="fas fa-clipboard-check header-icon"></i>
                            Mark Attendance for <?php echo date("F d, Y", strtotime($date)); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="save_attendance.php" id="attendanceForm">
                            <input type="hidden" name="date" value="<?php echo $date; ?>">
                            
                            <div class="table-responsive">
                                <table class="table table-hover" id="attendanceTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($members as $index => $row): ?>
                                            <?php 
                                                $status = isset($current_attendance[$row['email']]) ? $current_attendance[$row['email']] : '';
                                            ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['phoneNumber']; ?></td>
                                                <td>
                                                    <select name="attendance[<?php echo $row['email']; ?>]" class="select-status" data-email="<?php echo $row['email']; ?>">
                                                        <option value="" <?php echo ($status == '') ? 'selected' : ''; ?>>-- Select --</option>
                                                        <option value="Present" <?php echo ($status == 'Present') ? 'selected' : ''; ?>>Present</option>
                                                        <option value="Absent" <?php echo ($status == 'Absent') ? 'selected' : ''; ?>>Absent</option>
                                                        <option value="Half-Day" <?php echo ($status == 'Half-Day') ? 'selected' : ''; ?>>Half-Day</option>
                                                        <option value="Leave" <?php echo ($status == 'Leave') ? 'selected' : ''; ?>>Leave</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Save Attendance
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Summary Card -->
        <div class="row animate-in" style="animation-delay: 0.4s;">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0 font-weight-bold">
                            <i class="fas fa-chart-bar header-icon"></i>
                            Monthly Attendance Summary (<?php echo date("F Y", strtotime($date)); ?>)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="summaryTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Present</th>
                                        <th>Absent</th>
                                        <th>Half-Day</th>
                                        <th>Leave</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($members as $row) {
                                        $email = $row['email'];
                                        $name = $row['firstname'] . ' ' . $row['lastname'];

                                        // Fetch attendance records for the selected month
                                        $att_q = "SELECT status FROM attendance 
                                                WHERE email = '$email' 
                                                AND MONTH(date) = $month 
                                                AND YEAR(date) = $year";
                                        $att_result = $conn->query($att_q);

                                        $present = 0;
                                        $absent = 0;
                                        $half_day = 0;
                                        $leave = 0;
                                        $total = 0;

                                        if ($att_result && $att_result->num_rows > 0) {
                                            while ($att = $att_result->fetch_assoc()) {
                                                $total++;
                                                if ($att['status'] == 'Present') {
                                                    $present++;
                                                } elseif ($att['status'] == 'Absent') {
                                                    $absent++;
                                                } elseif ($att['status'] == 'Half-Day') {
                                                    $half_day++;
                                                } elseif ($att['status'] == 'Leave') {
                                                    $leave++;
                                                }
                                            }
                                        }

                                        // Calculate working days (excluding weekends)
                                        $working_days = 0;
                                        for ($day = 1; $day <= $days_in_month; $day++) {
                                            $check_date = sprintf("%04d-%02d-%02d", $year, $month, $day);
                                            $day_of_week = date("N", strtotime($check_date));
                                            // 6=Saturday, 7=Sunday
                                            if ($day_of_week < 6) {
                                                $working_days++;
                                            }
                                        }

                                        $percent = $total > 0 ? round(($present / $total) * 100, 2) : 0;
                                        $progress_color = $percent >= 75 ? "bg-success" : ($percent >= 50 ? "bg-warning" : "bg-danger");

                                        echo "<tr>
                                                <td>$name</td>
                                                <td>$email</td>
                                                <td>$present</td>
                                                <td>$absent</td>
                                                <td>$half_day</td>
                                                <td>$leave</td>
                                                <td>
                                                    <div class='progress' data-bs-toggle='tooltip' title='$percent%'>
                                                        <div class='progress-bar $progress_color' role='progressbar' style='width: $percent%' 
                                                             aria-valuenow='$percent' aria-valuemin='0' aria-valuemax='100'></div>
                                                    </div>
                                                    <small class='text-muted mt-1 d-block'>$percent% ($total/$working_days days)</small>
                                                </td>
                                              </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-5 mb-3 text-center text-muted">
            <small>&copy; <?php echo date('Y'); ?> Attendance Management System</small>
        </footer>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Initialize DataTables
            $('#attendanceTable').DataTable({
                language: {
                    search: "<i class='fas fa-search'></i> Search:",
                    searchPlaceholder: "Search workers..."
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
            });
            
            $('#summaryTable').DataTable({
                language: {
                    search: "<i class='fas fa-search'></i> Search:",
                    searchPlaceholder: "Search workers..."
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
            });
            
            // Change status cell background based on selection
            $('.select-status').on('change', function() {
                var value = $(this).val();
                $(this).removeClass('status-present status-absent status-half-day');
                
                if (value === 'Present') {
                    $(this).addClass('status-present');
                } else if (value === 'Absent') {
                    $(this).addClass('status-absent');
                } else if (value === 'Half-Day') {
                    $(this).addClass('status-half-day');
                }
            });
            
            // Trigger the change event for pre-selected values
            $('.select-status').trigger('change');
            
            // Date form submission
            $('#dateForm').on('submit', function() {
                // Add a loading effect if needed
                return true;
            });
            
            // Form submission with SweetAlert
            $('#attendanceForm').on('submit', function(e) {
                e.preventDefault();
                
                // Count how many are marked
                var markedCount = 0;
                $('.select-status').each(function() {
                    if ($(this).val() !== '') {
                        markedCount++;
                    }
                });
                
                if (markedCount === 0) {
                    Swal.fire({
                        title: 'No Attendance Marked',
                        text: 'Please mark attendance for at least one worker.',
                        icon: 'warning',
                        confirmButtonColor: '#4e73df'
                    });
                    return;
                }
                
                Swal.fire({
                    title: 'Save Attendance?',
                    text: `You've marked attendance for ${markedCount} worker(s). Do you want to save?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1cc88a',
                    cancelButtonColor: '#e74a3b',
                    confirmButtonText: 'Yes, Save It!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        $('#submitBtn').html('<span class="loading-spinner mr-2"></span> Saving...');
                        $('#submitBtn').prop('disabled', true);
                        
                        // Submit the form
                        this.submit();
                    }
                });
            });
            
            // Animate elements
            setTimeout(function() {
                $('.animate-in').each(function(index) {
                    var $this = $(this);
                    setTimeout(function() {
                        $this.css('opacity', '1');
                        $this.css('transform', 'translateY(0)');
                    }, index * 100);
                });
            }, 100);
            
            // Quick select buttons
            $('#markAllPresent').on('click', function() {
                $('.select-status').val('Present').trigger('change');
            });
            
            $('#markAllAbsent').on('click', function() {
                $('.select-status').val('Absent').trigger('change');
            });
            
            // Status color indicator
            $('.select-status').each(function() {
                var value = $(this).val();
                if (value === 'Present') {
                    $(this).css('border-left', '4px solid var(--secondary-color)');
                } else if (value === 'Absent') {
                    $(this).css('border-left', '4px solid var(--danger-color)');
                } else if (value === 'Half-Day') {
                    $(this).css('border-left', '4px solid var(--warning-color)');
                } else if (value === 'Leave') {
                    $(this).css('border-left', '4px solid var(--info-color)');
                }
            });
        });
    </script>
</body>
</html>