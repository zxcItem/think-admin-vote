<?php

namespace app\vote\model;


use think\model\relation\BelongsTo;
use think\model\relation\HasMany;

/**
 * 投票项目选手模型
 */
class VoteProjectPlayer extends Abs
{

    /**
     * 关联项目
     * @return BelongsTo
     */
    public function projectName(): BelongsTo
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