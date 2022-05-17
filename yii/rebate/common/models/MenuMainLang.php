<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu_lang".
 *
 * @property int $id
 * @property int|null $menu_id
 * @property string $language
 * @property string $title
 * @property string $annotation
 *
 * @property MenuMain $menu
 */
class MenuMainLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_main_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_id'], 'integer'],
            [['image_text'], 'string'],
            [['language'], 'string', 'max' => 64],
            [['title'], 'string', 'max' => 512],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuMain::className(), 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'menu_id' => Yii::t('app', 'Main menu ID'),
            'language' => Yii::t('app', 'Language'),
            'title' => Yii::t('app', 'Заголовок'),
            'image_text' => Yii::t('app', 'Текст на картинке'),
        ];
    }

    /**
     * Gets query for [[MenuMain]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenuMain()
    {
        return $this->hasOne(MenuMain::className(), ['id' => 'menu_id']);
    }
}
