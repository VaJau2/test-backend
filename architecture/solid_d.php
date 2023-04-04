<?php

/**
 * Устранить нарушения первого пункта принципа инверсии зависимостей
 * (D: Dependency Inversion Principle) SOLID:
 * « 1. Модули верхних уровней не должны зависеть от модулей нижних уровней.
 *      Оба типа модулей должны зависеть от абстракций. »
 */

interface HttpService
{
    public function request(string $url, string $method, array $options = []);
}

class XMLHttpService extends XMLHTTPRequestService implements HttpService
{
    public function request(string $url, string $method, array $options = []) {}
}

class Http
{
    private HttpService $service;

    public function __construct(HttpService $httpService)
    {
        $this->service = $httpService;
    }

    public function get(string $url, array $options)
    {
        $this->service->request($url, 'GET', $options);
    }

    public function post(string $url)
    {
        $this->service->request($url, 'GET');
    }
}