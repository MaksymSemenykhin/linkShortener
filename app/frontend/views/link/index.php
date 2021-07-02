<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \common\models\Link;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\LinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Links');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Link'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'attribute' => 'expire*',
                'value'=>function($model){
                    if(!$model->ttl || $model->status != Link::$STATUS_ACTIVE)
                        return '';
                    $dateInterval = new DateInterval('PT'.$model->ttl.'M');
                    $date = new DateTime();
                    $date->setTimestamp($model->updated_at);
                    $date->add($dateInterval);
                    return $date->format(TIMESTAMP_FORMAT);
                }
            ],
            [
                'attribute' => 'ttl*',
                'value'=>function($model){
                    return (int)$model->ttl.'m';
                }
            ],
            [
                'attribute' => 'hits*',
                'value'=>function($model){
                    return $model->statistics?$model->statistics->count:0;
                }
            ],
            'hit_limit',
            'link:url',
            'status',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{link} {view} {update} {delete}',
                'buttons' => [
                    'link' => function ($url) {
                        return $url;
                    },
                ],
                 'urlCreator' => function ($action, $model, $key, $index) {
                     switch ($action) {
                         case 'link':
                             $url = Url::to(["q/$model->token"],\yii::$app->params['scheme']);
                             return Html::a('<span class="glyphicon glyphicon-link"></span>', $url, ['target'=>'_blank', 'data-pjax'=>"0"]);
                         case 'view':
                             return Url::to(['link/view', 'token' => $model->token]);
                         case 'update':
                             return Url::to(['link/update', 'token' => $model->token]);
                         case 'delete':
                             return Url::to(['link/delete', 'token' => $model->token]);
                     }
                  },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
