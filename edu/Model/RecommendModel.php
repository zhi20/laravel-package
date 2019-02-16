<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model RecommendModel
 *
 * @property int $id
 * @property string $text
 * @property int $locked
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\RecommendModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\RecommendModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\RecommendModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\RecommendModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\RecommendModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\RecommendModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\RecommendModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\RecommendModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\RecommendModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\RecommendModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class RecommendModel extends BaseModel
{
    protected $table = 'recommend';

    const CATEGORY_RECOMMEND = 1;

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