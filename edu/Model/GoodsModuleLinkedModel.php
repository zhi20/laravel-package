<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;

/**
 * Model GoodsModuleLinkedModel
 *
 * @property int $id
 * @property int $goods_id
 * @property int $goods_type_id
 * @property int $module_id
 * @property int $category_id
 * @property int $is_buy
 * @property int $locked
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModuleLinkedModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModuleLinkedModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModuleLinkedModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModuleLinkedModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModuleLinkedModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModuleLinkedModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModuleLinkedModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModuleLinkedModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModuleLinkedModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModuleLinkedModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class GoodsModuleLinkedModel extends BaseModel
{
    protected $table = 'goods_module_linked';


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

    public function filter($data){
        $query = $this->getQueryModel();
        //商品，商品类型，分类互斥
        if(isset($data['goods_id'])){
            $query->where('goods_id',$data['goods_id']);
        }
        else{
            $query->where('goods_id',0);
        }
        //商品，商品类型，分类互斥
        if(isset($data['goods_type_id'])){
            $query->where('goods_type_id',$data['goods_type_id']);
        }
        else{
            $query->where('goods_type_id',0);
        }
        //商品，商品类型，分类互斥
        if(isset($data['category_id'])){
            $query->where('category_id',$data['category_id']);
        }
        else{
            $query->where('category_id',0);
        }

        if(isset($data['module_id'])){
            $query->where('module_id',$data['module_id']);
        }

        if(isset($data['locked'])){
            $query->where('locked',$data['locked']);
        }
        if(isset($data['is_buy'])){
            $query->where('is_buy',$data['is_buy']);
        }
    }
}