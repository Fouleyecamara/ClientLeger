 # PHP PDO CRUD Application with MySQL Database

This is a simple PHP PDO CRUD (Create, Read, Update, Delete) application that uses a MySQL database to store and manage data. The application allows users to add, view, edit, and delete records from the database.

## Prerequisites

To run this application, you will need the following:

* PHP 7 or later
* MySQL 5 or later
* A text editor

## Installation

1. Clone the repository to your local machine.
2. Open the `config.php` file and enter your database connection details.
3. Create the database tables by running the `create_tables.sql` script.
4. Start the PHP development server by running `php -S localhost:8000`.

## Usage

To use the application, simply open your web browser and navigate to `http://localhost:8000`. You will see a list of all the records in the database.

To add a new record, click on the "Add" button. You will be presented with a form where you can enter the details of the new record.

To view a record, click on the "View" button. You will be able to see all the details of the record.

To edit a record, click on the "Edit" button. You will be able to change the details of the record.

To delete a record, click on the "Delete" button. You will be prompted to confirm the deletion.

## Code Overview

The application is written in PHP and uses the PDO extension to connect to the MySQL database. The `Modele.php` file contains the database connection logic and the methods for performing CRUD operations on the database.

The `index.php` file is the main entry point of the application. It displays a list of all the records in the database.

The `add.php` file allows users to add new records to the database.

The `view.php` file allows users to view the details of a specific record.

The `edit.php` file allows users to edit the details of a specific record.

The `delete.php` file allows users to delete a specific record from the database.

## Conclusion

This is a simple PHP PDO CRUD application that can be used to manage data in a MySQL database. The application is easy to use and can be customized to meet your specific needs.

Generated by [BlackboxAI](https://www.blackbox.ai)