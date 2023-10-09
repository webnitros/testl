## Start

```shell
cp -f ./docker-compose.dev.yml ./docker-compose.yml
cp -f ./.env.example ./.env
make remake
php artisan key:generate
```

## Admin

```
Admin
http://127.0.0.1:8401/admin/login
user: admin@filament.example
password: admin

```

# Health Check Results

Контенер с worker выполнить restart для работы крон задач и очередей
После restart в Health Check Results очереди и крон задания должны быть в статусе OK

# Minio

Внимание s3 хранилище всегда использовать как дополнительный диск, иначе да же temp файл будет сохраняться в s3

```
http://127.0.0.1:8900/browser/local
user: sail
password: password
```

# Docs

[Filament](https://filamentphp.com/docs/3.x/panels/getting-started)
[Icons](https://blade-ui-kit.com/blade-icons?set=1)
