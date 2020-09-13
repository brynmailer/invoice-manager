<h1 align="center">Invoice Manager</h1>

An application that takes the hassle out of the project invoicing process, by automating the collection of work hours completed by employees, and the calculation of project prices.

## Installation

Clone this repository into your web server root directory. Ensure that you have NodeJS, NPM/Yarn and Composer installed on your system.

```sh
cd invoice-manager/api

composer install

cd ../employee-app

// with npm
npm install

// with yarn
yarn
```

## Tech Stack

Employee Mobile App
  - HTML, SASS, JS
  - Materialize
  - Yup
  - Webpack4
  - Babel

Employer Dashboard
  - ReactJS
  - Material UI
  - Yup
  - React Router

API
  - PHP7
  - PDO
  - MySQL
