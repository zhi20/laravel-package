<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model WechatMenuModel
 *
 * @property int $id
 * @property int $account_id
 * @property string $text
 * @property int $pid
 * @property int $orderby
 * @property int $locked
 * @property string $action
 * @property string $action_param
 * @property string $created_at
 * @property string $updated_at
 * @property int $level
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatMenuModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatMenuModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatMenuModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatMenuModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatMenuModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatMenuModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatMenuModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatMenuModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatMenuModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatMenuModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class WechatMenuModel extends BaseModel
{
    protected $table = 'wechat_menu';


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

}