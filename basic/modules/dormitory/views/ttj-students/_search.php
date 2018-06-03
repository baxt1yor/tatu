<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\dormitory\models\TtjStudentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ttj-students-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'term_id') ?>

    <?= $form->field($model, 'room_id') ?>

    <?= $form->field($model, 'section_id') ?>

    <?= $form->field($model, 'student_id') ?>

    <?php // echo $form->field($model, 'inside') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
