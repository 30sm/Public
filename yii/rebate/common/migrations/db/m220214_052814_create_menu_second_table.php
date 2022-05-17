<?php

use yii\db\Migration;

class m220214_052814_create_menu_second_table extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable('{{%menu_second}}', [
      'id' => $this->primaryKey(),
      'slug' => $this->string(64)->notNull(),
      'parent_id' => $this->integer(),
      'url' => $this->string(1024),
      'order' => $this->integer(),
      'status' => $this->smallInteger()->notNull()->defaultValue(0),
      'img_base_url' => $this->string(1024),
      'img_path' => $this->string(1024),
      'type_id' => $this->integer()->defaultValue(0),
      'subscription' => $this->smallInteger()->notNull()->defaultValue(0),
    ]);

    $this->createTable('{{%menu_second_lang}}', [
      'id' => $this->primaryKey(),
      'menu_id' => $this->integer(),
      'language' => $this->string(64)->notNull(),
      'title' => $this->string(512)->notNull(),
      'img_text' => $this->text(),
    ]);

    $this->createIndex(
      'idx-menu_second_lang-menu_id',
      '{{%menu_second_lang}}',
      'menu_id'
    );

    $this->createIndex(
      'idx-menu_second_lang-language',
      '{{%menu_second_lang}}',
      'language'
    );

    $this->addForeignKey(
      'fk_menu_second_parent',
      '{{%menu_second}}',
      'parent_id',
      '{{%menu_second}}',
      'id',
      'cascade',
      'cascade'
    );

    $this->addForeignKey(
      'fk_menu_second_lang',  // это "условное имя" ключа
      '{{%menu_second_lang}}', // это название текущей таблицы
      'menu_id', // это имя поля в текущей таблице, которое будет ключом
      '{{%menu_second}}', // это имя таблицы, с которой хотим связаться
      'id', // это поле таблицы, с которым хотим связаться
      'cascade',
      'cascade'
    );

  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropForeignKey('fk_menu_second_parent', '{{%menu_second}}');
    $this->dropForeignKey('fk_menu_second_lang', '{{%menu_second_lang}}');

    $this->dropTable('{{%menu_second}}');
    $this->dropTable('{{%menu_second_lang}}');
  }
}
