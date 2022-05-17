<?php

namespace common\models;

use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use omgdef\multilingual\MultilingualBehavior;
use common\models\query\FaqQuery;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "faq".
 *
 * @property int $id
 * @property int|null $status
 * @property int|null $founding_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string $title
 * @property string $annotation
 *
 * @property FaqLang[] $faqLangs
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faq';
    }

    public static $status_arr =[
        1 => 'Не активный',
        2 => 'Активный',
    ];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            ['status', 'default', 'value' => 1],
            [['founding_date'], 'safe'],
            [['founding_date'], 'default', 'value' => function () {
                return date(DATE_ISO8601);
            }],
            [['founding_date'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['title'], 'required'],
            [['title'], 'string', 'max' => 512],
            [['annotation'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Статус'),
            'founding_date' => Yii::t('app', 'Дата основания'),
            'created_by' => Yii::t('app', 'Создал'),
            'updated_by' => Yii::t('app', 'Редактировал'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Отредактировано'),
        ];
    }

    /**
     * Gets query for [[FaqLangs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaqLangs()
    {
        return $this->hasMany(FaqLang::className(), ['faq_id' => 'id']);
    }

    public static function find()
    {
        return new FaqQuery(get_called_class());
    }
    public function afterFind(){

        parent::afterFind();

        $this->founding_date = date('d-m-Y', $this->founding_date);
    }

    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['availableLocales'],
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'faq_id',
                'tableName' => "{{%faq_lang}}",
                'attributes' => [
                    'title',
                    'annotation',
                ]
            ],
        ];
    }

}
