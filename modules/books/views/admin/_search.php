<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use app\modules\books\models\Authors;
/* @var $this yii\web\View */
/* @var $model app\modules\books\models\BooksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="books-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-inline']
    ]); ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-8 form-group">
                    <?= $form->field($model, 'author_id', ['template' =>"{input}\n{hint}\n{error}"])->dropDownList(ArrayHelper::map(Authors::getAllAuthors(), 'id', 'name'), [
                        'prompt'    => Yii::t('app', 'Автор'),
                    ]);?>

                    <?= $form->field($model, 'name', ['template' =>"{input}\n{hint}\n{error}"])->textInput(['label' => 'jj', 'placeholder' => Yii::t('app', 'Название книги')]) ?>
                </div>
                <div class="col-xs-4 form-group"> </div>
                <div class="clearfix"></div>
                <div class="col-xs-8 form-group">
                <label class="col-sx-3 control-label">Дата выхода книги:</label>
                <?= $form->field($model, 'date_from', ['template' =>"{input}\n{hint}\n{error}"])->widget(DatePicker::className(), [
                    'language' => 'ru',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy',
                    ],
                    'options' => [
                        'placeholder' => '12/31/2014'
                    ]
                ]);?>
                    <label class="col-sx-1 control-label">до</label>
                <?= $form->field($model, 'date_to', ['template' =>"{input}\n{hint}\n{error}"])->widget(DatePicker::className(), [
                    'language' => 'ru',
                    //'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy'
                    ],
                    'options' => [
                        'placeholder' => '31/02/2015'
                    ]
                ]);?>

                </div>
                <div class="col-xs-4 form-group ">
                    <?= Html::submitButton(Yii::t('app', 'Искать'), ['class' => 'btn btn-primary pull-right']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div>
