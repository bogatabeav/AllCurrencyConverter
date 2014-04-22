All Currency Converter Users Guide
============================================
 
To Install 
---------------------
**Adding Your Files Onto the Server**

1. Begin by adding all files and folders to the public_html folder of your server.

2. Set permissions of all files as 755.

3. Set the permissions of cron/rateUpdate.php and Connections/config.php to 644.

**Creating Your Database**

1. Open the SQL.sql file in a text editor.

2. Replace the text in single quotation marks on line 20 to a database name of your choosing:

 ```-- Database: `enter database name here````
 
3. Copy all of the text from the SQL.sql file.

4. Open your MySQL editor (like phpMyAdmin) and open the SQL tab.

5. Paste the contents of the SQL.sql file into the textarea and press GO.

6. Your database has now been created.

**Configuring Your Connection**

1. Open config.php in a text editor.

2. Replace the text in single quotation marks on line 8 to the previously chosen database name.

 ```$db = "xxx";```
 
3. Replace the text in single quotation marks on line 9 to the username used to access your database.

 ```$user = "xxx";```
 
4. Replace the text in single quotation marks on line 10 to the username used to access your database.

 ```$pass = "xxx";```
 
5. Save the config.php file

6. Open the cron/rateUpdate.php file.

7. Repeat steps 2 - 4 for lines 14 - 16.

8. Save the cron/rateUpdate.php file.

9. Your site is now ready! 


Usage Instructions
---------------------
**Currency Converter**

1. Open your browser and enter the url of your host site, for a demo, go to http://www.allcurrencyconverter.info

2. You're automatically taken to the Currency Converter page; otherwise, choose the Exchange link in the navigation bar.

3. Enter the amount of original currency you would like to be converted.

4. Select the original currency from the first dropdown menu.

5. Select the new currency that you would like to convert to from the second dropdown menu.

6. Click the Submit button.

7. The converted amount will be displayed beneath the Submit button.

**Currency Timeline**

1. Open your browser and enter the url of your host site, for a demo, go to http://www.allcurrencyconverter.info

2. Click the Timeline link in the navigation bar.

3. Select the currency you want to view from the dropdown menu.

4. Select the radio button for the time period your would like to view for that currency. 

*Note: for mobile, choose the time period from the second dropdown.*

5. Click the Submit button.

6. The timeline chart will be displayed below the Submit button. 
