<?php

namespace AndrejCremoznik\WpCacheHelper;

class WpCacheHelper {
    private $cache_key;
    private static $cache_ittr_key = 'cache_itteration';

    /**
     * Create new instance
     * @param string $cache_key Key to cache data as
     */
    public function __contruct($cache_key = false) {
        if (!$cache_key)
            throw new \Exception('No cache key provided.');

        $cache_itteration = $this->get_cache_itteration();
        $this->cache_key = $cache_key . $cache_itteration;
    }

    /**
     * Get cache itteration
     * @return int
     */
    private function get_cache_itteration() {
        $cache_ittr = wp_cache_get(self::cache_ittr_key);

        if ($cache_ittr === false) {
            wp_cache_set(self::cache_ittr_key, 1);
            $cache_ittr = 1;
        }

        return $cache_ittr;
    }

    /**
     * Get cache
     * @return saved cache or false
     */
    public function get() {
        return wp_cache_get($this->cache_key);
    }

    /**
     * Set cache
     * @param mixed $data Data to cache
     */
    public function set($data) {
        wp_cache_set($this->cache_key, $data);
    }

    /**
     * Flush cache by incrementing current cache itteration
     */
    public static function flush() {
        wp_cache_incr(self::cache_ittr_key);
    }
}
