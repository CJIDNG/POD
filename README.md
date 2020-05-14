# Husk

an open source citizen-oriented solution for tracking government projects.

----------

# Getting started

## Installation


### JS

Install npm packages

	npm install

Compiler .vue files

	npm run dev
    
### Laravel

Please check the official Laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs)


Clone the repository

    git clone https://github.com/starfolksoftware/husk.git

Switch to the repo folder

    cd husk

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

add application key to .env file

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

Start the local development server

    php -S localhost:8000 -t public

You can now access the server at http://localhost:8000

## Database seeding

**Populate the database with seed data**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh


## Multi-Tenancy

**Husk uses `hyn/multi-tenant` laravel package**

To understand more how husk supports multi tenancy, read the [docs](https://tenancy.dev/docs/hyn/5.4)

To setup a new tenant(website)

    php artisan tenant:install {domain.com}

To add/remove a subapp to tenant(website)

    php artisan tenant:subapp {domain.com} {subapp} {--R|remove}


----------





# Documentation

Read about the API Documentation [here](https://github.com/starfolksoftware/husk/blob/develop/docs)

# Contributing

Sleeves folded, ready to dive in? Read [this](https://github.com/starfolksoftware/husk/blob/develop/docs/contributing.md)
