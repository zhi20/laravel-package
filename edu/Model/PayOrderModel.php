<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model PayOrderModel
 *
 * @property int $id
 * @property int $user_id
 * @property int $withdraw_id
 * @property string $order_sn
 * @property string $out_order_sn
 * @property string $table
 * @property int $table_id
 * @property float $amount
 * @property string $remark
 * @property int $complete_time
 * @property int $locked
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $check
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayOrderModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayOrderModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayOrderModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayOrderModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayOrderModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayOrderModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayOrderModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayOrderModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayOrderModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayOrderModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class PayOrderModel extends BaseModel
{
    protected $table = 'pay_order';


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