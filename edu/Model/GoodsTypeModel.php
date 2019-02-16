<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model GoodsTypeModel
 *
 * @property int $id
 * @property string $text
 * @property int $parent_id
 * @property int $category_id
 * @property int $level
 * @property int $locked
 * @property string $attributes
 * @property string $process_module
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsTypeModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsTypeModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsTypeModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsTypeModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsTypeModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsTypeModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsTypeModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsTypeModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsTypeModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsTypeModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class GoodsTypeModel extends BaseModel
{
    protected $table = 'goods_type';


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

        if(isset($data['category_id'])){
            $query->where('category_id',$data['category_id']);
        }

        if(isset($data['parent_id'])){
            $query->where('parent_id',$data['parent_id']);
        }

        if(isset($data['locked'])){
            $query->where('locked',$data['locked']);
        }

    }


    /** 保存数据检查 */
    public function verification($data){
        if( isset($data['parent_id']) && isset($data['id'])
            && $data['parent_id'] >0
            && $data['parent_id'] == $data['id']){

            return '父级不能是自身';
        }
    }
}