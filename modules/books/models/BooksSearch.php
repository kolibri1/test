<?php

namespace app\modules\books\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\books\models\Books;

/**
 * BooksSearch represents the model behind the search form about `app\modules\books\models\Books`.
 */
class BooksSearch extends Books
{

    //public $date_from;
    public $dateTo;
    private $dateFrom;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'date_create', 'date_update', 'date'], 'integer'],
            [['name', 'date_from', 'date_to'], 'safe'],
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

    public function getDate_from() {
        return $this->dateFrom ? date('d/m/Y', $this->dateFrom) : null;
    }

    public function setDate_from($date_from) {
        $date = \DateTime::createFromFormat('d/m/Y H:i:s', $date_from.' 00:00:00');
        $this->dateFrom = $date_from ? $date->getTimestamp() : null;
    }

    public function getDate_to() {
        return $this->dateTo ? date('d/m/Y', $this->dateTo) : null;
    }

    public function setDate_to($date_to) {
        $date = \DateTime::createFromFormat('d/m/Y H:i:s', $date_to.' 23:59:59');
        $this->dateTo = $date_to ? $date->getTimestamp() : null;
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
        $query = Books::find()->with('author');

        // add conditions that should always apply here
        //$this->date_from = '21321';
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'author_id' => [
                    'asc' => ['authors.firstname' => SORT_ASC, 'authors.lastname' => SORT_ASC],
                    'desc' => ['authors.firstname' => SORT_DESC, 'authors.lastname' => SORT_DESC],
                    'label' => 'Автор',
                    //tbl_authors.'value' => 'author.firstname',
                    'default' => SORT_ASC
                ],
                'date',
                'date_create',
                'name'
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['author']);
            return $dataProvider;
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,

        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        if(!empty($this->dateFrom)) $query->andFilterWhere(['>=', 'date', $this->dateFrom]);

        if(!empty($this->dateTo)) $query->andFilterWhere(['<=', 'date', $this->dateTo]);

        return $dataProvider;
    }
}
