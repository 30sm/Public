<?php

namespace common\models;

use common\models\query\MenuMainQuery;
use omgdef\multilingual\MultilingualBehavior;
use Yii;
use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "menu".
 * 
 * @property integer      $id
 * @property string       $slug
 * @property integer|null $parent_id
 * @property string|null  $url
 * @property integer|null $order
 * @property integer      $type_id
 * @property string|null  $img_base_url
 * @property string|null  $img_path
 * @property integer      $subscription
 * @property integer      $status
 * 
 * @property Menu[] $menus
 * @property Menu $parent
 * @property MenuMainLang[] $menumainLangs
 */
class MenuMain extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 2;
    const STATUS_DRAFT = 1;
    const MAIN_MENU = 0;
    const CABINETS_MENU = 1;
    const WITHOUT_SUBSCRIPTION = 0;
    const WITH_SUBSCRIPTION = 1;


    /**
     * @var array
     */
    public $img;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_main';
    }

    /**
     * @inheritdoc
    */
    
    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['availableLocales'],
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'menu_id',
                'tableName' => "{{%menu_main_lang}}",
                'attributes' => [
                    'title',
                    'img_text',
                ]
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'img',
                'pathAttribute' => 'img_path',
                'baseUrlAttribute' => 'img_base_url',
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title_en',
                'immutable' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['slug'], 'unique'],
            [['parent_id', 'status', 'order', 'type_id', 'subscription'], 'integer'],
            ['status', 'default', 'value' => 1],
            [['url', 'slug', 'img_base_url', 'img_path'], 'string', 'max' => 1024],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuMain::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['title'], 'string', 'max' => 512],
            [['img_text'], 'string'],
            ['img', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'ЧПУ'),
            'parent_id' => Yii::t('common', 'ID родительского элемента'),
            'url' => Yii::t('common','URL'),
            'order' => Yii::t('common', 'Порядковый номер'),
            'type_id' => Yii::t('common', 'Тип меню'),
            'img' => Yii::t('common', 'Піктограма'),
            'img_base_url' => Yii::t('common', 'URL сховища'),
            'img_path' => Yii::t('common', 'Шлях до піктограми'),
            'subscription' => Yii::t('common', 'Для подписчиков'),
            'status' => Yii::t('common', 'Статус')
        ];
    }


    /**
     * Gets query for [[MenuMainLangs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenuMainLangs()
    {
        return $this->hasMany(MenuMainLang::className(), ['menu_id' => 'id']);
    }

    /**
     * @return array statuses list
     */
    public static function statuses()
    {
        return [
            self::STATUS_DRAFT => Yii::t('common', 'Не активный'),
            self::STATUS_PUBLISHED => Yii::t('common', 'Активный'),
        ];
    }

    /**
     * @return array typeMenu list
     */
    public static function typeMenu()
    {
        return [
            self::MAIN_MENU => Yii::t('backend', 'Main menu'),
            self::CABINETS_MENU => Yii::t('common', 'Cabinets menu'),
        ];
    }

    /**
     * @return array subscriptionMenu list
     */
    public static function subscriptionMenu()
    {
        return [
            self::WITHOUT_SUBSCRIPTION => Yii::t('common', 'Without subscription'),
            self::WITH_SUBSCRIPTION => Yii::t('common', 'With subscription'),
        ];
    }

    public static function find()
    {
        return new MenuMainQuery(get_called_class());
    }

    /**
     * Gets query for [[Menus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(MenuMain::className(), ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuMain::className(), ['id' => 'parent_id']);
    }

    /**
     * @return Menu[]
     */
    public function getChildren()
    {
        return self::find()->where(['parent_id' => $this->id])->active()->orderBy('order')->all();
    }

    public function beforeSave($insert)
    {
        if(!$this->id){
            $this->order = MenuMain::find()->max('id') + 1;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * if return true - access is closed
     * @return true | false
     */
    public function accessToRubric()
    {
        if ($this->subscription == MenuMain::WITHOUT_SUBSCRIPTION) return true;
        elseif ($this->subscription == MenuMain::WITH_SUBSCRIPTION) {
            if($access = LkSubscrible::checkSubscrible()) {
                return $access;
            }
        }
        return false;
    }
}
