<?php
declare(strict_types=1);
namespace app\admin\controller;
class Group extends Base
{
    protected string $model = 'auth_group';
    protected string $order = 'id ASC';
    protected string $listExcept = 'auth'; //列表查询排除字段,多个用,分开

    public function get_auth(string $selected = '')
    {
        $selected = !empty($selected) ? array_map('intval', explode(',', $selected)) : [];
        $data = db('auth_rule')->field('id,pid,title')->where('id', '>', 1)->where('status', 1)->order('sort ASC,id ASC')->select();
        $data = $this->_get_tree($data, 1, $selected);
        $this->_json(200, '', $data);
    }

    private function _get_tree(array $menu, int $pid = 1, array $selected = []): array
    {
        $tree = [];
        foreach ($menu as $v) {
            $v['checked'] = in_array($v['id'], $selected) || $v['id'] == 2;
            $v['disabled'] = false;
            if ($v['pid'] == $pid) {
                $v['children'] = $this->_get_tree($menu, $v['id'], $selected);
                $tree[] = $v;
            }
        }
        return $tree;
    }

}