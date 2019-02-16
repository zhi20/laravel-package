<?php
namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $queryModel ;

//    protected $guarded = [];

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }


    /** 设置过滤数据库没有的字段 */
    public function setValue($key, $value=""){

        if(empty($this->fillable)){
            $this->fillable = \Schema::getColumnListing($this->getTable());
        }
        if(is_array($key)){
            $result = array_intersect_key($key, array_flip($this->fillable));
            $this->fill($result);
        }else{
            if( in_array($key,$this->fillable) ){
                $this->$key = $value;
            }
        }
    }
    /** 实例化一个和model绑定的查询构建器 */
    public function getQueryModel($new = false){
        if($new || empty($this->queryModel)){
            $this->queryModel = $this->newQuery();
        }
        return $this->queryModel;
    }

    /**
     * 后台grid列表查询
     * @param array $params
     * @return array
     */
    public function grid($params = [])
    {
        $pageSize = intval(array_get($params, 'rows', '15'));
        $query = $this->getQueryModel();
        if(isset($params['sort'])){
            $query->orderBy(trim($params['sort']) ,trim(array_get($params, 'order', 'asc')));
        }
        if(empty($pageSize)){
            $result = $query->get();
        }else{
            $result = $query->paginate($pageSize);

        }
        return $result;
    }

    /**
     * 获取所有记录
     * @param array $where
     * @param array $field
     * @return BaseModel[]|array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getAll($where = [], $field = [])
    {
        $query = $this->getQueryModel();
        if (!empty($where)) {
            $query->where($where);
        }
        if (!empty($field)) {
            $query->addSelect($field);
        }
        $data = $query->get();
        return $data;
    }

}