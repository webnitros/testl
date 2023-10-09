```shell
php artisan make:migration Files --table=files
php artisan make:migration LinkSlup --table=links
php artisan make:migration ImageBucketMarker --create=table_name
php artisan make:migration Categories --create=categories

```
php artisan migrate
# Создать seeds

```shell
php artisan make:seed SeedName
```


# Применения seeds

```shell
php artisan db:seed --class=PropertyReferencesTableSeeder
```
