<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;

/**
 * Model ExamPaymentInstructionsModel
 *
 * @property int $id
 * @property string $text
 * @property int $goods_id
 * @property int $goods_type_id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property int $locked
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamPaymentInstructionsModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamPaymentInstructionsModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamPaymentInstructionsModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamPaymentInstructionsModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamPaymentInstructionsModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamPaymentInstructionsModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamPaymentInstructionsModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamPaymentInstructionsModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamPaymentInstructionsModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ExamPaymentInstructionsModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class ExamPaymentInstructionsModel extends BaseModel
{
    protected $table = 'exam_payment_instructions';


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