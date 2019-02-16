<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model SpreadOrderModel
 *
 * @property int $id
 * @property string $table
 * @property int $table_id
 * @property int $user_id
 * @property string $order_sn
 * @property string $code
 * @property float $amount
 * @property int $locked
 * @property string $remark
 * @property string $created_at
 * @property string $updated_at
 * @property int $check
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadOrderModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadOrderModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadOrderModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadOrderModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadOrderModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadOrderModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadOrderModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadOrderModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadOrderModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadOrderModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class SpreadOrderModel extends BaseModel
{
    protected $table = 'spread_order';


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