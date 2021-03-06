<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\books\models\Books */

$this->title = Yii::t('app', 'Добавить книгу');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Книги'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'fileModel' => $fileModel
    ]) ?>

</div>
