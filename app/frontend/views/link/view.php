<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \yii\helpers\Url;
use \common\models\Link;

/* @var $this yii\web\View */
/* @var $model common\models\Link */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="link-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'token' => $model->token], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'token' => $model->token], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description',
            [
                'attribute' => 'short link',
                'format' => 'raw',
                'value'=>function($model){
                    $url = Url::to(["q/$model->token"],\yii::$app->params['scheme']);
                    return Html::a($url, $url, ['target'=>'_blank', 'data-pjax'=>"0"]);
                }
            ],
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
            'link:url',
            [
                'attribute' => 'hits*',
                'value'=>function($model){
                    return $model->statistics?$model->statistics->count:0;
                }
            ],
            'hit_limit',
            'status',

        ],
    ]) ?>

</div>
