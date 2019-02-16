<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;

/**
 * Model ExamFavorableModel
 *
 * @property int $id
 * @property string $text
 * @property int $act_range
 * @property string $act_range_ext
 * @property int $user_range
 * @property int $limit_num
 * @property int $type
 * @property string $price
 * @property int $start_time
 * @property int $end_time
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property int $locked
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamFavorableModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamFavorableModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamFavorableModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamFavorableModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamFavorableModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamFavorableModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamFavorableModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamFavorableModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamFavorableModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamFavorableModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class ExamFavorableModel extends BaseModel
{
    protected $table = 'exam_favorable';


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