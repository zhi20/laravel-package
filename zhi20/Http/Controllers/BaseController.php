<?php
namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use \App\Util\Traits\Controller as ResponseController;
use \App\Util\Traits\Validate;

class BaseController extends Controller
{
    use ResponseController, Validate;
    //
    protected $responseObj ;

    protected $isTree = false;

    protected $logicName = '';

    protected $isJson = false;

    //
    public function  __construct()
    {
        if(empty($this->logicName)){
            $class = str_replace("App\\Http\\Controllers\\", "", get_class($this) );

            $this->logicName = str_replace_last('Controller', '', $class);
        }
        load_helper('Common');
    }


    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->verify([
            'all' => 'no_required'
        ],'GET');
        if(empty($this->verifyData['all'])){
            $list = logic($this->logicName)->lists();
        }else{
            $list = logic($this->logicName)->select();
        }

        return $this->responseList($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!logic($this->logicName)->save()){
            throw new ApiException(logic($this->logicName)->getError('Error'));
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->verifyId($id);
        logic($this->logicName)->setData('id', $id);
        $data = logic($this->logicName)->info();

        return $this->response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->verifyId($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->verifyId($id);
        logic($this->logicName)->setData('id', $id);
        if(!logic($this->logicName)->save()){
            throw new ApiException(logic($this->logicName)->getError('Error'));
        }
        //添加操作日志
        //

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->verifyId($id);

        logic($this->logicName)->setData('id', $id);
        if(!logic($this->logicName)->delete()){
            throw new ApiException(logic($this->logicName)->getError('Error'));
        }

        //添加操作日志
//        \App\Logic\Admin\SystemLogLogic::addSystemLog('delete '.$this->logicName.',id:' . $id);

        return $this->response();
    }
}