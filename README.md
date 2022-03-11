# Laravel / Vue Contacts DB
Simple app for keeping track of contacts and their positions within companies.  
This project's purpose is for learning PHP / Laravel / Vue.  
![Screenshot of Laravel-Contacts](https://github.com/jwnukoski/laravel-contacts/blob/main/screenshot.png?raw=true "laravel-contacts-screenshot")  

# Running
- npm install  
- npm run watch  
- php artisan serve  
- The contacts_backup.dump can be used for example data.  

# Sail / Docker
- ./vendor/bin/sail up -d
- ./vendor/bin/sail artisan migrate:fresh --seed