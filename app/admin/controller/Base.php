<?php
declare(strict_types=1);
namespace app\admin\controller;
use willphp\core\Jump;
abstract class Base
{
    use Jump;
    protected string $middleware = 'auth'; //登录验证
    protected string $model; //模型名称
    protected string $order = 'id DESC'; //数据排序
    protected int $limit = 10; //数据获取条数(0获取全部)
    protected string $listExcept = ''; //列表查询排除字段,多个用,分开
    protected bool $isRecycle = false; //开启回收站
    protected string $jumpUrl = 'index'; //操作跳转URL
    protected array $where = []; //搜索条件设置
    protected array $stateList = ['status' => ['停用', '启用']];

    //首页搜索条件设置
    protected function _index_where(): array
    {
        return [];
    }

    //首页
    public function index()
    {
        if ($this->isAjax()) {
            $where = $this->_index_where();
            if ($this->isRecycle) {
                $where['delete_time'] = 0;
            }
            $this->_json_list($where);
        }
        return view()->with('limit', $this->limit);
    }

    //新增
    public function add(array $req)
    {
        if ($this->isPost()) {
            $r = model($this->model)->save($req);
            $this->_jump(['添加成功', '添加失败'], $r, $this->jumpUrl);
        }
        return view();
    }

    //修改
    public function edit(int $id, array $req)    {
        $model = model($this->model)->find($id);
        if (!$model) {
            $this->error('记录不存在');
        }
        if ($this->isPost()) {
            $r = $model->save($req);
            $this->_jump(['修改成功', '修改失败'], $r, $this->jumpUrl);
        }
        return view()->with('vo', $model->toArray());
    }

    //删除
    public function del(string $ids)
    {
        if ($this->isRecycle) {
            $ids = array_filter(explode(',', $ids), 'is_numeric');
            if (empty($ids)) {
                $this->error('请选择ID');
            }
            $map = [];
            $map['delete_time'] = 0;
            if (count($ids) == 1) {
                $map['id'] = current($ids);
            } else {
                $map[] = ['id', 'in', $ids];
            }
            $model = model($this->model);
            $r = $model->where($map)->setField('delete_time', time());
            $model->updateWidget();
            $this->_jump(['删除成功', '删除失败'], $r, $this->jumpUrl);
        } else {
            $this->destroy($ids);
        }
    }

    //真实删除
    public function destroy(string $ids)
    {
        $ids = array_filter(explode(',', $ids), 'is_numeric');
        if (empty($ids)) {
            $this->error('请选择ID');
        }
        $map = [];
        if ($this->isRecycle) {
            $map[] = ['delete_time', '>', 0];
        } else {
            $map['status'] = 0;
        }
        $model = model($this->model);
        $r = false;
        foreach ($ids as $id) {
            $tmp = $model->where($map)->find($id);
            if ($tmp) {
                $r = $tmp->del();
            }
        }
        $this->_jump(['删除成功', '删除失败，未停用或已禁删'], $r, $this->jumpUrl);
    }

    //状态切换
    public function state(string $ids)
    {
        $ids = array_filter(explode(',', $ids), 'is_numeric');
        if (empty($ids)) {
            $this->error('请选择ID');
        }
        $params = input('params', '', 'clear_html');
        if ($params == '') {
            $this->error('参数必须');
        }
        [$field, $value] = pre_split($params, 'status', '-');
        if (!isset($this->stateList[$field][$value])) {
            $this->error('状态未设置');
        }
        $title = $this->stateList[$field][$value];
        $map = [];
        $map[] = [$field, '<>', $value];
        if (count($ids) == 1) {
            $map['id'] = current($ids);
        } else {
            $map[] = ['id', 'in', $ids];
        }
        $model = model($this->model);
        $r = $model->where($map)->setField($field, $value);
        $model->updateWidget();
        $this->_jump([$title . '成功', $title . '失败'], $r, $this->jumpUrl);
    }

    //回收站搜索条件设置
    protected function _recycle_where(): array
    {
        return $this->_index_where();
    }

    //回收站
    public function recycle()
    {
        if ($this->isAjax()) {
            $where = $this->_recycle_where();
            $where[] = ['delete_time', '>', 0];
            $this->_json_list($where);
        }
        return view()->with('limit', $this->limit);
    }

    //数据恢复
    public function restore(string $ids)
    {
        $ids = array_filter(explode(',', $ids), 'is_numeric');
        if (empty($ids)) {
            $this->error('请选择ID');
        }
        $map = [];
        $map[] = ['delete_time', '>', 0];;
        if (count($ids) == 1) {
            $map['id'] = current($ids);
        } else {
            $map[] = ['id', 'in', $ids];
        }
        $model = model($this->model);
        $r = $model->where($map)->setField('delete_time', 0);
        $model->updateWidget();
        $this->_jump(['恢复成功', '恢复失败'], $r, $this->jumpUrl);
    }

    //发送json列表数据
    protected function _json_list(array $where = [])
    {
        if (!empty($this->where)) {
            $where = array_merge($this->build_where(), $where);
        }
        $model = model($this->model);
        if ($this->limit <= 0) {
            $list = $model->field($this->listExcept, true)->where($where)->order($this->order)->select();
            $count = count($list);
        } else {
            $limit = input('get.limit', $this->limit, 'intval');
            $page = input_page();
            $list = $model->field($this->listExcept, true)->where($where)->order($this->order)->page($page, $limit)->select();
            $count = $model->where($where)->count();
        }
        $list = $this->_parse_list($list);
        $this->_json(200, '', $list, ['count' => $count]);
    }

    //自动生成搜索条件
    private function build_where(): array
    {
        $map = [];
        foreach ($this->where as $k => $v) {
            $v[3] ??= '';
            $$k = input($k, $v[2], $v[3]);
            $isSearch = ($v[0] == 'text')? !empty($$k) : $$k > $v[2];
            if ($isSearch) {
                $map[] = ($v[1] == 'like')? [$k, 'like', '%'.$$k.'%'] : [$k,$v[1], $$k];
            }
        }
        return $map;
    }

    //列表处理
    protected function _parse_list(array $list): array
    {
        return $list;
    }
}