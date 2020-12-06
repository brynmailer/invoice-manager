# PROJ3 Metacognition

## Frameworks

### ReactJS
The architectural framework used to develop this application was ReactJS. This framework was chosen due to its clear design patterns and straight-forward approach to modern web application development. ReactJS is also one of the most widely utilised JS frameworks for building web applications, meaning that this choice ensured that there would always be ample documentation to refer to throughout the development process.

### Material UI
Material UI was the component library chosen for this project. The main reason for choosing this framework was its seamless integration with ReactJS. This library was written specifically to be used within ReactJS applications. The components it contains were also written to conform to Google's Material Design specification, which gives the components a pleasing appearance.

### Yup
All form validation was handled through the use of Yup. Yup allows you to define schema objects for each of your forms that enforce all kinds of data constraints such as minimum and maximum length, email format etc. When your form is submitted Yup will ensure that the data present is valid automatically.

## Other Possible Frameworks

A number of other frameworks were considered before a concrete decision was made, these include:

* Bootstrap [component library]
* Semantic UI [component library]
* Materialize CSS [component library]
* Vue [architectural framework]
* Angular [architectural framework]
* Laravel [architectural framework]

## Authentication

When the employer dashboard is accessed, it queries the API to check whether the user is logged in. If so, the user is directed to the main dashboard page and can continue to use the service as usual. If the user is not signed in, they are directed to the login page, where they may choose to either log in using existing credentials, or register for a new account. A user's authentication state is stored in their particular session object on the server, and is linked to the users browser by a cookie that gets sent along side every request to the API.

## Password Protection

User passwords are protected through the use of the bcrypt algorithm, a one way hashing algorithm designed to be irreversible. With the rate at which our processing capabilities are increasing, older algorithms like MD5 and SHA1 are no longer strong enough to protect user's passwords, leaving bcrypt as the obvious choice.
