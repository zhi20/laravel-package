<?php
namespace App\Model;

use App\Model\Base\BaseModel;



/**
 * Model AttributeModel
 *
 * @property string $table
 * @property int $table_id
 * @property string $field
 * @property string $type
 * @property int $locked
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class AttributeModel extends BaseModel
{
    protected $table = 'attribute';


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
        if(isset($data['table'])){
            $query->where('table',$data['table']);
        }
        if(isset($data['table_id'])){
            $query->where('table_id',$data['table_id']);
        }
        if(isset($data['type'])){
            $query->where('type',$data['type']);
        }
        if(isset($data['field'])){
            $query->where('field',$data['field']);
        }
    }
}