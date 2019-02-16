<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model OrderGoodsModel
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property int $goods_id
 * @property int $category_id
 * @property int $goods_type_id
 * @property int $num
 * @property string $goods_name
 * @property string $goods_sn
 * @property float $price
 * @property float $real_price
 * @property string $remark
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderGoodsModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderGoodsModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderGoodsModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderGoodsModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderGoodsModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderGoodsModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderGoodsModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderGoodsModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderGoodsModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\OrderGoodsModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class OrderGoodsModel extends BaseModel
{
    protected $table = 'order_goods';


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