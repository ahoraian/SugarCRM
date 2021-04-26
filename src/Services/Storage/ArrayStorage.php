<?php declare(strict_types=1);

namespace App\Services\Storage;

class ArrayStorage implements StorageInterface
{
    /**
     * @var array
     */
    private array $list = [];

    /**
     * @inheritDoc
     */
    public function get(string $key): string|array|null
    {
        return $this->has($key) ? $this->list[$key] : null;
    }

    /**
     * @inheritDoc
     */
    public function put(string $key, string|array $value): void
    {
        $this->list[$key] = $value;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->list);
    }

    /**
     * @inheritDoc
     */
    public function remove(string $key)
    {
        if ($this->has($key)) {
            unset($this->list[$key]);
        }
    }
}