Symfony Cimpress test
========================

This is a test application built for Cimpress


Installation
--------------

To start off with this project

  * Update the parameters.yml with the database details;

  * Run the "php bin/console doctrine:database:create" command to create the database;

  * Now run "php bin/console doctrine:schema:update --force" to create the required table;

  * To import the symfony related repostiories from the github into local database run the "php bin/console app:github:import" command ;


Done, now you can use the application to filter with pagination!