<?php

use yii\helpers\Html;
use yii\grid\GridView;
use batsg\helpers\HHtml;
use app\components\ConstantValue;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StampSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stamps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stamp-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Stamp', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'header' => 'Image',
                'format' => 'raw',
                'value' => function($data) {
                    return HHtml::imgThumbnail($data->imageUrl);
                },
                'filter' => FALSE,
            ],
            'file:ntext',
            'price',
            [
                'attribute' => 'price_setting',
                'value' => 'priceSettingStr',
                'filter' => ConstantValue::getListOptions('STAMP_PRICE_SETTING'),
            ],
            

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
