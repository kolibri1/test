<?php

namespace app\modules\books\models;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
/**
 * This is the model class for table "{{%books}}".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $name
 * @property string $date_create
 * @property string $date_update
 * @property string $date
 * @property string $preview
 *
 * @property Authors $author
 */
class Books extends \yii\db\ActiveRecord
{

    private $dateFabr;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%books}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'name', 'date'], 'required'],
            [['author_id', 'date_create', 'date_update', 'date'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::className(), 'targetAttribute' => ['author_id' => 'id']],
            ['date_fabr', 'date', 'format' => 'php:d/m/Y'],

        ];
    }

    public function getDate_fabr() {
        return $this->date ? date('d/m/Y', $this->date) : null;
    }

    public function setDate_fabr($date_fabr) {
        $date = \DateTime::createFromFormat('d/m/Y H:i:s', $date_fabr.' 00:00:00');
        $this->dateFabr = $date_fabr ? $date->getTimestamp() : null;
        $this->date = $this->dateFabr;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'author_id' => Yii::t('app', 'Автор'),
            'name' => Yii::t('app', 'Название'),
            'date_create' => Yii::t('app', 'Дата добавления'),
            'date_update' => Yii::t('app', 'Дата изменения'),
            'date_fabr' => Yii::t('app', 'Дата выхода книги'),
            'date' => Yii::t('app', 'Дата выхода книги'),
            'preview' => Yii::t('app', 'Превью'),

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Authors::className(), ['id' => 'author_id']);
    }

    public function afterDelete() {
        parent::afterDelete();
        if($this->preview){
            @unlink(Yii::getAlias('@webroot').$this->preview);
        }
    }


}
