<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\books\Module;
use app\modules\books\models\Authors;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\helpers\Image;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\books\models\Books */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="books-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
    ]); ?>

    <?= $form->errorSummary([$model, $fileModel]); ?>

    <?= $form->field($model, 'author_id')->dropDownList(ArrayHelper::map(Authors::getAllAuthors(), 'id', 'name'), [
            'prompt'    => Yii::t('app', 'Выберите автора'),
    ]);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_fabr')->widget(DatePicker::className(), [
        'language' => 'ru',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy',
        ],
        'options' => [
            'placeholder' => '12/31/2014'
        ]
    ]);?>

    <?php if($model->preview) : ?>
        <img src="<?= Image::thumb($model->preview, 240) ?>">
        <a href="<?= Url::to(['/books/admin/clear-image', 'id' => $model->primaryKey]) ?>" class="text-danger confirm-delete" title="<?= Yii::t('app', 'Clear image')?>"><?= Yii::t('app', 'Clear image')?></a>
    <?php endif; ?>
    <?= $form->field($fileModel, 'uploadFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Добавить') : Yii::t('app', 'Сохранить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
