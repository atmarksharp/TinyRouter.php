## TinyRouter

Very simple router.

### API

- basePath()
- response()

### Usage

```php
$rt = new TinyRouter('/path/to/your/root');

$rt->response('GET','/user/(\d+?)/','user.php?id=\\1');
$rt->response('GET|PUT','/user/(\d+?)/profile/','user_profile.php?id=\\1');
```