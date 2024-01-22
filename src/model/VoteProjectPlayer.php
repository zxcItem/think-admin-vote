<?php

namespace app\vote\model;


use think\model\relation\HasMany;

class VoteProjectPlayer extends Abs
{

    public function projectName()
    {
        return $this->belongsTo(VoteProject::class,'code','code')->bind(['project_name'=>'title']);
    }

    /**
     * 一对多关联投票记录
     * @return HasMany
     */
    public function record()
    {
        return $this->hasMany(VoteProjectRecord::class,'player_id');
    }

}