<?php

namespace backend\modules\content\controllers;

use common\traits\FormAjaxValidationTrait;
use Yii;
use common\models\MenuMain;
use backend\modules\content\models\search\MenuMainSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MenuMainController extends Controller
{
    use FormAjaxValidationTrait;

    private const POSTS_PER_PAGE = 30;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @param int $menu type_id
     * @return mixed
     */
    public function actionIndex($menu = MenuMain::MAIN_MENU)
    {
        $searchModel = new MenuMainSearch();

        if(isset($_GET['MenuSearch'])){
            $_GET['MenuSearch'] += ['type_id'=>$menu];
        }
        if(empty($_GET['MenuSearch'])){
            $_GET['MenuSearch'] = ['type_id'=>$menu];
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->sort = [
            'defaultOrder' => [
                'order' => SORT_ASC,
            ],
        ];
        $dataProvider->pagination = [
            'pageSize' => self::POSTS_PER_PAGE
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'menu' => $menu
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($menu = MenuMain::MAIN_MENU)
    {
        $model = new MenuMain();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return !$menu ? $this->redirect(['index']) : $this->redirect(['index', 'menu' => 1]);
        }
        $parents = ArrayHelper::map(!$menu ? MenuMain::find()->mainMenu()->active()->all() : MenuMain::find()->cabinetMenu()->active()->all(), 'id', 'title');

        return $this->render('create', [
            'parents' =>$parents,
            'languages' => Yii::$app->params['availableLocales'],
            'model' => $model,
            'menu_type' => $menu
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return !$model->type_id ? $this->redirect(['index']) : $this->redirect(['index', 'menu' => 1]);
        }
        $parents = ArrayHelper::map( !$model->type_id ? MenuMain::find()->mainMenu()->active()->all() : MenuMain::find()->cabinetMenu()->active()->all(), 'id', 'title');
        return $this->render('update', [
            'parents' =>$parents,
            'languages' => Yii::$app->params['availableLocales'],
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = MenuMain::find()->multilingual()->where(['id' => $id])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * sorting order of menu items
     */
    public function actionOrders()
    {
        $orders = [];
        $rows = Yii::$app->request->post('keys');

        $rows = $rows['rows'];
        foreach ($rows as $item) {
            $orders[] = $item['orders'];
        }
        asort($orders);
        $i = 0;
        $new_orders = [];
        foreach ($orders as $order) {
            $new_orders[$i] = $order;
            $i++;
        }
        foreach ($rows as $key => $row) {
            $rows[$key]['orders'] = $new_orders[$key];
        }
        foreach ($rows as $row) {
            $model = $this->findModel($row['id']);
            $model->order = $row['orders'];
            $model->save();
        }
    }
}
