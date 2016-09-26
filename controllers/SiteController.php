<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Film;

class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($year = NULL)
    {
        $films = [];
        if (isset($year)) {
            $query = Film::find();
            $films = $query->andFilterCompare('year', $year)->orderBy('id')->all();
            if (empty($films)) {
                $films = Yii::$app->parser->parsePage($year);
            }
        }
        return $this->render('index', ['films' => $films, 'year' => intval($year)]);
    }

}
