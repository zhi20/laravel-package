<?php
namespace App\Model;

use App\Model\Base\BaseModel;


/**
 * Model GoodsSearchModel
 *
 * @property int $id
 * @property string $goods_name
 * @property int $goods_id
 * @property int $type
 * @property int $locked
 * @property int $orderby
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsSearchModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsSearchModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsSearchModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsSearchModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsSearchModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsSearchModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsSearchModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsSearchModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsSearchModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsSearchModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class GoodsSearchModel extends BaseModel
{
    protected $table = 'goods_search';

    const TYPE_HOT = 1;
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

    public function filter($params){
        $query = $this->getQueryModel();
        if(isset($params['type'])){
            $query->where('type',$params['type']);
        }
        if(isset($params['locked'])){
            $query->where('locked',$params['locked']);
        }
        if(isset($params['orderby'])){
            $query->orderBy('orderby', $params['orderby']);
        }

    }
}