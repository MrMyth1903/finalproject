<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Layout with Included Page</title>
    <style>
        /* Styling for the header section */
        p {
            font-size: 34px;
            font-weight: bold;
        }

        span {
            color: red;
            font-weight: bold;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: lightblue;
            height: 100px;
            padding: 0 20px;
            flex-direction: row;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 90px;
            height: 90px;
            margin-right: 10px;
        }

        .header .right-buttons {
            display: flex;
            align-items: center;
        }

        .header .right-buttons button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 15px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin-left: 10px;
        }

        .header .right-buttons button:hover {
            background-color: #0056b3;
        }

        .dropdown {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            padding: 5px 0;
            border-radius: 5px;
            margin-top: 5px;
        }

        .dropdown button {
            background-color: #28a745;
            color: white;
            padding: 12px 16px;
            text-align: left;
            border: none;
            width: 100%;
            border-radius: 5px;
        }

        .dropdown button:hover {
            background-color: #218838;
        }

        /* Second Row Content */
        .row {
            width: 100%;
            padding: 10px;
        }

        /* Styling for the content area */
        #column2 {
            min-height: 500px;
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

    <!-- Header Section with Logo on Left and Buttons on Right -->
    <div class="header">
        <!-- Left side with logo -->
        <div class="logo">
            <center><p>Meri <br><span>Gaddi</span></p></center>
        </div>

        <!-- Right side with buttons -->
        <div class="right-buttons">
            <button onclick="loadGraphData()">Home</button>
            <button onclick="loadPage('vehicles')">Vehicle</button>
            <button onclick="loadPage('workers')">Workers</button>
            <button onclick="loadPage('service_record')">Service Record</button>
            <button onclick="loadPage('feedback')">Feedback</button>
            <button onclick="loadPage('users')">Users</button>
            <button onclick="loadPage('post')">Post</button>
        </div>
    </div>

       
        <div id="column2">
            <!-- Initially empty, will be populated by JavaScript -->
            <script>
    function loadGraphData() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "graph.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("column2").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>
        </div>



    <script>
        // Function to load content dynamically into the second column
        function loadPage(page) {
            const column2 = document.getElementById('column2');
            let pageURL = '';

            switch (page) {
                case 'home':
                    pageURL = 'graph.php'; // Load graph.php when Home is clicked
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
                case 'post':
                    pageURL = 'post.php';
                    break;
                default:
                    pageURL = 'admin.php';
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
                    column2.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error loading the page:', error);
                    column2.innerHTML = 'Error loading page content.';
                });
        }

        // Load graph.php by default when the page first loads
        document.addEventListener("DOMContentLoaded", function() {
            loadPage('home');
        });
    </script>

</body>
</html>
