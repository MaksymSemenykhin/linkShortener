<?php
namespace console\controllers;

use common\models\Link;
use yii\console\Controller;
use yii\console\Exception;

class LinkController extends Controller
{

    public function actionCheckExpired( )
    {

        foreach (Link::find()->active()->withTtl()->all() as $model) {

            $dateInterval = new \DateInterval('PT'.$model->ttl.'M');
            $date = new \DateTime();
            $curTime = $date->getTimestamp();
            $date->setTimestamp($model->updated_at);
            $date->add($dateInterval);
            $endTime = $date->getTimestamp();
            if($curTime>$endTime){
                $model->status = Link::$STATUS_EXPIRED;
                if(!$model->save())
                    throw new Exception(500, 'failed set link as expired');
            }

        }

    }

}