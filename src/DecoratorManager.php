<?php
namespace cache\provider;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

/**
 * Class DecoratorManager
 * @package src\Decorator
 */
class DecoratorManager extends DataProvider
{
    /**
     * @var CacheItemPoolInterface
     */
    public $cache;
    /**
     * @var LoggerInterface
     */
    public $logger;

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct($host, $user, $password, CacheItemPoolInterface $cache, LoggerInterface $logger)
    {
        parent::__construct($host, $user, $password);
        $this->setCache($cache);
        $this->setLogger($logger);
    }

    /**
     * Не понял, как к этому логгеру
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     *
     * @param CacheItemPoolInterface $cache
     */
    public function setCache(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(array $input)
    {
        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            $result = $this->get($input);

            // кешируем только не пустой ответ
            if (!empty($result)) {
                $cacheItem
                    ->set($result)
                    ->expiresAt(
                        (new DateTime())->modify('+1 day')
                    );
            }
            return $result;
        } catch (Exception $e) {
            $this->logger->critical('Error');
        }

        return [];
    }

    /**
     * @param array $input
     * @return false|string
     */
    public function getCacheKey(array $input)
    {
        // Используем хеш
        return sha1(serialize($input));
    }
}