<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Link */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="link-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'ttl')->dropDownList([0, '10' => Yii::t('app', '10 minutes'), '30' => Yii::t('app', '30 minutes'), '60' => Yii::t('app', '60 minutes'), '600' => Yii::t('app', '10 hours'), '1440' => Yii::t('app', '24 hours'), ]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hit_limit')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'stopped' => 'Stopped','active' => 'Active'] ) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
