<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;

/**
 * Model GoodsOrderAttributeModel
 *
 * @property int $id
 * @property int $goods_id
 * @property int $order_status
 * @property int $category_id
 * @property int $goods_type_id
 * @property string $field
 * @property string $type
 * @property int $locked
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsOrderAttributeModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsOrderAttributeModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsOrderAttributeModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsOrderAttributeModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsOrderAttributeModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsOrderAttributeModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsOrderAttributeModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsOrderAttributeModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsOrderAttributeModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsOrderAttributeModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class GoodsOrderAttributeModel extends BaseModel
{
    protected $table = 'goods_order_attribute';


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