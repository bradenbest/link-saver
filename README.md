# Link Saver by Braden Best

The Link Saver is a project I made to replace bookmarks and provide a clean UI instead. Cause in my opinion, browser bookmark systems suck.

## Version 4.1

This version adds php/MySQL database functionality to the app. Though it's a bit clunky, since it just stores a giant json string in one column. Which for some reason is exceedingly difficult to do withohut errors. In my opinion, storing a string in a database and being able to retreive and parse it, should be the most trivial of tasks, not requiring multiple levels of escaping.

## Setup

1. Create a database, and import Link_Saver.sql into it

2. Edit conntect.php with the information needed to access that database.

Note that if you're simulating a server using localhost, chances are the email verification step in the signup process will fail, and it will instead ask you for a captcha
