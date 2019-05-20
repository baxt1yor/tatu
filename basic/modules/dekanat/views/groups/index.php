<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\GroupsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="groups-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Groups'), ['create'], ['class' => 'w3-btn w3-green']) ?>
    </p>
    <?php Pjax::begin(); ?> <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',

            [
                'attribute' => 'group_head_id',
                'value' => function ($model) {
                    return $model->groupHead->fio;
                    },
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Teacher::find()->asArray()->all(), 'id', 'fio'),
            ],
            [
                'attribute' => 'direction_id',
                'value' => function ($model) {
                    return $model->direction->name;
                },
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Direction::find()->asArray()->all(), 'id', 'name'),
            ],

            'course',
            // 'faculty_id',

            [
                'header' => 'Amallar',
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="w3-btn w3-green">Ko\'rish</span>', $url, [
                            'title' => Yii::t('yii', 'Create'),
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="w3-btn w3-teal">Yangilash</span>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="w3-btn w3-red"><i class="glyphicon glyphicon-trash"></i></span>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
                'options' => [
                    'style' => 'width: 250px',
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
