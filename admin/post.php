<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Blog with PHP</title>
    <link rel="stylesheet" href="admin\css/post.css">
</head>
<style>
    /* Basic Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

.container {
    width: 80%;
    margin: 0 auto;
}

header {
    background-color: #333;
    color: white;
    padding: 1rem 0;
    text-align: center;
}

header h1 {
    margin-bottom: 10px;
}

nav ul {
    list-style-type: none;
    margin-top: 10px;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    color: white;
    text-decoration: none;
}

.main-content {
    display: flex;
    margin-top: 20px;
}

#posts-container {
    width: 75%;
}

.sidebar {
    width: 25%;
    padding: 20px;
    background-color: #e9e9e9;
    margin-left: 20px;
}

.sidebar h3 {
    margin-bottom: 10px;
}

#addPostForm input, #addPostForm textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
}

#addPostForm button {
    padding: 10px 20px;
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
}

footer {
    text-align: center;
    padding: 1rem;
    background-color: #333;
    color: white;
    margin-top: 20px;
}

</style>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <h1>My Dynamic Blog</h1>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <div id="posts-container">
                <!-- Blog posts will be dynamically loaded here -->
            </div>

            <!-- Sidebar -->
            <aside class="sidebar">
                <h3>Add a New Post</h3>
                <form id="addPostForm">
                    <input type="text" id="title" placeholder="Post Title" required>
                    <textarea id="content" placeholder="Post Content" required></textarea>
                    <input type="text" id="author" placeholder="Your Name" required>
                    <button type="submit">Add Post</button>
                </form>
            </aside>
        </div>

        <!-- Footer -->
        <footer>
            <p>© 2025 My Dynamic Blog. All Rights Reserved.</p>
        </footer>
    </div>

    <script src="jscript/script.js"></script>
</body>
</html>
