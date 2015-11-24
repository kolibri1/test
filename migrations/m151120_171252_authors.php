<?php
use yii\db\Schema;
use yii\db\Migration;

class m151120_171252_authors extends Migration
{
    public function up()
    {
        $this->createTable('{{%authors}}', [
            'id'                     => Schema::TYPE_PK,
            'firstname'              => Schema::TYPE_STRING . '(255) NOT NULL',
            'lastname'               => Schema::TYPE_STRING . '(255) NOT NULL',

        ], 'ENGINE=innodb DEFAULT CHARSET=utf8');
        $this->insert('{{%authors}}', ['firstname'=>'Дин', 'lastname'=>'Кунц']);
        $this->insert('{{%authors}}', ['firstname'=>'Герберд', 'lastname'=>'Шилдт']);
    }

    public function down()
    {
        $this->dropTable('{{%authors}}');
    }

}
