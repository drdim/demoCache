<?php

namespace cache\provider;

/**
 * Interface DataProviderInterface
 * @package cache\provider
 */
interface DataProviderInterface
{

    /**
     * @param array $request
     *
     * @return false|array
     */
    public function get(array $request);
}