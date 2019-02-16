<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model ModuleModel
 *
 * @property int $id
 * @property string $text
 * @property int $category_id
 * @property string $module
 * @property string $class
 * @property string $action
 * @property int $locked
 * @property string $attributes
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ModuleModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ModuleModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ModuleModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ModuleModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ModuleModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ModuleModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ModuleModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ModuleModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ModuleModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ModuleModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class ModuleModel extends BaseModel
{
    protected $table = 'module';

    const PROCESS_FIELD_IS_USER = 'is_user';        //分类购买流程控制字段 - 是否需要用户操作；
    const PROCESS_FIELD_MODULE = 'module';          //分类购买流程控制字段 - 操作模块 category\class@action；
    const PROCESS_FIELD_KEY = 'key';                //分类购买流程控制字段 - 操作顺序索引 index

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