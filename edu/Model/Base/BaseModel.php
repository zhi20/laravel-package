<?php
namespace App\Model\Base;


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
        $pageSize = isset($params['rows']) && $params['rows'] > 0 ? intval($params['rows']) : 0;
        $query = $this->getQueryModel();
        if(isset($params['sort'])){
            $query->orderBy(trim($params['sort']) ,trim($params['order']));
        }

        if(empty($pageSize)){
            $data = $query->get();
            if ($data) {
                $data = $data->toArray();
            }
            $total = count($data);
        }else{
            $result = $query->paginate($pageSize);
            $result = collect($result)->toArray();
            $total = $result['total'];
//            $data = json_decode(json_encode($result['data']), true);
            $data = $result['data'];
        }
//        formatTime($data);
        return [
            'total' => (int)$total,
            'rows' => (empty($data) ? [] : $data),
            'pagecount' => empty($pageSize) ? 1: ceil($total / $pageSize),
        ];
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

        if ($data) {
            $data = $data->toArray();
        }
//        formatTime($data);
        return $data;
    }

}