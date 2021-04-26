<?php declare(strict_types=1);

namespace App\Services\Storage;

class StorageStorage implements StorageInterface
{
    /**
     * @inheritDoc
     */
    public function get(string $key): string|array|null
    {
        return $this->has($key) ? $_SESSION[$key] : null;
    }

    /**
     * @inheritDoc
     */
    public function put(string $key, string|array $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * @inheritDoc
     */
    public function remove(string $key)
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }
}