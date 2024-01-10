# Petzone
# Veterinary Management System

## Overview

Welcome to the Veterinary Management System! This web application is designed to streamline the management of clients, patients, and appointments for a veterinary clinic. The system allows both administrators and employees to perform CRUD operations on clients and patients, as well as view and manage appointments. Clients can also make appointments and check on their patients through the user-friendly interface.

## Technologies Used

- Frontend: HTML, CSS
- Backend: PHP
- Database Management System: MySQL

## Features

1. **Admin Dashboard**
   - Login functionality for administrators.
   - View a list of all clients and patients.
   - Perform CRUD operations on clients and patients.
   - View a comprehensive list of appointments.

2. **Employee Dashboard**
   - Login functionality for employees.
   - View a list of all clients and patients.
   - Perform CRUD operations on clients and patients.
   - View a comprehensive list of appointments.

3. **Client Portal**
   - Register and log in as a client.
   - View information about their registered patients.
   - Make appointments for their patients.

4. **Appointment Management**
   - Schedule new appointments.
   - View a calendar or list of upcoming appointments.
   - Update or cancel existing appointments.

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/MohamedBoghdaddy/Petzone.git
   ```

2. Set up the database:
   - Create a MySQL database.
   - Import the provided SQL file (`database.sql`) to set up the necessary tables.

3. Configure the database connection:
   - Open the `config.php` file.
   - Update the database connection details (host, username, password, and database name).

4. Run the application:
   - Start a local PHP server or use a web server of your choice.
   - Access the application through the browser.

## Usage

1. **Admin and Employee Login:**
   - Access the admin or employee dashboard by logging in with the provided credentials.

2. **Client Registration:**
   - Clients can register using the client registration form.

3. **CRUD Operations:**
   - Admins and employees can perform CRUD operations on clients and patients.

4. **Appointment Management:**
   - Schedule, update, or cancel appointments.

5. **Client Portal:**
   - Clients can log in to view their registered patients and make appointments.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, feel free to open an issue or submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
