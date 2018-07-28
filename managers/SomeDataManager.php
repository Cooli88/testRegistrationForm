<?php

namespace app\managers;


use app\caches\SomeDataCache;
use app\caches\SomeDataCacheInterface;
use app\models\SomeDataModel;

class SomeDataManager
{
    /** @var SomeDataCache */
    private $someDataCache;

    /**
     * SomeDataManager constructor.
     *
     * @param SomeDataCacheInterface $someDataCache
     */
    public function __construct(SomeDataCacheInterface $someDataCache)
    {
        $this->someDataCache = $someDataCache;
    }

    /**
     * @param      $date
     * @param      $type
     * @param      $userId
     * @param bool $force
     *
     * @return array
     */
    public function someFunction($date, $type, $userId, $force = false) {
        $result = $force ? null : $this->someDataCache->getDataByUserIdTypeDate($date, $type, $userId);
        if ($result === null){
            $result = $this->getSomeFunctionWithoutCache($date, $type, $userId);
            $this->someDataCache->setDataByUserIdTypeDate($date, $type, $userId, $result);
        }

        return $result;
    }

    /**
     * @param $date
     * @param $type
     * @param $userId
     *
     * @return array
     */
    private function getSomeFunctionWithoutCache($date, $type, $userId)
    {
        $dataList = SomeDataModel::find()->where(['date' => $date, 'type' => $type, 'user_id' => $userId])->all();
        $result = [];

        if (!empty($dataList)) {
            foreach ($dataList as $dataItem) {
                $result[$dataItem->id] = ['a' => $dataItem->a, 'b' => $dataItem->b];
            }
        }

        return $result;
    }

}