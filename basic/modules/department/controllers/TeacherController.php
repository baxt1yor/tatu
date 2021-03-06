<?php

namespace app\modules\department\controllers;

use app\helpers\ScheduleHelper;
use app\helpers\StudentNumberHelper;
use app\models\CurrentTerm;
use app\models\Subject;
use app\models\User;
use Yii;
use app\models\Teacher;
use app\models\search\TeacherSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeacherController implements the CRUD actions for Teacher model.
 */
class TeacherController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Teacher models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeacherSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Teacher model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Teacher model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Teacher();
        $user = new User();

        if ($model->load(Yii::$app->request->post())) {
            $user->load(Yii::$app->request->post());
            $user->created_at = time();
            $user->setPassword($user->password_hash);
            $user->updated_at = time();
            $user->role = User::ROLE_TEACHER;
            if ($user->save()) {
                $model->user_id = $user->id;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'user' => $user
            ]);
        }
    }

    /**
     * Updates an existing Teacher model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = $user = ($model->user) ? $model->user : new User();
        if ($model->load(Yii::$app->request->post())) {
            $user->load(Yii::$app->request->post());
            if ($user->save()) {
                $model->user_id = $user->id;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * Deletes an existing Teacher model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Teacher model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Teacher the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionYuklama($id)
    {


        $model1 = Teacher::find()->all();
        $current_term = CurrentTerm::findOne(['id' => 1]);
        $numberStudent =StudentNumberHelper::getStudentNumberByGroup();

        $model = Subject::find()->where(
            ['semester_id' => $current_term, 'lecturer_id' => $id] ||
            ['semester_id' => $current_term, 'practice_id' => $id] ||
            ['semester_id' => $current_term, 'lab1_id' => $id] ||
            ['semester_id' => $current_term, 'lab2_id' => $id]
        )->all();
        return $this->render('yuklama', ['model' => $model1,'numberstudent'=>$numberStudent]

        );
    }


    protected function findModel($id)
    {
        if (($model = Teacher::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
