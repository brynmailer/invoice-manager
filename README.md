<h1 align="center">Invoice Manager</h1>

An application that takes the hassle out of the project invoicing process, by automating the collection of work hours completed by employees, and the calculation of project prices.

## Setup

Clone this repository into your web server root directory. Ensure that you have NodeJS, NPM/Yarn and Composer installed on your system.

```sh
// api
cd invoice-manager/api

composer install


// employee app
cd ../employee-app

// with npm
npm install

// with yarn
yarn
```

## Tech Stack

### API
  * PHP
  * PDO
  * MySQL

### Employee Mobile App
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
