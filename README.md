# Test assignment

# Project setup

* **Frontend** - run the following commands

    cd web

    yarn install
    
    #Note if you don't have yarn installed you can use npm instead and the command would be "npm install" but, I recommend using yarn though
    
    yarn run dev


* **Backend** - run the following commands

  #Make sure that you have Mysql installed and running
  
  cd api
  
  composer install
  
  #Then copy .env.example file into the same directory and rename it to .env
  
  #Set the database connection credentials in the .env then run the following commands
  
  php artisan migrate:fresh --seed
  
  php artisan key:generate
  
  php artisan serve
  
  #To run unit tests run one of the following command it depends on your installation
  
  phpunit
  
  #or
  
  vendor/bin/phpunit
