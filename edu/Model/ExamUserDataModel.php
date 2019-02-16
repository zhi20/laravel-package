<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;

/**
 * Model ExamUserDataModel
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $name
 * @property string $id_card
 * @property string $certified_front
 * @property string $certified_back
 * @property string $created_at
 * @property string $updated_at
 * @property int $locked
 * @property int $check
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamUserDataModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamUserDataModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamUserDataModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamUserDataModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamUserDataModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamUserDataModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamUserDataModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamUserDataModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamUserDataModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamUserDataModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class ExamUserDataModel extends BaseModel
{
    protected $table = 'exam_user_data';


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