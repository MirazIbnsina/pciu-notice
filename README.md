# PCIU Notice Board System

## Overview

This project is designed to create a dynamic notice board system for PCIU, ensuring that the latest notices are always accessible to students and staff. The system collects notices from the PCIU website, stores them in a local database, and displays them on a user-friendly webpage with real-time updates.

## Features

- **Automated Data Collection**: Extracts notice content from the PCIU website using their API.
- **Database Storage**: Saves the extracted notices in a local database.
- **Real-Time Updates**: Continuously refreshes to ensure the displayed notices are always up-to-date.
- **User-Friendly Interface**: Displays the latest notices in an easy-to-read format.

## Project Structure

- **data_collection.php**: Collects data from the PCIU website using their API and stores it in the database.
- **update_notices.php**: Periodically refreshes to keep the database updated with the latest notices.
- **index.php**: The main webpage that displays the notices from the database with auto-refresh functionality.
- **styles.css**: Contains the CSS for styling the webpage.
- **scripts.js**: Contains JavaScript for additional functionality, such as auto-refresh.

## Installation

1. **Clone the Repository**:
    ```sh
    git clone https://github.com/yourusername/pcu-notice-board.git
    cd pcu-notice-board
    ```

2. **Database Setup**:
    - Create a new database.
    - Import the provided SQL file to set up the necessary tables.

3. **Configuration**:
    - Update `data_collection.php`, `update_notices.php`, and `index.php` with your database credentials.
    - Ensure the API endpoint for collecting notices is correctly set in `data_collection.php`.

4. **Deployment**:
    - Place the project files on your web server.
    - Set up a cron job to run `update_notices.php` periodically for continuous updates.

## Usage

- **Viewing Notices**:
    - Open `index.php` in your browser to see the latest notices.

- **Updating Notices**:
    - `update_notices.php` will automatically keep your database updated. You can also run it manually if needed.

## Contributing

Contributions are welcome! Please fork the repository and create a pull request with your changes.

## License

This project is licensed under the MIT License. See the LICENSE file for details.
