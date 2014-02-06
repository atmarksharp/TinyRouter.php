## TinyRouter

Very simple router.

### API

- basePath()
- response()

### Download

```
curl https://raw.github.com/atmarksharp/TinyRouter/master/tiny-router.php > tiny-router.php
```

### Usage

```php
$rt = new TinyRouter('/path/to/your/web/root');

$rt->response('GET','/user/(\d+?)/','user.php?id=\\1');
$rt->response('GET|PUT','/user/(\d+?)/profile/','user_profile.php?id=\\1');
```