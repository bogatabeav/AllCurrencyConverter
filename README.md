All Currency Converter Users Guide
============================================
 
To Install 
---------------------
** Adding Your Files Onto the Server **

1. Begin by adding all files and folders to the public_html folder of your server.

2. Set permissions of all files as 755.

3. Set the permissions of cron/rateUpdate.php and Connections/config.php to 644.

** Creating Your Database **

1. Open the SQL.sql file in a text editor.

2. Replace the text in single quotation marks on line 20 to a database name of your choosing:

 -- Database: \`enter database name here\`
 
3. Copy all of the text from the SQL.sql file.

4. Open your MySQL editor (like phpMyAdmin) and open the SQL tab.

5. Paste the contents of the SQL.sql file into the textarea and press GO.

6. Your database has now been created.

** Configuring Your Connection **

1. Open config.php in a text editor.

2. Replace the text in single quotation marks on line 8 to the previously chosen database name.

 $db = "xxx";
 
3. Replace the text in single quotation marks on line 9 to the username used to access your database.

 $user = "xxx";
 
4. Replace the text in single quotation marks on line 10 to the username used to access your database.

 $pass = "xxx";

Usage Instructions
---------------------
