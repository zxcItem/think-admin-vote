<?php

namespace app\vote\model;


use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\model\relation\HasMany;

class VoteProject extends Abs
{
    /**
     * 获取项目特定数据
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public static function item()
    {
        return static::mk()->where('status',1)->order('sort desc')->field('code,title')->select()->toArray();
    }

    /**
     * 获取关联记录统计
     * @return HasMany
     */
    public function record()
    {
        return $this->hasMany(VoteProjectRecord::class,'code','code');
    }
}