<?php

namespace cache\provider;

/**
 * Class DataProvider
 * @package src\Integration
 */
class DataProvider implements DataProviderInterface
{
    /**
     * @var string hostName
     */
    private $host;
    /**
     * @var string
     */
    private $user;
    /**
     * @var string
     */
    private $password;

    /**
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct($host, $user, $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param array $request
     * @return array|false
     */
    public function get(array $request) {
        // тут надо описать какойто запрос, например получение html страницы
        return ['data' => $request];
    }
}