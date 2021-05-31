<h1 align="center">Invoice Manager</h1>

An application that takes the hassle out of the project invoicing process, by automating the collection of work hours completed by employees, and the calculation of project prices.

[Hosted application](https://invoice-manager.online)

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

Ensure that you have NodeJS, Yarn and Composer installed on your system before proceeding.

```sh
git clone https://github.com/brynmailer/invoice-manager.git

```

Create a `.env` file inside the `./api` directory, and add the following variables with the appropriate values:

```
BASE_PATH="PATH TO API DIRECTORY RELATIVE TO LOCALHOST EG. /api"
DB_HOST="YOUR DATABASE HOST"
DB_NAME="YOUR DATABASE NAME"
DB_USERNAME="YOUR DATABASE USERNAME"
DB_PASSWORD="YOUR DATABASE PASSWORD"
PRODUCTION="TRUE OR FALSE"
```

Note: See `./api/config/config.php` for more configuration options.

Next create a `.env` file inside the `./employer-dashboard` directory, and add the following variable with the appropriate value:

```
REACT_APP_API_PATH="PATH TO THE API FROM LOCALHOST EG. /api"
```

Run the `./bundle` script located in the root of this repository, this may require the use of `sudo` in order to instantiate the database. If this is the case composer will ask if you want to proceed as root, type yes and hit enter.

Copy the contents of the generated `./dist` directory to the root directory of your web server.

## Tech Stack

### API
  * PHP
  * PDO
  * MySQL

### Employee App
  * HTML, CSS, JS
  * Materialize

### Employer Dashboard
  * ReactJS
  * Material UI
  * Yup
  * React Router

## Project Structure

### API
  * `config/` global variable definitions such as database credentials and application settings.
  * `public/` resources accessible from outside localhost.
  * `lib/` logic not specific to the project.
    * `lib/Database` ORM functionality.
    * `lib/Api` Routing and API functionality.
  * `src/` application specific logic.
    * `src/Entity/` classes that act as blueprints for the application's main data structures. 
    * `src/Handler/` classes that contain methods for handling certain HTTP requests and sending JSON responses.
    * `src/Middleware/` classes that contain methods for processing incoming HTTP requests before/after the matched handler method has executed.
  * `.htaccess` redirects all HTTP requests to `public/index.php`.

### Employee App
  * `index.html` HTML structure of the application.
  * `css/` application styles.
  * `js/` application logic.
    * `app.js` main JavaScript entry point of the application.
    * `eventHandlers/` functions that handle application events.
    * `lib/` JavaScript code required by external libraries.

## Technologies

All technologies needed to run the application are handled by Composer and Yarn. Please ensure that your system has the most up to date versions of these two programs and NodeJS. Note that you can view the version numbers of these technologies, within their respective `composer.json` or `package.json` files.

### API
  * laminas/laminas-diactoros
  * laminas/laminas-httphandlerrunner
  * mnavarrocarter/path-to-regexp-php
  * vlucas/phpdotenv

### Employee App
  * MaterializeCSS

### Employer Dashboard
  * @material-ui/core
  * @material-ui/data-grid
  * @material-ui/icons
  * @material-ui/lab
  * @react-pdf/renderer
  * axios
  * clsx
  * formik
  * formik-material-ui
  * react
  * react-dom
  * react-router-dom
  * react-scripts
  * shallow-equal
  * yup

## Similarity to PROJ1 Specification

All of the functionality outlined in PROJ1 was implemented exactly as defined, very little changed. The only major change was the technologies used to complete UX2. I ended up going with a vanilla HTML/CSS/JS approach rather than using a templating engine.

## Roadmap

Going forward, I would like to address timezones so that the application can be used with greater accuracy around the world. i would also like to add support for multiple currencies. There is still a bug with the edit invoice functionality in the employer dashboard where the work sessions present in the invoice are not marked as added when the modal opens. This is due to a lack of the key feature that would be needed to implement this using the Material UI data grid. The datagrid currently does not support preselection of rows. These are a few of the thoughts and things I would like to address in the future.

## Security Tests

[Refer to `./PROJ4-screenshots`]

No issues identified. The form validation prevents any out of range data from being submitted, even if it was submitted the server side checks would return errors and prevent it from being processed. The JS injection was not successful either as ReactJS does not allow dynamic content to run as code. The only place it is possible to request a non existent resource from the server is in the invoice PDF page by modifying the URL. An incorrect ID will result in an empty invoice, as expected.
