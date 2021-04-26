<?php declare(strict_types=1);

namespace App\Services\Storage;

interface StorageInterface
{
    /**
     * @param string $key
     * @return array|string|null
     */
    public function get(string $key) : string|array|null;

    /**
     * @param string $key
     * @param array|string $value
     * @return void
     */
    public function put(string $key, string|array $value) : void;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key) : bool;

    /**
     * @param string $key
     */
    public function remove(string $key);
}