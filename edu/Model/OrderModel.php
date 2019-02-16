<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model OrderModel
 *
 * @property int $id
 * @property string $order_sn
 * @property string $out_order_sn
 * @property int $user_id
 * @property int $provide_user_id
 * @property int $status
 * @property int $category_id
 * @property string $pay_code
 * @property int $pay_status
 * @property int $express_status
 * @property float $total_price
 * @property float $actual_price
 * @property float $express_price
 * @property float $coupon_price
 * @property int $coupon_id
 * @property string $coupon_table
 * @property string $remark
 * @property string $attributes
 * @property int $locked
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class OrderModel extends BaseModel
{
    protected $table = 'order';


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