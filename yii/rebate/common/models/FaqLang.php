<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faq_lang".
 *
 * @property int $id
 * @property int|null $faq_id
 * @property string $language
 * @property string $title
 * @property string $annotation
 *
 * @property Faq $faq
 */
class FaqLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faq_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['faq_id'], 'integer'],
            [['annotation'], 'string'],
            [['language'], 'string', 'max' => 64],
            [['title'], 'string', 'max' => 512],
            [['faq_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faq::className(), 'targetAttribute' => ['faq_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'faq_id' => Yii::t('app', 'FAQ ID'),
            'language' => Yii::t('app', 'Language'),
            'title' => Yii::t('app', 'Вопрос'),
            'annotation' => Yii::t('app', 'Ответ'),
        ];
    }

    /**
     * Gets query for [[Faq]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaq()
    {
        return $this->hasOne(Faq::className(), ['id' => 'faq_id']);
    }
}
