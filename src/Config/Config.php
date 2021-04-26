<?php declare(strict_types=1);

namespace App\Config;

class Config implements ConfigInterface
{
    /**
     * Config constructor.
     * @param array $configs
     */
    public function __construct(private array $configs = [])
    {
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key): mixed
    {
        return $this->configs[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function put(string $key, mixed $value): void
    {
        $this->configs[$key] = $value;
    }
}