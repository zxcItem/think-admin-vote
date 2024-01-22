<?php

namespace app\vote\controller;

use app\data\model\DataUserBind;
use app\vote\model\VoteProject;
use app\vote\model\VoteProjectComment;
use app\vote\model\VoteProjectPlayer;
use app\vote\model\VoteProjectRecord;
use think\admin\Controller;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 投票数据报表
 * Class Portal
 * @package app\data\controller\total
 */
class Portal extends Controller
{

    /**
     * 数据统计概况
     * @auth true
     * @menu true
     * @return void
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function index(){
        // 设置页面标题
        $this->title = '数据统计概况';
        $this->usersTotal = DataUserBind::mk()->where(['status'=>1,'deleted'=>0])->cache(true, 60)->count();
        $this->projectTotal = VoteProject::mk()->where(['status'=>1,'deleted'=>0])->cache(true, 60)->count();
        $this->recordTotal = VoteProjectRecord::mk()->where(['deleted'=>0])->cache(true, 60)->count();
        $this->playerTotal = VoteProjectPlayer::mk()->where(['is_check'=>1,'status'=>1,'deleted'=>0])->cache(true, 60)->count();
        $this->hours = $this->app->cache->get('hours', []);
        if (empty($this->hours)) {
            for ($i = 0; $i < 24; $i++) {
                $date = date('Y-m-d H',strtotime(date('Y-m-d')) + $i * 3600);
                $this->hours[] = [
                    '当天时间' => date('H:i', strtotime(date('Y-m-d')) + $i * 3600),
                    '今日统计' => VoteProjectRecord::mk()->where(['deleted'=>0])->whereLike('create_time', "{$date}%")->count()
                ];
            }
            $this->app->cache->set('hours', $this->hours, 60);
        }

        $this->todayRecord = VoteProjectRecord::mk()->where(['deleted'=>0])->whereDay('create_time')->cache(true, 60)->count();
        $this->todayUser = count(array_unique(VoteProjectRecord::mk()->where(['deleted'=>0])->whereDay('create_time')->cache(true, 60)->column('unid')));
        $this->todayPlayer = VoteProjectPlayer::mk()->where(['is_check'=>1,'status'=>1,'deleted'=>0])->cache(true, 60)->count();
        $this->todayComment = VoteProjectComment::mk()->where(['deleted'=>0])->cache(true, 60)->count();
        $this->days = $this->app->cache->get('days', []);
        if (empty($this->days)) {
            for ($i = 30; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-{$i}days"));
                $this->days[] = [
                    '当天日期' => date('m-d', strtotime("-{$i}days")),
                    '投票统计' => VoteProjectRecord::mk()->where(['deleted'=>0])->whereLike('create_time', "{$date}%")->count(),
                ];
            }
            $this->app->cache->set('days', $this->days, 60);
        }
        $this->project = VoteProject::mk()->where(['status'=>1,'deleted'=>0])->field('code,title')->withCount(['record'=>'count'])->where('status',1)->select()->toArray();
        $this->fetch();
    }
}