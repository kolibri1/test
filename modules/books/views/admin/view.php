<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\Image;
/* @var $this yii\web\View */
/* @var $model app\modules\books\models\Books */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(!Yii::$app->request->isAjax): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif;?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'author_id',
                'format' => 'html',
                'label' => 'Автор',
                'value' => $model->author->firstname . ' ' . $model->author->lastname,

            ],
            'name',
            [
                'attribute' => 'date',
                'format' => ['date', 'php:d F Y']
            ],

            'date_create:relativeTime',
            [
                'attribute' => 'preview',
                'format' => 'html',
                'value' =>  Html::img(Image::thumb($model->preview, 240)),
            ],
        ],
    ]) ?>

</div>
