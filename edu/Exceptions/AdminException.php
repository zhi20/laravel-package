<?php
namespace App\Exceptions;


class AdminException extends \Exception
{
    protected $data = [];

    protected $url = [];

    protected $status = 200;

    /**
     * ApiException constructor.
     * @param string $message 错误信息
     * @param array $data
     * @param string $url
     * @param int $status 业务状态码
     */
    function __construct($message = '', $data = [], $url = '', $status = 200)
    {
        parent::__construct($message, 200);

        $this->data = $data;

        $this->status = $status;

        $this->url = $url;
    }

    /**
     * 获取错误id
     * @return string
     */
    public function getErrorId()
    {
        return empty($this->error_id) ? 'ERROR' : $this->error_id;
    }

    /**
     * Report the exception.
     *
     * @param  \Illuminate\Http\Request

     */
    public function render($request)
    {
        if ($request->ajax()) {
            return $this->result($request);
        } else {
            return view('Zhi20-package::exception', [
                'error_msg' => $this->getMessage(),
                'debug' => config('app.debug') == 'true' ?  [
                    'type' => get_class($this),
                    'line' => $this->getLine(),
                    'file' => $this->getFile(),
                    'trace' => explode("\n", $this->getTraceAsString())
                ] : ''
            ]);


        }
    }

    /**
     * 返回结果
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function result($request)
    {
        $http_code = $this->getCode();
        $data = [
            'code' => 0,
            'msg' => $this->getMessage(),
            'data' => $this->data,
            'url' => $this->url,
        ];
        return response()->json($data, $http_code, array(), JSON_UNESCAPED_UNICODE);
    }




}