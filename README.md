
This repository was created to showcase some code produced by me for the Leaseweb challenge. For this challenge the following was assumed:

- The provided excel can be converted/saved into a CSV to easier import
- Frontend where the server list is displayed will not need auth
- API is for demonstrative purposes and will not have an auth system
- Reserved area will have only the upload file function

## Setup

A server with a webserver, PHP 8.0+, MySQL/MariaDB, composer, nodeJS/npm is required.

- do a git clone https://github.com/hgferreira/leaseweb-challenge.git to the desired folder
- rename the .env-example to .env (mv .env-example .env)
- edit the .env file and fill the database credentials
- run "php artisan key:generate"
- run "php artisan migrate"
- run "composer update"
- run "npm install" and if requested the instalation of additional modules, please install them
- run "npm run dev" 

## Initial usage

To be able to use the backend you need to create a user, for that you have on the frontpage the
*login* and *registration* links.

The file to upload must be a CSV separated by ; (semi-colon) and whithout headers.

After the CSV is uploaded you'll have on the frontend a search/filter box with all the corresponding results.

A new upload will truncate the file and reimport all the records.

