<?php

namespace SKprods\Telegram\Writers;

use Redis;
use SKprods\Telegram\Core\History\ChatInfo;
use SKprods\Telegram\Exceptions\ConfigurationException;

class RedisWriter implements WriterInterface
{
    private Redis $redis;

    /**
     * @throws ConfigurationException
     */
    public function __construct(string $connection)
    {
        $this->redis = app(Redis::class);

        $settings = config("database.redis.$connection");

        if (!$settings) {
            throw ConfigurationException::redisConnection($connection);
        }

        $password = ($settings['password'] !== '') ? $settings['password'] : null;

        $this->redis->connect($settings['host'], $settings['port']);
        $this->redis->auth($password);
        $this->redis->select($settings['database']);
    }

    public function getChatInfo(int $chatId): ChatInfo
    {
        $data = json_decode($this->redis->get($chatId), true);
        $data = $data ?? ['id' => $chatId];

        return ChatInfo::create($data, $this);
    }

    public function setChatInfo(ChatInfo $chatInfo)
    {
        $data = $chatInfo->toJson();
        $this->redis->set($chatInfo->id, $data);
    }
}