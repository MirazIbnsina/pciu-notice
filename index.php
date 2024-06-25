<?php

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
        'authority: www.portcity.edu.bd',
        'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
        'accept-language: en-US,en;q=0.5',
        'cache-control: max-age=0',
        'dnt: 1',
        'referer: https://www.google.com/',
        'sec-ch-ua: "Not_A Brand";v="8", "Chromium";v="120", "Brave";v="120"',
        'sec-ch-ua-mobile: ?0',
        'sec-ch-ua-platform: "Linux"',
        'sec-fetch-dest: document',
        'sec-fetch-mode: navigate',
        'sec-fetch-site: cross-site',
        'sec-fetch-user: ?1',
        'sec-gpc: 1',
        'upgrade-insecure-requests: 1',
        'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
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

// Find the desired div with class="paragraph-subpage-details"
$xpath = new DOMXPath($dom);
$detailsNodeList = $xpath->query('//div[@class="paragraph-subpage-details"]');

// Extract and output the content in a styled table with absolute URLs
if ($detailsNodeList->length > 0) {
    // Start a styled table with a mobile-friendly design
    echo '<meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
            <style>
            table {
               
                border-collapse: collapse;
                margin: 10px 0;
                overflow-x: auto;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th:nth-child(3), td:nth-child(3) {
                display: none; /* Hide the third column */
            }
            
            body {
                font-family: "Helvetica Neue", sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
                }

                header {
                background-color: #007AFF;
                color: #fff;
                text-align: center;
                padding: 20px;
                margin-bottom: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                display: flex;
                justify-content: space-between;
                align-items: center;
                }

                .menu-option {
                color: #fff;
                text-decoration: none;
                font-size: 24px;
                cursor: pointer;
                }

                .menu-options {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 70px;
                right: 20px;
                background-color: #007AFF;
                border-radius: 12px;
                padding: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .menu-options a {
                color: #fff;
                text-decoration: none;
                padding: 5px;
                margin: 5px 0;
                text-align: left;
                }

                .menu-options a:hover {
                background-color: #0056b3;
                }

                .header-line {
                width: 80%;
                height: 1px;
                background-color: #ddd;
                margin-top: 5px;
                margin-left: 26px;
                }

                .grid-header {
                align-items: center;
                margin-top: 25px;
                padding: 0px 26px;
                }

                .grid-header h3 {
                margin: 0;
                color: #888;
                font-size: 1rem;
                }

                .ios-style-line {
                width: 80%;
                height: 1px;
                background: linear-gradient(to right, #ddd 30%, transparent 70%);
                margin-top: 5px;
                }
          </style> ';
          
       echo    '  <header>
      <div style="display: flex; align-items: center;">
                
                <b style="margin-left: 10px; font-size: 2em; color: #fff;">PCIU Notice</b>  
            </div> 

    <div class="menu-option" onclick="toggleMenu()">&#9776;</div>
    <div class="menu-options" id="menuOptions">
      <a href="#">About</a>
      <a href="#">Contact Us</a>
      <a href="#">Help (FAQ)</a>
    </div>
     
  </header>';

  echo '<div id="toolsSection" class="tool-section visible-section">
    <div class="grid-header">
      <h3>PCIU Update Notices (Top 7)</h3>
      <div class="ios-style-line"></div>
      <p>Data retrieve from pciu official site. To view all the notices, visit the main site.</p>
      
    </div>';
          
          
          
         

    // Start the table
    echo '<div class="table-responsive-sm">
  <table class="table">';

    echo '<tbody id="tableBody">';

    // Loop through each matching div and create a table row (up to 10 rows)
    for ($i = 0; $i < min($detailsNodeList->length, 12); $i++) {
        // Replace relative URLs with absolute URLs for href attributes
        $detailsContent = $dom->saveHTML($detailsNodeList->item($i));
        $detailsContent = str_replace('href="/', 'href="https://www.portcity.edu.bd/', $detailsContent);
        echo '<tr><td>' . $detailsContent . '</td></tr>';
    }

    // End the table body and table
    echo '</tbody></table></div>';
    
    // Add JavaScript to hide additional rows beyond the first 10
    echo '<script>
            var tableBody = document.getElementById("tableBody");
            var rows = tableBody.getElementsByTagName("tr");
            for (var i = 9; i < rows.length; i++) {
                rows[i].style.display = "none";
            }
          </script>';
    
    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-d13BoFdUaR0L6/gSxX8NU6F6VyoOOCwhwbjMKHQFtEz7N4QckqLd7aJuY4mOgqIp" crossorigin="anonymous"></script>
     <script>
    function toggleMenu() {
      var menuOptions = document.getElementById("menuOptions");
      menuOptions.style.display = menuOptions.style.display === "flex" ? "none" : "flex";
    }</script>
          </body>
          </html>';
} else {
    echo 'Details not found';
}
