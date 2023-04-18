<?php

declare(strict_types=1);

namespace Cross\Commands\Config;

use Exception;

final class Config
{
    /**
     * Config instance.
     */
    private static ?Config $instance = null;

    /**
     * Config.
     *
     * @var array<string, mixed>
     */
    private array $config = [];

    /**
     * Constructor.
     */
    private function __construct()
    {
        //
    }

    /**
     * Clone.
     */
    private function __clone(): void
    {
        //
    }

    /**
     * Unserialize.
     *
     * @throws Exception
     */
    public function __unserialize(array $data): void
    {
        throw new Exception('Cannot unserialize (unserialize)');
    }

    /**
     * Returns an instance.
     */
    public static function getInstance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    /**
     * Defines a value.
     */
    public static function set(string $key, mixed $value): void
    {
        self::getInstance()->config[$key] = $value;
    }

    /**
     * Returns all config.
     *
     * @return array<string, mixed>
     */
    public static function all(): array
    {
        return self::getInstance()->config;
    }

    /**
     * Returns a value by a key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $config = self::all();

        if (array_key_exists($key, $config)) {
            return $config[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($config) && array_key_exists($segment, $config)) {
                $config = $config[$segment];
            } else {
                return $default;
            }
        }

        return $config;
    }

    /**
     * Resets all config.
     */
    public static function reset(): void
    {
        self::getInstance()->config = [];
    }
}
