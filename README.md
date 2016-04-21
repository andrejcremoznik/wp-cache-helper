# WP Cache Helper

A wrapper class for WordPress caching functions.

### What is this?

WordPress provides some caching functions that make it needlessly hard to invalidate previously saved caches. The idea here is to version cache keys by appending a number. So instead of caching something with a key `mycache` it's cached as `mycacheN` where N is an integer we increment every time the cache needs to be invalidated (like in `save_post` hook).

## Installation

Copy the `src/WpCacheHelper.php` file to your project and require it `require_once('path/to/WpCacheHelper.php');`.

Or with composer: `composer require andrejcremoznik/wp-cache-helper`.

## Usage

```php
use \AndrejCremoznik\WpCacheHelper\WpCacheHelper as Cache;

function do_something_expensive() {
    $cache = new Cache('data_key');
    $expensive_data = $cache->get();

    if ($expensive_data === false) {
        $expensive_data = get_expensive_data();
        $cache->set($expensive_data);
    }

    return $expensive_data;
}

echo do_something_expensive();
```

### Invalidate cache on post save / delete

```php
function invalidate_cache() {
    Cache::flush()
}
add_action('save_post',    'invalidate_cache');
add_action('deleted_post', 'invalidate_cache');
```
