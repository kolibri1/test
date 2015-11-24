<?php

namespace app\modules\books;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\books\controllers';

    public $defaultRoute = 'admin';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/books/*'] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'basePath'       => '@app/modules/books/messages',
            'fileMap'        => [
                'modules/books/mess' => 'mess.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/books/' . $category, $message, $params, $language);
    }
}
