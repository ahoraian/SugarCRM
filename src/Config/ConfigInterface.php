<?php declare(strict_types=1);

namespace App\Config;

interface ConfigInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function get(string $key) : mixed;

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function put(string $key, mixed $value) : void;
}