<?php

namespace frontend\controllers;

use common\models\Statistic;
use Yii;
use common\models\Link;
use frontend\models\LinkSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LinkController implements the CRUD actions for Link model.
 */
class LinkController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','delete','link'],
                'rules' => [
                    [
                        'actions' => ['index','create','update','delete','link'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],[
                        'actions' => ['link'],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionLink()
    {

        if (($model = Link::findOne(Yii::$app->request->queryParams)) == null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        if(
            $model->status != Link::$STATUS_ACTIVE ||
            $model->hit_limit && $model->statistics->count >= $model->hit_limit
        ){
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $model->statistics->count++;
        if(!$model->statistics->save())
            throw new \yii\web\HttpException(500, 'Internal error');

        $this->redirect($model->link);
    }


    /**
     * Lists all Link models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LinkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Link model.
     * @param string $token
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($token)
    {
        return $this->render('view', [
            'model' => $this->findModel($token),
        ]);
    }

    /**
     * Creates a new Link model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Link();
        $model->user_id = \yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $statistic = new Statistic();
            $statistic->link_id = $model->id;
            if(!$statistic->save()){
                Yii::$app->session->setFlash('error', 'There was an error saving new link');
                $model->deleteInternal();
                return $this->goBack();
            }
            return $this->redirect(['view', 'token' => $model->token]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Link model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $token
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($token)
    {
        $model = $this->findModel($token);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'token' => $model->token]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Link model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $token
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($token)
    {
        $this->findModel($token)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Link model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $token
     * @return Link the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($token)
    {

        if (($model = Link::findOne(['token'=>$token,])) !== null) {
            if (\yii::$app->user->id == $model->user_id)
                return $model;
            throw new NotFoundHttpException(Yii::t('app', 'The requested token does not exist'));;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
