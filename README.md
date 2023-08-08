# BDMS
## Blood Donation Management System

A full automated donation system management Using PHP-Laravel, HTML 5, CSS 3, Bootstrap 5,  JScript .
[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)
## Features
-	Secure User Data
-	Easy UI  
-	Automated Mailing System
-	Filtered Donor for each Blood Seeking request
-	Event Upload
-	Automated Profile Update
-	PDF wise reports

## Requirements 
1.	Local Server (Xampp, Laragon, Mampp , Wampp ,etc)
2.	PHP 8^
3.	Bootstrap 5
4.	SQL Server

## Git clone
At First you have to clone the git project , for that please go to project directory of your local server (example: C://Laragon/www/). Then open cdm or terminal then clone using (you have copy http from git projet).
```
git clone ‘project-http’
```
Then on cmd or terminal run
```
 cd  bdms/
 ```
Now cmd or terminal will run commands from project directory. Now project is successfully cloned. Now for making the project working you have to do particular tasks .
[![Awesome Badges](https://img.shields.io/badge/badges-awesome-green.svg)](https://github.com/Naereen/badges)

## Installation
First you have to Update the composer file , Run the code 
```
composer update
 ```
 After successfully updating composer, go to project directory from your file explorer. There have to a file named 
`‘.env.example’ simply rename to ‘.env ‘ `

#### Create a Database

Now you have to create a database . Start your local server and browse http://localhost/phpmyadmin
give your username and password. Now create a database with Utf-8 general_ci for language purpose.

#### Connect Project With Database

Now open your code editor 
Do this steps 
1.	Open .env file
2.	Find DB_DATABASE=bdms and replace the value with your database name;
3.	In DB_USERNAME= give your localhost/ username
4.	In DB_PASSWORD= give your localhost password if no password leave it blank

You have connected the project with your database.

#### Mailer Functionality


For using mailing function you have to provide gmail username and password for free access. You can also use other mailer options as well as.

#### Make Folder to store Images

Now again open cmd or terminal from project directory.

run the code to optimize settings
```
php artisan optimize
```
Then link the storage folder using command
```
php artisan storage:link
```

Now goto 
```
public->storage folder
```
Here you will create 3 folders 

1.	users
2.	events
3.	requests

>NB: all the letters have to in lower case.

Now goto 
```
public->storage->users folder
```
Here you will create 2 folders 
1.	nid
2.	profile

>NB: all the letters have to in lower case.


All these folders we will use for our file storage.
#### Build Database table or Run Migration
Now it’s time to migrate database. Run this code.
````
php artisan migrate
````

#### Import Super Admin 
Run this command to seed a SuperAdmin user

````
php artisan db:seed
````
>###### Superadmin Login Credentials 
> Email: superadmin@bdms.com
> Password: 12345678

#### Run the site
All is done! To run the website . Run this code
```
php artisan serve
```

Now paste the ip on any browser.

#### Key Generate
On the browser you will see the project asking to generate key. Click on it and refresh the key.

Boom! You’re all done. Enjoy 
[![GitHub license](https://img.shields.io/github/license/Naereen/StrapDown.js.svg)](https://github.com/Naereen/StrapDown.js/blob/master/LICENSE)


[![Success](https://freesvg.org/img/success-text.png) ]()

