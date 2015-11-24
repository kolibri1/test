<?php
use yii\db\Schema;
use yii\db\Migration;

class m151120_171323_books extends Migration
{
    public function up()
    {

        $this->createTable('{{%books}}', [
            'id'                     => Schema::TYPE_PK,
            'author_id'              => Schema::TYPE_INTEGER . ' NOT NULL',
            'name'                   => Schema::TYPE_STRING . '(255) NOT NULL',
            'date_create'            => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'date_update'            => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'date'                   => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'preview'                => Schema::TYPE_STRING . '(255) NOT NULL',

        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('author_id', '{{%books}}', 'author_id');
        $this->createIndex('name', '{{%books}}', 'name');
        $this->createIndex('date_create', '{{%books}}', 'date_create');
        $this->createIndex('date', '{{%books}}', 'date');
        $this->addForeignKey('FK_BOOKS_AUTHOR_ID', '{{%books}}' , 'author_id', 'authors', 'id', 'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable('{{%books}}');
    }

}
