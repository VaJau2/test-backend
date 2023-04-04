<?php

/**
 * Имеется метод getUserData, который получает данные из внешнего API,
 * передавая в запрос необходимые парамерты, вместе с ключом (token) идентификации.
 * Необходимо реализовать универсальное решение getSecretKey(),
 * с использованием какого-либо шаблона (pattern) проектирования для хранения этого ключа
 * всевозможными способами
 */

interface KeyRepository
{
    public function getKey(): string;
}

class FileKeyRepository implements KeyRepository
{
    public function getKey(): string
    {
        return 'file key';
    }
}

class DbKeyRepository implements KeyRepository
{
    public function getKey(): string
    {
        return 'db key';
    }
}

class RedisKeyRepository implements KeyRepository
{
    public function getKey(): string
    {
        return 'redis key';
    }
}

class CloudKeyRepository implements KeyRepository
{
    public function getKey(): string
    {
        return 'cloud key';
    }
}

class KeyRepositoryFactory
{
    public static function getInstance(string $code): KeyRepository
    {
        return match ($code)
        {
            'file' => new FileKeyRepository(),
            'db' => new DbKeyRepository(),
            'redis' => new RedisKeyRepository(),
            'cloud' => new CloudKeyRepository(),
            default => throw new \InvalidArgumentException(),
        };
    }
}

class Concept
{
    private $client;
    private $keyRepository;

    public function __construct(KeyRepository $keyRepository)
    {
        $this->client = new \GuzzleHttp\Client();
        $this->keyRepository = $keyRepository;
    }

    public function getUserData()
    {
        $params = [
            'auth' => ['user', 'pass'],
            'token' => $this->getSecretKey()
        ];

        $request = new \Request('GET', 'https://api.method', $params);
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            $result = $response->getBody();
        });

        $promise->wait();
    }

    private function getSecretKey(): string
    {
        return $this->keyRepository->getKey();
    }
}


$keyRepository = KeyRepositoryFactory::getInstance('file');
$concept = new Concept($keyRepository);
$concept->getUserData();
