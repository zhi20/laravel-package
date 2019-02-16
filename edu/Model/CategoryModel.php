<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model CategoryModel
 *
 * @property int $id
 * @property string $text
 * @property string $code
 * @property int $parent_id
 * @property int $level
 * @property int $locked
 * @property string $process_module
 * @property string $attributes
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\CategoryModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\CategoryModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\CategoryModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\CategoryModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\CategoryModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\CategoryModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\CategoryModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\CategoryModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\CategoryModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\CategoryModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class CategoryModel extends BaseModel
{
    protected $table = 'category';


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



    /** 保存数据检查 */
    public function verification($data){
        if( isset($data['parent_id']) && isset($data['id'])
            && $data['parent_id'] >0
            && $data['parent_id'] == $data['id']){
            return '父级不能是自身';
        }
    }
}