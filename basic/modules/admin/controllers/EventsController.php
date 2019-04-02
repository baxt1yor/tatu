<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Events;
use app\modules\admin\models\EventsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventsController implements the CRUD actions for Events model.
 */
class EventsController extends Controller
{
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
     * Lists all Events models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Events model.
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
     * Creates a new Events model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddEvent()
    {
        $model = new Events();

        if ($model->load(Yii::$app->request->post()) || isset($_POST['Events'])) {
            $eventList = Events::find()->where(['LIKE', 'event_start_date', Yii::$app->dateformatter->getDateFormat($_POST['Events']['event_start_date'])])->andwhere(['is_status'=> 0])->count();
            if($eventList > 6) {
                Yii::$app->session->setFlash('maxEvent', "<b><i class='fa fa-warning'></i> Maximum Events Limit Reached, you can not add more event for this day</b>");
                return $this->redirect(['index']);
            }
            $model->attributes = $_POST['Events'];
            $model->event_start_date = Yii::$app->dateformatter->storeDateTimeFormat($_POST['Events']['event_start_date']);
            $model->event_end_date = Yii::$app->dateformatter->storeDateTimeFormat($_POST['Events']['event_end_date']);
            $model->created_by = Yii::$app->getid->getId();
            $model->created_at = new \yii\db\Expression('NOW()');


            if($model->save()) {
                if(isset($_GET['return_admin']))
                    return $this->redirect(['events/index']);
                else
                    return $this->redirect(['index']);
            }
            else {
                return $this->renderAjax('_form', ['model' => $model,]);
            }
        }
        else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }
    public function actionViewEvents($start=NULL,$end=NULL,$_=NULL) {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $eventList = Events::find()->where(['is_status'=> 0])->all();

        $events = [];

        foreach ($eventList as $event) {
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $event->event_id;
            $Event->title = $event->event_title;
            $Event->description = $event->event_detail;
            $Event->start = $event->event_start_date;
            $Event->end = $event->event_end_date;
            $Event->color = (($event->event_type == 1) ? '#00A65A' : (($event->event_type == 2) ? '#00C0EF' : (($event->event_type == 3) ? '#F39C12' : '#074979')));
            $Event->textColor = '#FFF';
            $Event->borderColor = '#000';
//            $Event->event_type = (($event->event_type == 1) ? 'Holiday' : (($event->event_type == 2) ? 'Important Notice' : (($event->event_type == 3) ? 'Meeting' : 'Messages')));
            $Event->allDay = ($event->event_all_day == 1) ? true : false;
            // $Event->url = $event->event_url;
            $events[] = $Event;
        }
        return $events;
    }
    public function actionUpdateEvent($event_id)
    {
        $model = $this->findModel($event_id);

        if ($model->load(Yii::$app->request->post()) || isset($_POST['Events'])) {

            $model->attributes = $_POST['Events'];
            $model->event_start_date = Yii::$app->dateformatter->storeDateTimeFormat($_POST['Events']['event_start_date']);
            $model->event_end_date = Yii::$app->dateformatter->storeDateTimeFormat($_POST['Events']['event_end_date']);
            $model->updated_by = Yii::$app->getid->getId();
            $model->updated_at = new \yii\db\Expression('NOW()');

            if($model->save()) {
                if(isset($_GET['return_dashboard']))
                    return $this->redirect(['events/index']);
                else
                    return $this->redirect(['index']);
            }
            else {
                return $this->renderAjax('_form', ['model' => $model,]);
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }
    public function actionEventDelete($e_id)
    {
        $model = Events::findOne($e_id);
        $model->is_status = 2;
        $model->updated_by = Yii::$app->getid->getId();
        $model->updated_at = new \yii\db\Expression('NOW()');
        $model->save();

        if(isset($_GET['return_dashboard']))
            return $this->redirect(['events/index']);
        else
            return $this->redirect(['index']);
    }

    /**
     * Updates an existing Events model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->event_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Events model.
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
     * Finds the Events model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Events the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Events::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
