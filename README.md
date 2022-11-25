# Pet Hero
This is our Final Project for the Programming Technician career at the UTN of Mar del Plata!
This project is for two different subjects: Programming Laboratory 4 (Laboratorio de Programación 4) and System Methodology (Metodología de Sistemas).

## What's it about?
Pet Hero is a Web app that lets pet owners book reservations with Keepers so that they can take care of their little fur friends. Users can register as Keepers and specify which kind of pet they can care for!

This app is developed in PHP (using a custom framework), and MySQL (with PHPMyAdmin) for data storing.

## How to run Pet Hero
1. We need a Server to run this app on. We can use WAMP, downloading it from here: https://www.wampserver.com/en/download-wampserver-64bits/. Click the X64 version and then on the "you can download it directly" link. Install.
2. Clone this Repo inside the "www" folder, inside WAMP install directory (Normally C:\wamp64)
3. Go to this address in any internet browser: localhost/PhpMyAdmin
4. Go to "Databases" tab, under "Create Database"enter "pethero", choose "tf8_spanish2_ci" and then click Create.
5. Click on new "pethero" database (sidebar to the left), then go to "Import" tab
6. Select Schema.sql (Inside Schema folder in cloned repo) as the file to import. Click on "Continue". Database is now created!
7. Now go to this address: localhost/PetHero

And you are now running the app!

## User Stories
- User can create an account, and then log into app.
- User can add a pet, by entering it's information and uploading pictures and gif files.
- User can view their pets' information in a table format.
- User can become a Keeper, by entering additional information and setting a Start and End date, and choosing which weekdays they would like to work on.
- User can search through all Keepers by setting one or more dates, and choosing a particular pet to be cared for.
- If any keeper is available, owner can book a reservation with them. Keeper availability is decided by:
  • Dates. All chosen dates must correspond to the ones set by a Keeper
  • Active reservations. Keepers can only care for a particular pet species on a same date (eg. if Keeper has a reservation for a dog, won't be available to care for a cat during those days)
- User can book a reservation with any available Keeper.
- User can view all reservations in a table format (Keepers can also view reservations booked with them by other users)
- User can cancel created reservations before confirmed or rejected by Keeper. This deletes reservation from database.
- Keeper can confirm a reservation, setting it as active
- Keeper can reject a reservation, setting it as inactive. This frees those dates for other owners.
