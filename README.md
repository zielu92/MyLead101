# MyLead101
#start 
1. copy .env.example ```cp .env.example .env```
2. edit .env 
```shell
composer install
npm i
npm run dev
```
3. seed 
```shell
php artisan db:seed --class=ProductsSeeder
```
4. run
```shell
php artisan serve
```
##Endpoints
PostMan collection location:
```PostMan_collection/MyLead101.postman_collection.json```

##Other
Simple vue app to play around :)

##Tests
PASS  Tests\Feature\ProductTest

✓ get products

✓ get products with parameters

✓ show product

✓ add product

✓ update product

✓ delete product

Tests:  9 passed
Time:   0.50s
