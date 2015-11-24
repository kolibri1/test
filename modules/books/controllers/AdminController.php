<?php

namespace app\modules\books\controllers;

use yii;
use yii\helpers\Url;
use app\modules\books\models\Books;
use app\modules\books\models\BooksSearch;
use app\modules\books\models\File;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\helpers\Image;

/**
 * AdminController implements the CRUD actions for Books model.
 */
class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'create', 'update', 'delete', 'index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view', 'create', 'update', 'delete', 'index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Books models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Url::remember();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Books model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Books();
        $fileModel = new File();

        if ($model->load(Yii::$app->request->post()))
        {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $model->validate($model);
            }

            if (!empty($_FILES)) {
                $fileModel->uploadFile = UploadedFile::getInstance($fileModel, 'uploadFile');

                if ($fileModel->uploadFile && $fileModel->validate(['uploadFile'])) {
                    $model->preview = Image::upload($fileModel->uploadFile);
                }
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'fileModel' => $fileModel
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'fileModel' => $fileModel
            ]);
        }

    }

    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $fileModel = new File();

        if ($model->load(Yii::$app->request->post()))
        {

            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $model->validate($model);
            }

            if (!empty($_FILES)) {
                $fileModel->uploadFile = UploadedFile::getInstance($fileModel, 'uploadFile');

                if ($fileModel->uploadFile && $fileModel->validate(['uploadFile'])) {
                    $model->preview = Image::upload($fileModel->uploadFile);
                }
            }

            if ($model->save()) {
                //return $this->redirect(['view', 'id' => $model->id]);
                return $this->goBack();
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'fileModel' => $fileModel
                ]);
            }
        } else {

            if(Yii::$app->request->isAjax){
                return $this->renderAjax('update', [
                    'model' => $model,
                    'fileModel' => $fileModel
                ]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'fileModel' => $fileModel
                ]);
            }


        }

    }

    /**
     * Deletes an existing Books model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionClearImage($id)
    {
        $model = $this->findModel($id);

        if($model === null){
            return false;
        }
        elseif($model->preview){

            @unlink(Yii::getAlias('@webroot').$model->preview);

            $model->preview = '';
            if($model->update()){
                \Yii::$app->session->setFlash('success', Yii::t('app', 'Image cleared'));
            } else {
                \Yii::$app->session->setFlash('error', Yii::t('app', 'Update error. {0}', $model->formatErrors()));
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Books::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
