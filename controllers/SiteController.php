<?php

namespace app\controllers;

use app\models\DishToIngredients;
use app\models\Ingredients;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $listIngredients = Ingredients::find()->where(['active' => '1'])->all();
        $dishes = [];
        if(Yii::$app->request->get('ingredients')) {
            $loadIds = Yii::$app->request->get('ingredients', '');
            $ids = $loadIds['ids'];
            if(count($ids) < 2) {
                Yii::$app->session->setFlash('warning', '“Выберите больше ингредиентов');
                return $this->redirectS();
            }
            $model = DishToIngredients::dishToIngs($ids);
            if($model == null) {
                Yii::$app->session->setFlash('danger', 'Ничего не найдено');
                return $this->redirectS();
            }
            $dishes = $this->arrayDishes($model, $ids);
        }

        return $this->render('index', [
            'listIngredients' => $listIngredients,
            'dishes' => $dishes
        ]);
    }

    /**
     *  Сформирование массива блюд с сортировкой ингредиентов по уменьшению
     * @param $model
     * @return array
     */
    private function arrayDishes($model, $ids)
    {
        $arrSearch = [];
        $exactSearch = [];
        foreach ($model as $itemDish) {
            $arr = [];
            $ingDishModel = Ingredients::find()->joinWith('dishToIngredients')->where(['id_dish' => $itemDish['id_dish']]);
            foreach ($ingDishModel->all() as $itemIng) {
                $arr[] = $itemIng->title; //in_array($itemIng->id, $ids);
            }
            $name = $itemDish['title']; //назвние блюдаЧ
            $arrSearch[$name] = $arr;
            if($itemDish['ingCount'] == $ingDishModel->count() && $ingDishModel->count() == count($ids)) {
                $exactSearch[$name] = $arr;
            }
        }
        return $exactSearch != null ? $exactSearch : $arrSearch;
    }

    /**
     * Reload
     * @return Response
     */
    private function redirectS()
    {
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
