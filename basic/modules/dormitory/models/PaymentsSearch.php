<?php

namespace app\modules\dormitory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dormitory\models\Payments;

/**
 * PaymentsSearch represents the model behind the search form about `app\modules\dormitory\models\Payments`.
 */
class PaymentsSearch extends Payments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_id'], 'integer'],
            [['month', 'year', 'payed'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Payments::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'student_id' => $this->student_id,
        ]);

        $query->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'payed', $this->payed]);

        return $dataProvider;
    }
}
