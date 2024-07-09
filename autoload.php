<?php

// Database connection details
$servername = "";
$username = "";
$password = "";
$dbname = "notice";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the connection character set to UTF-8
$conn->set_charset("utf8mb4");

// Initialize cURL session
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://www.portcity.edu.bd/HomePage/SubPageDetailsPara/13/Page/notices',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
        'accept-language: en-US,en;q=0.5',
        'cache-control: max-age=0',
        'priority: u=0, i',
        'referer: https://www.google.com/',
        'sec-ch-ua: "Brave";v="125", "Chromium";v="125", "Not.A/Brand";v="24"',
        'sec-ch-ua-mobile: ?1',
        'sec-ch-ua-platform: "Android"',
        'sec-fetch-dest: document',
        'sec-fetch-mode: navigate',
        'sec-fetch-site: cross-site',
        'sec-fetch-user: ?1',
        'sec-gpc: 1',
        'upgrade-insecure-requests: 1',
        'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Mobile Safari/537.36'
    ),
));

$response = curl_exec($curl);
curl_close($curl);

// Check if the request was successful
if ($response === false) {
    die('Error fetching data');
}

// Use DOMDocument to parse the HTML
$dom = new DOMDocument;
libxml_use_internal_errors(true); // Enable error handling

// Load the HTML content
$dom->loadHTML($response);

// Find the table rows
$xpath = new DOMXPath($dom);
$rows = $xpath->query('//tbody/tr');

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO notices (date, content, download_link) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $date, $content, $download_link);

// Clear the existing data
$conn->query("TRUNCATE TABLE notices");

// Loop through each row and extract the data
for ($i = 0; $i < min(7, $rows->length); $i++) {
    $row = $rows->item($i);
    $cols = $row->getElementsByTagName('td');

    // Ensure the row has the expected number of columns
    if ($cols->length == 4) {
        $date = trim($cols->item(0)->textContent);
        $content = trim($cols->item(1)->textContent);
        $download_link = 'https://www.portcity.edu.bd' . trim($cols->item(3)->getElementsByTagName('a')->item(0)->getAttribute('href'));

        // Insert the row into the database
        $stmt->execute();
    } else {
        echo "Skipping row with unexpected number of columns: " . $cols->length . "\n";
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();



header("Location: http://pciunotice.42web.io/");
exit();


?>
