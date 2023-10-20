<?php
declare(strict_types=1);
namespace app\admin\controller;
class Index
{
    protected string $middleware = 'auth'; //鉴权中间件

    //首页
    public function index()
    {
        config('debug.is_hide', true);
        return view();
    }

    //系统信息
    public function home()
    {
        $info = [
            '系统版本' => 'EvAdmin v1.1.0 beta',
            '服务器域名/IP' => $_SERVER['SERVER_NAME'] . ' [ ' . gethostbyname($_SERVER['SERVER_NAME']) . ' ]',
            '操作系统' => PHP_OS,
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP版本' => 'PHP ' . PHP_VERSION,
            '剩余空间' => size_format((int)disk_free_space('.')),
            'PHP运行方式' => php_sapi_name(),
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . '秒',
            '服务器时间' => date("Y年n月j日 H:i:s"),
        ];
        return view()->with('info', $info);
    }

    //菜单json
    public function menu()
    {
        $map = [];
        if (session('user.id') <> config('rbac.super_uid')) {
            $ids = session('user.auth');
            $map[] = ['id', 'in', $ids];
        }
        $menu = db('auth_rule')->field('id,pid,title,icon,href,target,type')->where($map)->where('pid>0 AND type<2 AND status=1')->order('sort ASC,id ASC')->select();
        return $this->_get_tree($menu);
    }

    //菜单处理
    private function _get_tree(array $menu, int $pid = 1): array
    {
        $tree = [];
        foreach ($menu as $v) {
            $v['href'] = !empty($v['href']) ? url($v['href']) : '';
            $v['openType'] = $v['target'];
            unset($v['target']);
            $v['icon'] = 'layui-icon ' . $v['icon'];
            if ($v['pid'] == $pid) {
                $v['children'] = $this->_get_tree($menu, $v['id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }
}