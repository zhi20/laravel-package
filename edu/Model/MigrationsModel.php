<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model MigrationsModel
 *
 * @property int $id
 * @property string $migration
 * @property int $batch
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\MigrationsModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\MigrationsModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\MigrationsModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\MigrationsModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\MigrationsModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\MigrationsModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\MigrationsModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\MigrationsModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\MigrationsModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\MigrationsModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class MigrationsModel extends BaseModel
{
    protected $table = 'migrations';


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