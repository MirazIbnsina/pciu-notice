<?php


// Database connection details
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the connection character set to UTF-8
$conn->set_charset("utf8mb4");

// Retrieve data from the database
$sql = "SELECT * FROM notices ORDER BY id";
$result = $conn->query($sql);

// Start HTML output
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCIU Notices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/346a8f2bcd.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: "Helvetica Neue", sans-serif;
            background-color: #f0f2f5;
            padding: 0;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        header {
            background-color: #0b69dd;
            color: #fff;
            padding: 20px 0;
            margin-bottom: 20px;
            text-align: center;
        }
        header h1 {
            font-size: 1.5rem;
            margin: 0;
        }
        .card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border-left: 5px solid #007AFF; /* Blue border color by default */
        }
        .card:first-of-type {
            border-left-color: #0b325c; /* Red border color for the first notice */
        }
        .card-header {
            background-color: #007AFF;
            color: #fff;
            padding: 10px 20px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            font-size: 1rem;
            text-align: right;
            margin-bottom: 0; /* Reduce bottom margin */
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #007AFF; /* Title color */
        }
        .card-text {
            color: #333; /* Body text color */
        }
        .refresh-button {
            margin-top: 10px;
            text-align: center;
        }
        .light-text {
            color: #777;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 10px;
        }
        .light-hr {
            border-top: 1px solid #ddd;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .refresh-btn {
            padding: 6px 12px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>';

// Header section
echo '<header>
    <div class="container">
        <h1><i class="fa-solid fa-magnifying-glass-chart"></i> PCIU Notices (Top 7)</h1>
    </div>
</header>';

// Notices section
echo '<section class="container">';

// Add paragraph and horizontal rule
echo '<p class="light-text">Below are the latest notices from PCIU Notice page, for the fastest and simpliest view  <i class="fa-solid fa-wand-sparkles"></i> </p>';
echo '<hr class="light-hr">';

if ($result->num_rows > 0) {
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card">';
        echo '<div class="card-header">Notice #' . $counter . '</div>';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">';
        if ($counter == 1) {
            echo '<span style="color: #0b325c;"> <i class="fa-solid fa-star"></i> ' . htmlspecialchars($row["date"]) . '</span>';
        } else {
            echo '<i class="fa-regular fa-calendar-check"></i> ' . htmlspecialchars($row["date"]);
        }
        echo '</h5>';
        echo '<p class="card-text">' . htmlspecialchars($row["content"]) . '</p>';
        echo '<a href="' . htmlspecialchars($row["download_link"]) . '" class="btn btn-primary">View <i class="fa-solid fa-angle-down"></i> </a>';
        echo '</div>';
        echo '</div>';
        $counter++;
    }
} else {
    echo '<p class="text-center">No notices found.</p>';
}



// Refresh button
echo '<div class="refresh-button"> 
    <p class="light-text">Notice updates automatically using Crons. If not updated, <a class="light-text" href="http://pciunotice.42web.io/autoload.php"><b> click here to refresh <i class="fa-solid fa-retweet"></i></b></a></p>
</div>';
echo '<hr class="light-hr">';
echo ' <p class="light-text"><a class="light-text" href="https://github.com/MirazIbnsina/pciu-notice"><i class="fa-brands fa-github"></i></a> <a  class="light-text" href="https://bd.linkedin.com/in/mirazibnsina"><i class="fa-brands fa-linkedin"></i></a>
 
<a  class="light-text" href="https://t.me/XanderCase">
<i class="fa fa-telegram" aria-hidden="true"></i>
</a>


</p>';
echo '</section>';
// Include Bootstrap JS for responsive behavior
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>';

// Close the database connection
$conn->close();

// Close the HTML document
echo '</body>
</html>';
?>
