<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\books\models\Books */

$this->title = Yii::t('app', 'Редактирование {modelClass}: ', [
    'modelClass' => 'книги',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Книги'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактирование');
?>
<div class="books-update">

    <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
            'fileModel' => $fileModel
        ]) ?>

</div>
