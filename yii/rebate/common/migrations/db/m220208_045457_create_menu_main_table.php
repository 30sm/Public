<?php

use yii\db\Migration;

class m220208_045457_create_menu_main_table extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable('{{%menu_main}}', [
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

    $this->createTable('{{%menu_main_lang}}', [
      'id' => $this->primaryKey(),
      'menu_id' => $this->integer(),
      'language' => $this->string(64)->notNull(),
      'title' => $this->string(512)->notNull(),
      'img_text' => $this->text(),
    ]);

    $this->createIndex(
      'idx-menu_main_lang-menu_id',
      '{{%menu_main_lang}}',
      'menu_id'
    );

    $this->createIndex(
      'idx-menu_main_lang-language',
      '{{%menu_main_lang}}',
      'language'
    );

    $this->addForeignKey(
      'fk_menu_parent',
      '{{%menu_main}}',
      'parent_id',
      '{{%menu_main}}',
      'id',
      'cascade',
      'cascade'
    );

    $this->addForeignKey(
      'fk_menu_main_lang',  // это "условное имя" ключа
      '{{%menu_main_lang}}', // это название текущей таблицы
      'menu_id', // это имя поля в текущей таблице, которое будет ключом
      '{{%menu_main}}', // это имя таблицы, с которой хотим связаться
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
    $this->dropForeignKey('fk_menu_parent', '{{%menu_main}}');
    $this->dropForeignKey('fk_menu_main_lang', '{{%menu_main_lang}}');

    $this->dropTable('{{%menu_main}}');
    $this->dropTable('{{%menu_main_lang}}');
  }
}
