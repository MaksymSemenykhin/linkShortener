<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use Yii;
use yii\behaviors\TokenBehavior;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property string $token
 * @property int|null $ttl
 * @property string $link
 * @property int|null $hit_limit
 * @property string|null $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Statistic[] $statistics
 */
class Link extends \yii\db\ActiveRecord
{
    public static $STATUS_ACTIVE = 'active';
    public static $STATUS_EXPIRED = 'expired';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token'],'default', 'value' => dechex(crc32(time().rand(1,9999)))],
            [['name', 'link','user_id','ttl'], 'required'],
            ['link','url'],
            [['hit_limit','ttl'],'default', 'value' => 0],
            [['hit_limit'],'integer', 'min' => 0,'max' => 255],
            [['status'], 'string'],
            [['name'], 'string', 'max' => 45],
            [['description', 'link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'token' => Yii::t('app', 'Token'),
            'ttl' => Yii::t('app', 'Ttl'),
            'link' => Yii::t('app', 'Link'),
            'hit_limit' => Yii::t('app', 'Hit Limit'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Statistics]].
     *
     * @return \yii\db\ActiveQuery|StatisticQuery
     */
    public function getStatistics()
    {
        return $this->hasOne(Statistic::className(), ['link_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return LinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LinkQuery(get_called_class());
    }
}
