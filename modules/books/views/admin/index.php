<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\helpers\Image;
use yii\widgets\Pjax;
use app\modules\books\assets\FancyboxAsset;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\books\models\BooksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerAssetBundle(FancyboxAsset::className());
$this->registerJs('$(".preview_pic").fancybox();');
$this->registerJs('$(".ajax_table").fancybox({type: \'ajax\'});');
$this->title = Yii::t('app', 'Книги');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,

        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            [
                'attribute' => 'preview',
                'format' => 'html',
                'value' => function ($data) {
                    return Html::a(Html::img(Image::thumb($data['preview'], 100)),$data['preview'],['class' => 'preview_pic']);
                },
            ],

            [
                'attribute' => 'author_id',
                'format' => 'html',
                'label' => 'Автор',
                'value' => function ($data) {
                    return $data['author']['firstname'] . ' ' . $data['author']['lastname'];
                }
            ],

            //'date',
            [
                'attribute' => 'date',
                'format' => ['date', 'php:d F Y']
            ],

            'date_create:relativeTime',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}{delete}',

                'buttons' => [
                    'format' => 'raw',
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => 'Редактировать',
                            'class' => 'ajax_table fancybox.ajax',
                        ]);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => 'Просмотр', 'class' => 'ajax_table fancybox.ajax'
                        ]);
                    },

                ],

            ]
        ],
    ]); ?>


    <p>
        <?= Html::a(Yii::t('app', 'Добавить книгу'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>

