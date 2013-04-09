gophp
=====

coding bat like site for php.  

#### Install

Should be fairly easy. Just plop it in a web directory, change settings in config file, run the mysql.

Why do I have 2 databases? Well, the thought was to have one database for the administrative and system. The other database is what the app actually uses for sample problem data to go into. I don't think I'm using all the tables in the app_db.

To make a user an admin, you have to manually change roletype to 2 in db.

