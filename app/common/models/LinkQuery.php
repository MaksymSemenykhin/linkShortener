<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Link]].
 *
 * @see Link
 */
class LinkQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status'=>Link::$STATUS_ACTIVE]);
    }
    public function withTtl()
    {

        return $this->andWhere('ttl <> 0 ');
    }

    /**
     * {@inheritdoc}
     * @return Link[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Link|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
