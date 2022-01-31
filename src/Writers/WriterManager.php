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
        parent::__construct($container);

        $this->chatInfoConfig = $this->config->get('telegram.chatInfo');
    }

    public function getDefaultDriver(): string
    {
        return self::FILE_DRIVER;
    }

    public function getDriverFromConfig(): WriterInterface
    {
        if (empty($this->chatInfoConfig)) {
            return $this->createFileDriver();
        }

        return match ($this->chatInfoConfig['driver']) {
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
        if (!isset($this->chatInfoConfig['connection'])) {
            throw ConfigurationException::emptyRedisConnectionName();
        }

        return app(RedisWriter::class, ['connection' => $this->chatInfoConfig['connection']]);
    }

    public function createCustomDriver(): WriterInterface
    {
        if (!isset($this->chatInfoConfig['handler'])) {
            throw ConfigurationException::emptyCustomHandler();
        }

        $handler = $this->chatInfoConfig['handler'];
        return app($handler);
    }
}