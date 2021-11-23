# nankov.mk

Applications for personal website !!!


### API

API Powered by PHP Lumen for the Blog with Swagger Doc and JWT

***Note: For production ready config only .env and config/


For development we use https://laravel.com/docs/8.x/homestead
```
---
ip: "192.168.56.56"
memory: 2048
cpus: 2
provider: virtualbox

authorize: ~/.ssh/id_rsa.pub

keys:
    - ~/.ssh/id_rsa

folders:
    - map: /Users/nanorocks/Documents/other/github/blog-api/api
      to: /home/vagrant/code/blog-api/api

sites:
   - map: blog-api.repo
     to: /home/vagrant/code/blog-api/api/public

databases:
    - homestead

features:
    - mysql: true
    - mariadb: false
    - postgresql: false
    - ohmyzsh: false
    - webdriver: false

services:
    - enabled:
          - "mysql"
```

After creating the DB and move .env.example to .env you need to run: 

```
vagrant ssh
cd /home/vagrant/code/blog-api/api
php artisan migrate --seed
```

To regenarate the SWAGGER DOC you need to run `php artisan swagger-lume:generate`

You're done for the API. :)


- SPA ReactJS with Bootstrap 5 for Admin Panel.
- SPA ReactJS with HTML Template for display and render END data.


