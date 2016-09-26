<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "film".
 *
 * @property integer $id
 * @property integer $year
 * @property string $title
 * @property string $url
 * @property double $rating
 * @property integer $externalId
 */
class Film extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'title', 'url'], 'required'],
            [['year', 'externalId'], 'integer'],
            [['rating'], 'number'],
            [['title'], 'string', 'max' => 200],
            [['url'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'year' => Yii::t('app', 'Year'),
            'title' => Yii::t('app', 'Movie title'),
            'url' => Yii::t('app', 'URL'),
            'rating' => Yii::t('app', 'Rating'),
            'externalId' => Yii::t('app', 'External ID'),
        ];
    }
}
