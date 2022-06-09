<?php

namespace app\modules\consultation\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\consultation\models\ConsultationDoriRecept;

/**
 * ConsultationDoriReceptSearch represents the model behind the search form of `app\modules\consultation\models\ConsultationDoriRecept`.
 */
class ConsultationDoriReceptSearch extends ConsultationDoriRecept
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reg_id', 'create_userid'], 'integer'],
            [['dori_title', 'dori_doza', 'dori_shakli', 'dori_mahali', 'dori_davomiyligi', 'dori_qabul', 'dori_qayvaqtda', 'create_date'], 'safe'],
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
        $query = ConsultationDoriRecept::find();

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
            'reg_id' => $this->reg_id,
            'create_date' => $this->create_date,
            'create_userid' => $this->create_userid,
        ]);

        $query->andFilterWhere(['like', 'dori_title', $this->dori_title])
            ->andFilterWhere(['like', 'dori_doza', $this->dori_doza])
            ->andFilterWhere(['like', 'dori_shakli', $this->dori_shakli])
            ->andFilterWhere(['like', 'dori_mahali', $this->dori_mahali])
            ->andFilterWhere(['like', 'dori_davomiyligi', $this->dori_davomiyligi])
            ->andFilterWhere(['like', 'dori_qabul', $this->dori_qabul])
            ->andFilterWhere(['like', 'dori_qayvaqtda', $this->dori_qayvaqtda]);

        return $dataProvider;
    }
}
