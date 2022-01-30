<?php

namespace SKprods\Telegram\Writers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Manager;
use SKprods\Telegram\Exceptions\ConfigurationException;

class WriterManager extends Manager
{
    public const FILE_DRIVER = 'file';
    public const REDIS_DRIVER = 'redis';
    public const CUSTOM_DRIVER = 'custom';

    private array $chatInfoConfig;

    public function __construct(Container $container)
    {
        $this->chatInfoConfig = config('telegram.chatInfo');

        parent::__construct($container);
    }

    public function getDefaultDriver(): string
    {
        return self::FILE_DRIVER;
    }

    public function getDriverFromConfig(): WriterInterface
    {
        if (empty($this->config)) {
            return $this->createFileDriver();
        }

        return match ($this->config['driver']) {
            self::FILE_DRIVER => $this->createFileDriver(),
            self::REDIS_DRIVER => $this->createRedisDriver(),
            self::CUSTOM_DRIVER => $this->createCustomDriver(),
            default => $this->createFileDriver(),
        };
    }

    public function createFileDriver(): FileWriter
    {
        return app(FileWriter::class);
    }

    /**
     * @throws ConfigurationException
     */
    public function createRedisDriver(): RedisWriter
    {
        if (!isset($this->config['connection'])) {
            throw ConfigurationException::emptyRedisConnectionName();
        }

        return app(RedisWriter::class, ['connection' => $this->config['connection']]);
    }

    public function createCustomDriver(): WriterInterface
    {
        if (!isset($this->config['handler'])) {
            throw ConfigurationException::emptyCustomHandler();
        }

        $handler = $this->config['handler'];
        return app($handler);
    }
}