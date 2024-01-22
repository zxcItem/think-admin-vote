<?php

namespace app\vote\model;


use app\data\model\DataUser;
use think\model\relation\BelongsTo;

class VoteProjectRecord extends Abs
{

    /**
     * 关联项目
     * @return BelongsTo
     */
    public function projectName()
    {
        return $this->belongsTo(VoteProject::class,'code','code')->bind(['project_name'=>'title']);
    }

    /**
     * 关联用户
     * @return BelongsTo
     */
    public function userName()
    {
        return $this->belongsTo(DataUser::class,'unid','id')->bind(['nickname']);
    }

    /**
     * 关联选手
     * @return BelongsTo
     */
    public function playerName()
    {
        return $this->belongsTo(VoteProjectPlayer::class,'player_id','id')->bind(['player_name'=>'name']);
    }
}