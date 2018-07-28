<?php

namespace app\caches;


interface SomeDataCacheInterface
{
    public function getDataByUserIdTypeDate(string $date, string $type, int $userId);
    public function setDataByUserIdTypeDate(string $date, string $type, int $userId, array $value);
}