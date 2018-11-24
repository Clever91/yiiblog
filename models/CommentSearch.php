<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comments;

/**
 * CommentSearch represents the model behind the search form of `app\models\Comments`.
 */
class CommentSearch extends Comments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'article_id'], 'integer'],
            // [['id'], 'integer'],
            // [['user_id', 'article_id'], 'string'],
            [['text', 'status', 'created'], 'safe'],
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
        $query = Comments::find();

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
            // 'user_id' => $this->user_id,
            // 'article_id' => $this->article_id,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
            // ->andFilterWhere(['like', 'status', $this->status])
            // ->andFilterWhere(['like', 'article_id', $this->article->title])
            ->andFilterWhere(['like', 'user_id', $this->user->name]);

        return $dataProvider;
    }
}