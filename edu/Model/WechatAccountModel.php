<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model WechatAccountModel
 *
 * @property int $id
 * @property string $text
 * @property string $token
 * @property string $app_id
 * @property string $app_secret
 * @property string $machine_id
 * @property string $pay_key
 * @property int $crypted
 * @property string $encoding_aes_key
 * @property int $locked
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatAccountModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatAccountModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatAccountModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatAccountModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatAccountModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatAccountModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatAccountModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatAccountModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatAccountModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatAccountModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class WechatAccountModel extends BaseModel
{
    protected $table = 'wechat_account';

    const SDJY = 1;             //公众号配置id


    /**
     * 获取对应数据库链接对象
     * @eg 用于分库分表时获取数据所在的数据库对象
     * @param $id
     * @return object
     */
    /*public static function getShardingConnection($id)
    {
        $mod = $id % 4;
        $model = '\App\Model\Mysql2\User_'.$mod.'Model';

        return new $model;
    }*/

    /**
     * 获取配置信息
     * @param int $index
     * @return array
     */
    function getWechatConfig($index = 0){
        if(empty($index)){
            return $this->get()->keyBy($this->getKeyName())->toArray();
        }else{
            return $this->find($index)->toArray();
        }
    }

}