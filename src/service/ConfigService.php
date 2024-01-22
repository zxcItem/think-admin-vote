<?php

// +----------------------------------------------------------------------
// | WeMall Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wemall
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wemall
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace app\vote\service;

/**
 * 商城配置服务
 * @class ConfigService
 * @package app\vote\service
 */
class ConfigService
{

    /**
     * 商城配置缓存名
     * @var string
     */
    private static $skey = 'vote.config';

    /**
     * 页面类型配置
     * @var string[]
     */
    public static $pageTypes = [
        [
            'name' => 'user_agreement',
            'title' => '用户使用协议',
            'temp'  => 'content'
        ],
        [
            'name' => 'slider_page',
            'title' => '首页轮播',
            'temp'  => 'slider'
        ]
    ];


    /**
     * 类型配置获取
     * @param string $name
     * @return mixed
     */
    public static function pageTypes(string $name)
    {
        return array_column(self::$pageTypes,'title','name')[$name];
    }

    /**
     * 读取商城配置参数
     * @param string|null $name
     * @param $default
     * @return array|mixed|null
     * @throws \think\admin\Exception
     */
    public static function get(?string $name = null, $default = null)
    {
        $syscfg = sysvar(self::$skey) ?: sysvar(self::$skey, sysdata(self::$skey));
        if (empty($syscfg['domain'])) $syscfg['domain'] = sysconf('base.site_host') . '/h5';
        return is_null($name) ? $syscfg : ($syscfg[$name] ?? $default);
    }

    /**
     * 设置页面数据
     * @param string $code 页面编码
     * @param array $data 页面内容
     * @return mixed
     * @throws \think\admin\Exception
     */
    public static function setPage(string $code, array $data)
    {
        return sysdata("vote.page.{$code}", $data);
    }

    /**
     * 获取页面内容
     * @param string $code
     * @return array
     * @throws \think\admin\Exception
     */
    public static function getPage(string $code): array
    {
        return sysdata("vote.page.{$code}");
    }
}