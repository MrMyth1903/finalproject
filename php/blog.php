<?php
// Fetch posts from the database (assuming you have a database connection here)
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}
// Sample connection (make sure to update with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch posts
$sql = "SELECT ID, TITLE, CONTENT, NAME, DATE, IMAGE FROM posts";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <!-- Font Awesome for icons -->
    <link rel="icon" href="photo/Untitled-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --success-dark: #4361ee;
            --danger: #f72585;
            --dark: #212529;
            --light: #f8f9fa;
            --border: #e9ecef;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
            overflow-x: hidden;
        }
        
        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            opacity: 0.5;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        /* Header Styles */
        header {
            background: linear-gradient(135deg, rgba(24, 24, 27, 0.9), rgba(39, 39, 42, 0.8));
            color: white;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .logo img {
            width: 70px;
            height: 70px;
            margin-right: 10px;
            transition: transform 0.3s ease;
        }
        
        .logo img:hover {
            transform: scale(1.05);
        }
        
        .right-header {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .right-header a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .right-header a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .right-header a:hover::before {
            left: 0;
        }
        
        .nav-link {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .accent-link {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }
        
        .accent-link:hover {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.3);
        }
        
        /* User Menu Styles */
        .user-menu {
            position: relative;
            display: inline-block;
        }
        
        .user-email {
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 6px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }
        
        .user-email:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.3);
        }
        
        .user-icon {
            font-size: 16px;
        }
        
        .logout-menu {
            display: none;
            position: absolute;
            top: 120%;
            right: 0;
            background: white;
            border-radius: 8px;
            width: 180px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            overflow: hidden;
            animation: slideDown 0.3s ease forwards;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logout-menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: var(--dark);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border);
        }
        
        .logout-menu-item:last-child {
            border-bottom: none;
            color:#18181b;
        }
        
        .logout-menu-item i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            color:#18181b;
        }
        
        .logout-menu-item:hover {
            background-color:rgb(245, 245, 245);
            padding-left: 20px;
        }
        
        .logout-menu-item.danger {
            color: var(--danger);
        }
        
        .logout-menu-item.danger:hover {
            background-color: rgba(247, 37, 133, 0.05);
        }
        
        /* Show logout when hovering over email */
        .user-menu:hover .logout-menu {
            display: block;
        }
        
        /* Page Title Styles */
        .page-header {
            text-align: center;
            margin: 40px 0 30px;
            position: relative;
        }
        
        .page-title {
            font-size: 32px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        .subtitle {
            color: #6c757d;
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Orders Table Styles */
        .data-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 40px;
            overflow: hidden;
            position: relative;
        }
        
        .data-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        :root {
            --primary-color: #3a6ea5;
            --secondary-color: #ff6b6b;
            --accent-color: #6c63ff;
            --background-color: #f9f9f9;
            --card-bg: #ffffff;
            --text-primary: #333333;
            --text-secondary: #666666;
            --spacing-sm: 8px;
            --spacing-md: 16px;
            --spacing-lg: 24px;
            --border-radius: 12px;
            --box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--spacing-lg) 0;
        }

                .blog-title {
            text-align: center;
            margin-bottom: var(--spacing-lg);
        }

        .blog-title h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: var(--spacing-sm);
        }

        .blog-title p {
            color: var(--text-secondary);
            max-width: 700px;
            margin: 0 auto;
        }

        .featured-posts {
            margin-bottom: var(--spacing-lg);
        }

        .featured-posts-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-md);
        }

        .featured-posts-title h3 {
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .view-all {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .view-all:hover {
            text-decoration: underline;
        }

        #posts-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--spacing-lg);
            width: 100%;
        }

        .post {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .post:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .post-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .post-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .post:hover .post-image img {
            transform: scale(1.05);
        }

        .post-category {
            position: absolute;
            top: var(--spacing-md);
            left: var(--spacing-md);
            background-color: var(--secondary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .post-content {
            padding: var(--spacing-md);
        }

        .post-meta {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-sm);
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .post-meta i {
            margin-right: 5px;
        }

        .post-author {
            margin-right: var(--spacing-md);
        }

        .post-title {
            font-size: 1.3rem;
            margin-bottom: var(--spacing-sm);
            color: var(--text-primary);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-excerpt {
            color: var(--text-secondary);
            margin-bottom: var(--spacing-md);
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .read-more {
            display: inline-block;
            padding: 8px 20px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .read-more:hover {
            background-color: #5a52d5;
            transform: translateY(-2px);
        }

        footer {
    background-color: #333;
    color: #fff;
    padding: 2rem 0;
    font-size: 0.9rem;
    backdrop-filter: blur(2px);
    transition: top 0.3s;
}

.footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.footer-section {
    flex: 1 1 200px;
    margin: 1rem;
}

.footer-section h3 {
    border-bottom: 2px solid #0073e6;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 0.5rem;
}

.footer-section ul li a {
    color: #fff;
    text-decoration: none;
}

.footer-section ul li a:hover {
    text-decoration: underline;
}

.social-icons a {
    display: inline-block;
    margin-right: 10px;
}

.social-icons img {
    width: 24px;
    height: 24px;
}

.footer-bottom {
    text-align: center;
    margin-top: 1rem;
    border-top: 1px solid #444;
    padding-top: 1rem;
}

        .no-posts {
            grid-column: 1 / -1;
            text-align: center;
            padding: var(--spacing-lg);
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: var(--spacing-md);
            }
            
            .search-bar {
                width: 100%;
            }
            
            .search-bar input {
                width: 100%;
            }
            
            #posts-container {
                grid-template-columns: 1fr;
            }
            
            .newsletter-form {
                flex-direction: column;
                gap: var(--spacing-sm);
            }
            
            .newsletter-form input,
            .newsletter-form button {
                width: 100%;
                border-radius: 30px;
            }
        }

        @media (max-width: 480px) {
            .nav-links {
                flex-direction: column;
                align-items: center;
                gap: var(--spacing-sm);
            }
        }
    </style>
</head>
<body>
<header>
        <div class="header-container">
            <div class="logo">
                <img src="photo/Blue_Gold_Minimalist_Car_Showroom_Logo-removebg-preview.png" alt="Vehicle Logo">
            </div>
            <div class="right-header">
                <a href="../home.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
                <a href="blog.php" class="nav-link"><i class="fas fa-blog"></i> Blog</a>
                <a href="../appointment.php" class="accent-link"><i class="fas fa-calendar-check"></i> Book Appointment</a>
                <div class="user-menu">
                    <div class="user-email">
                        <i class="fas fa-user-circle user-icon"></i>
                        <?php echo htmlspecialchars($_SESSION['email']); ?>
                        <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                    </div>
                    <div class="logout-menu">
                        <a href="orderdetails.php" class="logout-menu-item">
                            <i class="fas fa-clipboard-list"></i> My Orders
                        </a>
                        <a href="../logout.php" class="logout-menu-item danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

        <div class="blog-title">
            <h2>Blog Posts</h2>
            <p>Discover my latest thoughts, projects, and adventures</p>
        </div>

        <section class="featured-posts">
            <div class="featured-posts-title">
                <h3>Featured Posts</h3>
                <a href="#" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
            </div>

            <div id="posts-container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Get the first 150 characters for the excerpt
                        $excerpt = substr(strip_tags($row['CONTENT']), 0, 150) . '...';
                        
                        // Default image if none exists
                        $image = !empty($row['IMAGE']) ? htmlspecialchars($row['IMAGE']) : 'https://via.placeholder.com/400x250';
                        
                        echo '<div class="post">';
                        echo '<div class="post-image">';
                        echo '<img src="' . $image . '" alt="Blog Image">';
                        echo '<span class="post-category">Blog</span>';
                        echo '</div>';
                        echo '<div class="post-content">';
                        echo '<div class="post-meta">';
                        echo '<span class="post-author"><i class="fas fa-user"></i> ' . htmlspecialchars($row['NAME']) . '</span>';
                        echo '<span class="post-date"><i class="fas fa-calendar"></i> ' . date('F j, Y', strtotime($row['DATE'])) . '</span>';
                        echo '</div>';
                        echo '<h3 class="post-title">' . htmlspecialchars($row['TITLE']) . '</h3>';
                        echo '<p class="post-excerpt">' . $excerpt . '</p>';
                        
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="no-posts">';
                    echo '<i class="fas fa-file-alt" style="font-size: 3rem; color: #ccc; margin-bottom: 16px;"></i>';
                    echo '<p>No posts available at the moment. Check back soon!</p>';
                    echo '</div>';
                }
                $conn->close();
                ?>
            </div>
        </section>

        
    </div>

    <footer>
    <div class="footer-container">
        <div class="footer-section">
            <h3>Helping</h3>
            <ul>
                <li>In this platform we add local gaurage owner and help them to take their bussiness online</li>
                
            </ul>
        </div>
        <div class="footer-section">
            <h3>Services</h3>
            <ul>
                <li><a href="appointment.html">Car Maintenance</a></li>
                <li><a href="appointment.html">Bike Servicing</a></li>
                <li><a href="emergencyrepair.html">Emergency Repairs</a></li>
                <li><a href="spareparts.html">Spare Parts</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>Email: merigaddi0008@gmail.com</p>
            <p>Phone: +91 8340300338</p>
        </div>
        <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="social-icons">
                <a href="https://www.facebook.com/profile.php?id=61573648584570"><img src="facebook-icon.png" alt="Facebook"></a>
                <a href="https://x.com/merigaddi0008"><img src="twitter-icon.png" alt="Twitter"></a>
                <a href="https://www.threads.net/@merigaddi0008"><img src="twitter-icon.png" alt="Thread"></a>
                <a href="https://www.instagram.com/merigaddi0008?igsh=MXg0OWhjc3ExMThzbw=="><img src="instagram-icon.png" alt="Instagram"></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 Vehicle Servicing System. All rights reserved.</p>
    </div>
</footer>


</body>
</html>