<h1 align="center">Invoice Manager</h1>

An application that takes the hassle out of the project invoicing process, by automating the collection of work hours completed by employees, and the calculation of project prices.

## TODO
  * *__API__* Write a test script. 
  * *__API__* Finish the save and delete methods of the Database\Entity class.
  * *__API__* Add all API routes to `public/index.php` and write their respective handlers.
  * *__API__* Write the rate-limiting middlewares.
  * *__API__* Write the request logging middleware.
  * *__API__* Comment potentially confusing sections of the codebase.
  * *__API__* Prevent entities outside of localhost from accessing the API.

## System Rules

The Invoice Management application operates within the following guidelines:
  * Employers must create employee accounts. Employees cannot register for their own account.
  * Employees will login with their email, and a password that their employer has assigned them.
  * Employees are unable to change details such as their hourly rate, and their email. Employers must change these details for them.
  * Each employee account will be tied to the employer account that created it. Employers will not be able to view other employer’s employees.
  * Work sessions will be able to be included in multiple invoices, for the sake of application flexibility.
  * Once a work session has been included in an invoice, it will no longer be able to be edited or deleted.
  * Deleting an employee account will not remove it from the database, it will be archived so that all of its work sessions remain valid.
  * Work sessions cannot have a date in the future, although they may be created with dates in the past to allow employees to register work sessions they may have forgotten to create previously.
  * Once an employee account has been deleted (archived), it’s login details are invalidated, and it’s account info may not be edited.
  * Invoices will be presented in a nicely formatted, printable HTML page to allow employers to save invoices to their disk.

## Setup

Ensure that you have NodeJS, Yarn and Composer installed on your system. Run `./build` and copy the contents of the generated `./dist` directory to the root of your web server. Example directory structure:
`http/`
  `api/`
  `employee-app/`
  `employer-dashboard/`

## Tech Stack

### API
  * PHP
  * PDO
  * MySQL

### Employee App
  * HTML, SASS, JS
  * Materialize
  * Yup
  * Webpack
  * Babel

### Employer Dashboard
  * ReactJS
  * Material UI
  * Yup
  * React Router

## Project Structure

### API
  * `config/` global variable definitions such as database credentials and application settings.
  * `public/` resources accessible from outside localhost.
  * `src/` application logic and class definitions.
    * `src/Framework/` reuseable classes for routing and handling database operations.
    * `src/Entity/` classes that act as blueprints for the application's main data structures. 
    * `src/Handler` classes that contain methods for handling certain HTTP requests and sending JSON responses.
    * `src/Middleware` classes that contain methods for processing incoming HTTP requests before/after the matched handler method has executed.
  * `.htaccess` redirects all HTTP requests to `public/index.php`.
