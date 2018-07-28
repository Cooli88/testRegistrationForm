<?php

namespace app\caches;


use yii\caching\MemCache;

class SomeDataCache implements SomeDataCacheInterface
{
    /**
     *  шаблон для создания ключа
     */
    const TEMPLATE_KEY_USERID_TYPE_DATE = 'some_data.%s.%s.%s';
    /** @var MemCache */
    private $memCache;

    /**
     * SomeDataCache constructor.
     *
     * @param MemCache $memCache
     */
    public function __construct(MemCache $memCache)
    {
        $this->memCache = $memCache;
    }

    /**
     * @param $date
     * @param $type
     * @param $userId
     *
     * @return array|null
     */
    public function getDataByUserIdTypeDate(string $date, string $type, int $userId)
    {
        $key = $this->createKeyByUserIdTypeDate($date, $type, $userId);
        $value = $this->memCache->get($key);
        return $value ?? null;
    }

    /**
     * @param string $date
     * @param string $type
     * @param int    $userId
     * @param array  $value
     */
    public function setDataByUserIdTypeDate(string $date, string $type, int $userId, array $value)
    {
        $key = $this->createKeyByUserIdTypeDate($date, $type, $userId);
        $result = $this->memCache->set($key, $value);
        if(!$result){
            \Yii::error(['message'=>'Не удалось записать данные в кеш', 'key'=>$key, 'value' => $value]);
        }
    }

    /**
     * @param string $date
     * @param string $type
     * @param int    $userId
     *
     * @return string
     */
    private function createKeyByUserIdTypeDate(string $date, string $type, int $userId): string
    {
        return sprintf(self::TEMPLATE_KEY_USERID_TYPE_DATE, $userId, $type, $date);
    }
}