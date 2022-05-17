<?php

use yii\db\Migration;

class m220207_035123_create_faq_table extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
      $this->createTable('{{%faq}}', [
          'id' => $this->primaryKey(),
          'founding_date' => $this->integer(),
          'status' => $this->integer(),
          'created_by' => $this->integer(),
          'updated_by' => $this->integer(),
          'created_at' => $this->integer(),
          'updated_at' => $this->integer(),
      ]);

      $this->createTable('{{%faq_lang}}', [
          'id' => $this->primaryKey(),
          'faq_id' => $this->integer(),
          'language' => $this->string(64)->notNull(),
          'title' => $this->string(512)->notNull(),
          'annotation' => $this->text(),
      ]);

      $this->createIndex(
          'idx-faq_lang-faq_id',
          '{{%faq_lang}}',
          'faq_id'
      );

      $this->createIndex(
          'idx-faq_lang-language',
          '{{%faq_lang}}',
          'language'
      );
  
      $this->addForeignKey(
        'fk_faq_lang',  // это "условное имя" ключа
        '{{%faq_lang}}', // это название текущей таблицы
        'faq_id', // это имя поля в текущей таблице, которое будет ключом
        '{{%faq}}', // это имя таблицы, с которой хотим связаться
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
      $this->dropForeignKey('fk_faq_lang', '{{%faq_lang}}');

      $this->dropTable('{{%faq}}');
      $this->dropTable('{{%faq_lang}}');
  }
}
