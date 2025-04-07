<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch posts
$sql = "SELECT * FROM posts ORDER BY DATE DESC";
$result = $conn->query($sql);

// Count total posts
$total_posts = $result->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Service Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2ecc71;
            --secondary-dark: #27ae60;
            --danger: #e74c3c;
            --danger-dark: #c0392b;
            --text: #333;
            --text-light: #6c757d;
            --gray-light: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --radius: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
            color: var(--text);
            line-height: 1.6;
        }

        .header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            padding: 2rem 0;
            text-align: center;
            box-shadow: var(--shadow);
        }

        .header h1 {
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-weight: 300;
            max-width: 600px;
            margin: 0 auto;
            opacity: 0.9;
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 1rem;
        }

        .stat {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            font-size: 0.9rem;
        }

        .stat i {
            margin-right: 0.5rem;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 2rem auto;
            display: flex;
            gap: 2rem;
        }

        .main-content {
            flex: 7;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .post {
            background: var(--white);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .post:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .post-image {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .post img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .post:hover img {
            transform: scale(1.05);
        }

        .post-date {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--primary);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .post-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .post-meta {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            color: var(--text-light);
            font-size: 0.85rem;
        }

        .post-meta i {
            margin-right: 0.4rem;
            color: var(--primary);
        }

        .post h2 {
            color: var(--text);
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            font-weight: 600;
            line-height: 1.3;
        }

        .post-excerpt {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-actions {
            display: flex;
            justify-content: space-between;
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn i {
            margin-right: 0.4rem;
        }

        .btn-edit {
            background-color: var(--secondary);
            color: white;
        }

        .btn-edit:hover {
            background-color: var(--secondary-dark);
        }

        .btn-delete {
            background-color: var(--danger);
            color: white;
        }

        .btn-delete:hover {
            background-color: var(--danger-dark);
        }

        .sidebar {
            flex: 3;
            max-width: 350px;
        }

        .sidebar-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
        }

        .sidebar-title {
            color: var(--text);
            font-size: 1.25rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--primary);
            text-align: center;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e1e5e9;
            border-radius: 5px;
            font-size: 0.9rem;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .file-input-wrapper {
            position: relative;
            margin-top: 0.5rem;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            border: 2px dashed #e1e5e9;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .file-input-label:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .file-input-label i {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }

        input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary);
            color: white;
            font-weight: 500;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 1rem;
            transition: background 0.3s ease;
            border: none;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
        }

        .sidebar-action {
            text-align: center;
            margin-top: 0.5rem;
        }

        .sidebar-action a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .sidebar-action a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 3rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-light);
            max-width: 500px;
            margin: 0 auto;
        }

        .footer {
            background-color: var(--primary-dark);
            color: var(--white);
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }

        .footer p {
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--white);
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        @media (max-width: 992px) {
            .container {
                flex-direction: column;
            }
            .sidebar {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 1.5rem 0;
            }
            .header h1 {
                font-size: 1.8rem;
            }
            .stats {
                flex-direction: column;
                gap: 0.5rem;
            }
            .main-content {
                grid-template-columns: 1fr;
            }
            .container {
                width: 95%;
            }
        }

        /* Animation for notification */
        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background-color: var(--secondary);
            color: white;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            z-index: 1000;
            animation: slideDown 0.5s ease forwards;
        }

        .notification i {
            margin-right: 10px;
            font-size: 20px;
        }

        .notification.error {
            background-color: var(--danger);
        }

        .file-name {
            margin-top: 8px;
            font-size: 12px;
            color: var(--primary);
            text-align: center;
            display: none;
        }

        /* Navigation bar */
        .navbar {
            background-color: var(--white);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .nav-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }

        .nav-links a {
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a.active {
            color: var(--primary);
        }

        /* Back to home button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background-color: var(--primary);
            color: white;
        }

        .back-btn i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-content">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $content_excerpt = substr(strip_tags($row['CONTENT']), 0, 120) . '...';
                    
                    echo '<div class="post">';
                    echo '<div class="post-image">';
                    if (!empty($row['IMAGE'])) {
                        echo '<img src="' . htmlspecialchars($row['IMAGE']) . '" alt="' . htmlspecialchars($row['TITLE']) . '">';
                    } else {
                        echo '<img src="https://via.placeholder.com/800x400?text=Auto+Service" alt="Default Image">';
                    }
                    echo '<div class="post-date">' . date('M j, Y', strtotime($row['DATE'])) . '</div>';
                    echo '</div>';
                    
                    echo '<div class="post-content">';
                    echo '<div class="post-meta"><i class="fas fa-user"></i> ' . htmlspecialchars($row['NAME']) . '</div>';
                    echo '<h2>' . htmlspecialchars($row['TITLE']) . '</h2>';
                    echo '<div class="post-excerpt">' . htmlspecialchars($content_excerpt) . '</div>';
                    
                    echo '<div class="post-actions">';
                    echo '<a href="post_update.php?id=' . $row['ID'] . '" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>';
                    echo '<a href="post_delete.php?id=' . $row['ID'] . '" onclick="return confirm(\'Are you sure you want to delete this post?\');" class="btn btn-delete"><i class="fas fa-trash-alt"></i> Delete</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="empty-state">';
                echo '<i class="fas fa-file-alt"></i>';
                echo '<h3>No Posts Yet</h3>';
                echo '<p>Be the first to create a post and share your thoughts!</p>';
                echo '</div>';
            }
            $conn->close();
            ?>
        </div>
        
        <aside class="sidebar">
            <div class="sidebar-card">
                <h3 class="sidebar-title">Create New Post</h3>
                <form action="postdb.php" method="post" enctype="multipart/form-data" id="postForm">
                    <div class="form-group">
                        <label for="title">Post Title</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter post title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="content">Post Content</label>
                        <textarea id="content" name="content" class="form-control" placeholder="Write your post content here..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Author Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Your name" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Featured Image</label>
                        <div class="file-input-wrapper">
                            <label for="image" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt"></i> Choose an image
                            </label>
                            <input type="file" id="image" name="image" accept="image/*" onchange="showFileName(this)">
                            <div id="fileName" class="file-name"></div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Publish Post
                    </button>
                </form>
            </div>
            
            <div class="sidebar-card">
                <h3 class="sidebar-title">Quick Actions</h3>
                <a href="http://localhost/final%20year/php/adminindex.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </aside>
    </div>
    
   

    <script>
        function showFileName(input) {
            const fileNameDiv = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                fileNameDiv.textContent = input.files[0].name;
                fileNameDiv.style.display = 'block';
            } else {
                fileNameDiv.textContent = '';
                fileNameDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>