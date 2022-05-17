<?php

namespace backend\modules\content\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MenuMain;

class MenuMainSearch extends MenuMain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'status', 'order' ,'type_id', 'subscription'], 'integer'],
            [['title', 'url', 'slug'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MenuMain::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->title)) {
          $query->leftJoin('menu_main_lang','menu_main_lang.menu_id = menu_main.id');
          $query->andFilterWhere(['like', 'menu_main_lang.title',  '%'.$this->title . '%', false]);
      }

        $query->andFilterWhere([
            'id' => $this->id,
            'subscription' => $this->subscription,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
            'order' => $this->order,

        ]);

        $query->andFilterWhere(['type_id' => $this->type_id]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
