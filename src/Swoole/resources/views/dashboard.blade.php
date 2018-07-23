<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
    <title>Swoole Dashboard</title>

    <style>
        .my-body {
            width: 100%;
            min-width: 900px;
        }

        .box {
            padding: 20px;
        }

        .my-table {
            margin: 20px;
        }
    </style>

</head>
<body>

<div class="my-body">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#gateway-div" aria-controls="home" role="tab" data-toggle="tab">Gateway</a>
        </li>
        <li role="presentation"><a href="#worker-div" aria-controls="worker-div" role="tab" data-toggle="tab">Worker</a>
        </li>
    </ul>


    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="gateway-div">
            @foreach ($data['gateway'] as $key => $gateway)
                <div class='box'>
                    <div class="panel panel-default table-responsive">
                        <div class="panel-heading">{{ $gateway['mac-name'] }}</div>
                        <div class="panel-body">

                            <p><label>gateway_id</label>: {{ $gateway['gateway_id'] }}</p>
                            <p><label>fd</label>: {{ $gateway['fd'] }}</p>
                            <p><label>最后一次ping时间</label>: {{ date('Y-m-d H:i:s',$gateway['last_ping_time']) }}</p>
                            <p><label>最后上报数据时间</label>: {{ date('Y-m-d H:i:s',$gateway['last_report_time']) }}</p>
                            <p><label>注册时间</label>: {{ date('Y-m-d H:i:s',$gateway['register_time']) }}</p>
                            <br>

                            <h5><strong>TCP服务信息:</strong></h5>
                            <div class="well well-sm">
                                <p><label>主机</label>: {{ $gateway['host'] }}</p>
                                <p><label>端口</label>: {{ $gateway['port'] }}</p>
                            </div>

                            <h5><strong>WebSocket服务信息:</strong></h5>
                            <div class="well well-sm">
                                <p><label>主机</label>: {{ $gateway['ws_host'] }}</p>
                                <p><label>端口</label>: {{ $gateway['ws_port'] }}</p>
                            </div>
                        </div>

                        <div class="my-table">
                            <h5>共有 {{ count($data['gateway_ws_client'][$key]['ws_client_data']) }} 个websocket用户连接:</h5>
                            <!-- Table -->
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>client_id</th>
                                    <th>client_ip</th>
                                    <th>client_port</th>
                                    <th>fd</th>
                                    <th>session_info</th>
                                    <th>链接时间</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($data['gateway_ws_client'][$key]['ws_client_data']) == 0)
                                    <tr>
                                        <th colspan="7" style="text-align: center;">暂无数据~</th>
                                    </tr>
                                @endif

                                @foreach ($data['gateway_ws_client'][$key]['ws_client_data'] as $index => $ws)
                                    <tr>
                                        <th>{{ $index+1 }}</th>
                                        <td>{{ $ws['client_id'] }}</td>
                                        <td>{{ $ws['client_ip'] }}</td>
                                        <td>{{ $ws['client_port'] }}</td>
                                        <td>{{ $ws['fd'] }}</td>
                                        <td>{{ json_encode($ws['session_info'],JSON_UNESCAPED_UNICODE) }}</td>
                                        <td>{{ date('Y-m-d H:i:s',$ws['connected_at']) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <div role="tabpanel" class="tab-pane" id="worker-div">
            @foreach ($data['worker'] as $worker)
                <div class='box'>
                    <div class="panel panel-default table-responsive">
                        <div class="panel-heading">{{ $worker['mac-name'] }}</div>
                        <div class="panel-body">
                            <p><label>主机</label>: {{ $worker['host'] }}</p>
                            <p><label>端口</label>: {{ $worker['port'] }}</p>
                            <p><label>fd</label>: {{ $worker['fd'] }}</p>
                            <p><label>最后一次ping时间</label>: {{ date('Y-m-d H:i:s',$worker['last_ping_time']) }}</p>
                            <p><label>最后上报数据时间</label>: {{ date('Y-m-d H:i:s',$worker['last_report_time']) }}</p>
                            <p><label>注册时间</label>: {{ date('Y-m-d H:i:s',$worker['register_time']) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
</div>

</body>
</html>
