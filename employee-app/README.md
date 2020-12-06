# Employee App

## Roadmap

The UI of this mobile application still possesses a few visual bugs and inconsistencies that are important to fix in the near future. As well as smoothing out the UI, there are a few features such as a work session search bar, and work session categorization that would be good to develop in order to provide a better user experience. It is also important that the application implements an architectural framework some time soon, whether this is ReactJS or another framework is yet to be decided.

## Importance of Properly Building and Documenting the Application

Proper bundling and documenting of the finished application is incredibly important as it ensures that the application is installed and used correctly. This helps to prevent possible technical resulting from misuse. This process greatly simplifies the task of deploying the application and results in a much smoother experience.

## Further Documentation

Other types of documentation that may be necessary for this project include:

* Verbose deployment instructions
* Code style guidelines
* Design plans and wireframes
* Code structure explanations

## What Went Well?

The development of the collapsible work session diplay on the main page was significantly easier than expected. It was a pleasant surprise to learn that Materialize CSS already included a collapsible component that was able to be easily customized to handle the specific use case. It was anticipated that the development of that particular feature would take a couple days, but it only ended up taking a 1-2 hours.

## What Was Difficult To Implement?

The nesting of the Materialize date and time pickers inside the new/edit work session modals presented a number of issues to the development process. The way that Materialize implements those particular components prevents them from expanding outside the boundaries of their container element. This caused the pickers to be partially cut off at the bottom initially, preventing full usage of the components. This limitation required direct CSS overrides to resolve which made the implementation of the date and time pickers take fare longer than expected.

## What Could Be Done Differently?

This application would greatly benefit from the use of an architectural framework such as ReactJS or Vue. The implementation of one of these frameworks would remove a lot of the complexity from the code, making it far easier to develop in the future. This would also resolve many visual bugs and glitches caused by poor handling of DOM updates.

## Incomplete Parts of the Specification

The final application completely satisfies the requirements outlined in the plan created in PROJ1. All major deliverables are completely functional and displayed in the application as specified in the plan. The only differences lie in small features such as search bars and missing settings.

## Quality Assurance

Througout the lifecycle of this project, it has been incredibly important to regulary consult the inital plan outlined in PROJ1. This routine helps to ensure that the development does not stray from the inital goals of the project, and that final application resembles the concept as closely as possible. Feedback has also been regularly sought from peers to ensure that the application is as a presentable as possible, and that the user interface is smooth and easy to navigate.

## Persistence of the Prototype in the Final Application

The user interface of this application remains largely the same as the UI displayed in the prototype. With the only changes being minor things such as settings, search bars, and colour palette. The development of the prototype proved extremely useful as it removed the need for design deliberations throughout the implementation of the applications functionality. This greatly accelerated the development speed.

## Utilization of Object Oriented Programming

OOP has been used in the usage of the JS APIs that Materialize relies on. The Materialize library exposes the `M` object. This object is the interface that is used to interact with all of the libraries components, and programmatically control them. OOP has also been used when dealing with the data returned from the API. All data recieved from the API is structured as objects such as the `Employee` and `WorkSession` objects, whose structural definitions can be found within the APIs source code.
