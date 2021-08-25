<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Client;

/**
 * ClientSearch represents the model behind the search form of `app\models\Client`.
 */
class ClientSearch extends Client
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['fname', 'lname', 'mname', 'birthdate', 'sex', 'doc_seria', 'doc_number', 'inn', 'add1', 'type', 'create_date', 'change_date'], 'safe'],
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
        $query = Client::find();

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
            'birthdate' => $this->birthdate,
            'user_id' => $this->user_id,
            'create_date' => $this->create_date,
            'change_date' => $this->change_date,
        ]);

        $query->andFilterWhere(['like', 'fname', $this->fname])
            ->andFilterWhere(['like', 'lname', $this->lname])
            ->andFilterWhere(['like', 'mname', $this->mname])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'doc_seria', $this->doc_seria])
            ->andFilterWhere(['like', 'doc_number', $this->doc_number])
            ->andFilterWhere(['like', 'inn', $this->inn])
            ->andFilterWhere(['like', 'add1', $this->add1])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
