<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StaticAge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'static:age';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'static age';

    protected $limit = 1000;
    protected $count = 0;
    protected $current = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info("start static user age");
        $this->count = \DB::table('shop_user_realname')
            ->whereRaw('char_length(idcard) > 17')
            ->count();
        if ($this->count == 0) {
            $this->info("user not found");
            return true;
        }

        $bar = $this->output->createProgressBar(100);
        $bar->setProgress(1);
        $this->info('');
        sleep(1);

        \DB::table('shop_user_realname as r')
            ->leftJoin('user as u', 'u.id', '=', 'r.user_id')
            ->select(['r.name', 'r.idcard', 'u.id', 'u.level_id'])
            ->whereRaw('char_length(r.idcard) > 17')
            ->orderBy('r.id')
            ->chunk($this->limit, function ($users) use ($bar){

                foreach ($users as $user) {
                    $this->current++;
                    $this->info($user->idcard);
                    //$this->idHandler($user);
                    $this->idHandlerRedis($user);
                }

                $this->info('');
                $bar->setProgress(intval($this->current / $this->count * 100));
                $this->info('');

            });

        $bar->finish();
        return true;
    }


    public function idHandlerRedis($user)
    {
        if (empty($user)) {
            return true;
        }

        if ($user->level_id == 0) {
            return true;
        }

        $year = substr($user->idcard, 6, 4);

        /*if (intval(substr($year, 0, 1)) != 1) {
            return false;
        }*/

        $year = intval($year);

        $sex = substr($user->idcard, 16, 1);
        if (!is_numeric($sex)) {
            return false;
        }

        if (intval($sex % 2) == 1) {
            $sex = [
                't_male' => 1,
                't_female' => 0
            ];
        } else {
            $sex = [
                't_male' => 0,
                't_female' => 1
            ];
        }

        $levels = [
            't_level_5' => 0,
            't_level_4' => 0,
            't_level_3' => 0,
            't_level_2' => 0,
            't_level_1' => 0
        ];

        $level = 't_level_' . $user->level_id;

        $levels[$level] = 1;


        $redis = app('redis')->connection('tmp');

        if ($redis->exists($year)) {
            $res = unserialize($redis->get($year));

            $info = array_merge(['t_num' => 1], $sex, $levels);
            foreach ($info as $key => $val) {
                if ($val == 1) {
                    $res[$key] = $res[$key] + 1;
                }
            }

            $redis->set($year, serialize($res));

        } else {
            $redis->set($year, serialize(array_merge(['t_num' => 1], $sex, $levels)));
        }

        return true;
    }


    public function idHandler($user)
    {
        if (empty($user)) {
            return true;
        }

        if ($user->level_id == 0) {
            return true;
        }

        $year = substr($user->idcard, 6, 4);

        /*if (intval(substr($year, 0, 1)) != 1) {
            return false;
        }*/

        $year = intval($year);

        $sex = substr($user->idcard, 16, 1);
        if (!is_numeric($sex)) {
            return false;
        }

        $sex = (intval($sex % 2) == 1) ? 't_male' : 't_female';

        $level = 't_level_' . $user->level_id;

        $res = \DB::table('tmp_age')
            ->where('t_year', '=', $year)
            ->get();

        if ($res->isNotEmpty()) {
            $sql = "update tmp_age set $sex = $sex + 1, t_num = t_num + 1, $level = $level + 1 where t_year = $year";
        } else {
            $sql = "insert into tmp_age (t_year, t_num, $sex, $level) value($year, 1, 1, 1)";
        }

        \DB::select($sql);

        return true;

    }

}
