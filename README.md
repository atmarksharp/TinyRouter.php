## TinyRouter

Very simple router. This router responses just php files.

### API

- basePath() : set basepath
- response() : response php files

### Download

```
cd /path/to/your/web/root

curl -s https://raw.github.com/atmarksharp/TinyRouter.php/master/install.sh | sh
```

This code downloads files below.

- tinyrouter.php
- .htaccess

### Usage

```php
$rt = new TinyRouter('/path/to/your/web/root');

$rt->response('GET','/user/(\d+?)/','user.php?id=\\1');
$rt->response('GET|PUT','/user/(\d+?)/profile/','user_profile.php?id=\\1');
```