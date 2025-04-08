<?php
session_start();

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../adminlogin.html"); // Redirect to login if session is not set
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meri Gaddi - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .user-page {
    width: 50%; /* Default size */
    transition: width 0.5s ease; /* Smooth transition effect */
}
        body {
            background-color: #f5f5f5;
            color: #333;
        }
        
        /* Sidebar styles */
        .sidebar {
            position: fixed;
            height: 100%;
            width: 250px;
            background: linear-gradient(135deg, #2c3e50, #1a2530);
            padding-top: 20px;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }
        
        .logo-title {
            font-size: 28px;
            font-weight: bold;
            color: white;
        }
        
        .logo-subtitle {
            color: #ff4757;
            font-weight: bold;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li {
            padding: 0;
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #ddd;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #ff4757;
            color: white;
        }
        
        .sidebar-menu i {
            margin-right: 10px;
            font-size: 18px;
            width: 25px;
            text-align: center;
        }
        
        /* Main content styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .menu-toggle {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #2c3e50;
            display: none;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
        }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }
        
        .user-profile span {
            font-weight: 600;
        }
        
        .search-bar {
            flex-grow: 1;
            margin: 0 20px;
        }
        
        .search-bar input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        /* Content area styles */
        .content-area {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            min-height: 600px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding-top: 10px;
            }
            
            .sidebar-header {
                padding: 10px;
            }
            
            .logo-title, .logo-subtitle {
                display: none;
            }
            
            .sidebar-menu a span {
                display: none;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .menu-toggle {
                display: block;
            }
            
            .sidebar.expanded {
                width: 250px;
            }
            
            .sidebar.expanded .logo-title,
            .sidebar.expanded .logo-subtitle,
            .sidebar.expanded .sidebar-menu a span {
                display: block;
            }
            
            .main-content.shifted {
                margin-left: 250px;
            }
        }
        
        /* Additional utility classes */
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }
        
        .stat-card i {
            font-size: 40px;
            margin-right: 20px;
            color: #ff4757;
        }
        
        .stat-card .stat-info h3 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .stat-card .stat-info p {
            color: #777;
            font-size: 14px;
        }
        
        .recent-activity {
            margin-top: 20px;
        }
        
        .recent-activity h2 {
            margin-bottom: 15px;
            color: #2c3e50;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-item i {
            font-size: 20px;
            margin-right: 15px;
            color: #ff4757;
        }
        
        .activity-item .activity-details {
            flex-grow: 1;
        }
        
        .activity-item .activity-time {
            color: #777;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-title">Meri <span class="logo-subtitle">Gaddi</span></div>
        </div>
        
        <ul class="sidebar-menu">
            <li><a href="graph.php" onclick="loadPage('graph')"><i class="fas fa-home"></i> <span>Graph</span></a></li>
            <li><a href="#" onclick="loadPage('vendor')"><i class="fas fa-store"></i> <span>Vendors</span></a></li>
            <li><a href="#" onclick="loadPage('vehicles')"><i class="fas fa-car"></i> <span>Vehicles</span></a></li>
            <li><a href="#" onclick="loadPage('workers')"><i class="fas fa-users"></i> <span>Workers</span></a></li>
            <li><a href="worker_payment.php" onclick="loadPage('worker_payment')"><i class="fas fa-money-bill-wave"></i> <span>Payment</span></a></li>
            <li><a href="#" onclick="loadPage('service_record')"><i class="fas fa-clipboard-list"></i> <span>Service Records</span></a></li>
            <li><a href="#" onclick="loadPage('feedback')"><i class="fas fa-comment-alt"></i> <span>Feedback</span></a></li>
            <li><a href="#" onclick="loadPage('users')" ><i class="fas fa-user"></i> <span>Users</span></a></li>
            <li><a href="post.php" onclick="loadPage('post')"><i class="fas fa-newspaper"></i> <span>Posts</span></a></li>
            <li><a href="adminlogout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
        </ul>
    </div>
    

    </script>
    <!-- Main Content -->
    <div class="main-content" id="main-content">
       
        
        <!-- Content Area -->
        <div class="content-area" id="column2">
            <!-- Content will be loaded here -->
        </div>
    </div>
    
    <script>
        // Toggle sidebar
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('expanded');
            document.getElementById('main-content').classList.toggle('shifted');
        });
        
        // Function to load graph data
        function loadGraphData() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "graph.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("column2").innerHTML = xhr.responseText;
                    
                    // Set the active menu item
                    setActiveMenuItem('home');
                }
            };
            xhr.send();
        }
        
        // Function to load content dynamically into the content area
        function loadPage(page) {
            const contentArea = document.getElementById('column2');
            let pageURL = '';

            switch (page) {
                // case 'home':
                //     pageURL = 'intro.php';
                //     break;
                case 'vendor':
                    pageURL = 'vendor.php';
                    break;    
                case 'workers':
                    pageURL = 'workers.php';
                    break;
                case 'service_record':
                    pageURL = 'service_record.php';
                    break;
                case 'feedback':
                    pageURL = 'feedback.php';
                    break;
                case 'users':
                    pageURL = 'users.php';
                    break;
                case 'vehicles':
                    pageURL = 'vehicle.php';
                    break;
                // case 'worker_payment':
                //     pageURL = 'worker_payment.php';
                //     break;
                // case 'post':
                //     pageURL = 'post.php';
                //     break;
                default:
                    pageURL = 'intro.php';
            }

            // Fetch the selected page content using the URL
            fetch(pageURL)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(data => {
                    contentArea.innerHTML = data;
                    
                    // Set the active menu item
                    setActiveMenuItem(page);
                })
                .catch(error => {
                    console.error('Error loading the page:', error);
                    contentArea.innerHTML = 'Error loading page content.';
                });
        }

        function loadPostPage() {
            fetch('post.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('postContainer').innerHTML = data;
                })
                .catch(error => console.error('Error loading page:', error));
        }
        
        // Function to set active menu item
        function setActiveMenuItem(page) {
            // Remove active class from all menu items
            document.querySelectorAll('.sidebar-menu a').forEach(item => {
                item.classList.remove('active');
            });
            
            // Add active class to current menu item
            if (page === 'home') {
                document.querySelector('.sidebar-menu a[onclick="loadGraphData()"]').classList.add('active');
            } else {
                document.querySelector(`.sidebar-menu a[onclick="loadPage('${page}')"]`).classList.add('active');
            }
        }

        // Load graph.php by default when the page first loads
        document.addEventListener("DOMContentLoaded", function() {
            loadGraphData();
        });
        
        document.getElementById("userBtn").addEventListener("click", function() {
    let userPage = document.getElementById("userContainer");

    // Adjust width dynamically
    // if (userPage.style.width === "100%") {
    //     userPage.style.width = "50%"; // Shrink to half
    // } else {
    //     userPage.style.width = "100%"; // Expand fully
    // }
});
    </script>
</body>
</html>
