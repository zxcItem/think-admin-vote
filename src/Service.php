<?php

declare (strict_types=1);

namespace app\vote;

use think\admin\Plugin;

/**
 * 组件注册服务
 * @class Service
 * @package app\vote
 */
class Service extends Plugin
{
    /**
     * 定义插件名称
     * @var string
     */
    protected $appName = '投票管理';

    /**
     * 定义安装包名
     * @var string
     */
    protected $package = 'xiaochao/think-plugs-vote';


    /**
     * 增加微信配置
     * @return array[]
     */
    public static function menu(): array
    {
        // 设置插件菜单
        return [
            [
                'name' => '投票管理',
                'subs' => [
                    ['name' => '数据统计报表', 'icon' => 'layui-icon layui-icon-chart', 'node' => "vote/portal/index"],
                    ['name' => '投票参数管理', 'icon' => 'layui-icon layui-icon-set', 'node' => "vote/config/index"],
                    ['name' => '投票项目管理', 'icon' => 'layui-icon layui-icon-slider', 'node' => "vote/project/index"],
                    ['name' => '投票选手管理', 'icon' => 'layui-icon layui-icon-user', 'node' => "vote/player/index"],
                    ['name' => '投票记录管理', 'icon' => 'layui-icon layui-icon-slider', 'node' => "vote/record/index"],
                    ['name' => '投票评论管理', 'icon' => 'layui-icon layui-icon-dialogue', 'node' => "vote/comment/index"],
                ],
            ]
        ];
    }
}