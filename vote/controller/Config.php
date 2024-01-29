<?php


namespace app\vote\controller;

use app\vote\service\Config as ConfigService;
use think\admin\Controller;
use think\admin\Exception;

/**
 * 投票参数配置
 * @class Config
 * @package app\vote\controller
 */
class Config extends Controller
{

    /**
     * 跳转规则定义
     * @var string[]
     */
    protected $rules = [
        '#'  => ['name' => '不跳转'],
        'LK' => ['name' => '自定义链接'],
        'VL' => ['name' => '投票项目列表'],
        'XL' => ['name' => '投票选手列表', 'node' => 'vote/project/select'],
        'XS' => ['name' => '投票选手详情', 'node' => 'vote/player/select'],
    ];

    /**
     * 投票参数配置
     * @auth true
     * @menu true
     * @return void
     * @throws Exception
     */
    public function index()
    {
        $this->title = '投票参数配置';
        $this->data = ConfigService::get();
        $this->pages = ConfigService::$pageTypes;
        $this->fetch();
    }

    /**
     * 修改参数配置
     * @auth true
     * @return void
     * @throws Exception
     */
    public function params()
    {
        if ($this->request->isGet()) {
            $this->vo = ConfigService::get();
            $this->fetch('index_params');
        } else {
            ConfigService::set($this->request->post());
            $this->success('配置更新成功！');
        }
    }

    /**
     * 修改协议内容
     * @auth true
     * @return void
     * @throws Exception
     */
    public function content()
    {
        $input = $this->_vali(['code.require' => '编号不能为空！']);
        $title = ConfigService::pageTypes($input['code']) ?? null;
        if (empty($title)) $this->error('无效的内容编号！');
        if ($this->request->isGet()) {
            $this->title = "编辑{$title}";
            $this->data = ConfigService::getPage($input['code']);
            $this->fetch('index_content');
        } elseif ($this->request->isPost()) {
            ConfigService::setPage($input['code'], $this->request->post());
            $this->success('内容保存成功！', 'javascript:history.back()');
        }
    }

    /**
     * 首页轮播
     * @auth true
     * @return void
     * @throws Exception
     */
    public function slider()
    {
        $input = $this->_vali(['code.require' => '编号不能为空！']);
        $title = ConfigService::pageTypes($input['code']) ?? null;
        if (empty($title)) $this->error('无效的内容编号！');
        if ($this->request->isGet()) {
            $this->title = "编辑{$title}";
            $this->data = Config::getPage($input['code']);
            $this->fetch('index_slider');
        } elseif ($this->request->isPost()) {
            if (is_string(input('data'))) {
                $data = json_decode(input('data'), true) ?: [];
            } else {
                $data = $this->request->post();
            }
            ConfigService::setPage($input['code'], $data);
            $this->success('内容保存成功！', 'javascript:history.back()');
        }
    }
}