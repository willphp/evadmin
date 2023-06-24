<?php
declare(strict_types=1);
namespace app\admin\controller;
class Dict extends Base
{
    protected string $model = 'dict';
    protected string $order = 'sort ASC,id DESC';

    protected function _index_where(): array
    {
        $map = [];
        $title = input('title', '', 'clear_html');
        if (!empty($title)) {
            $field = preg_match('/^\w+$/', $title) ? 'name' : 'title';
            $map[] = [$field, 'like', '%'.$title.'%'];
        }
        $map['type'] = input('type', 0, 'intval');
        return $map;
    }

    public function data(int $id)
    {
        if ($this->isAjax()) {
            $where = ['dict_id' => $id];
            $this->model = 'dict_data';
            $this->order = 'sort ASC,id ASC';
            $this->_json_list($where);
        }
        $this->error('非法请求');
    }

    public function data_add(int $dict_id, array $req)
    {
        $this->model = 'dict_data';
        view_with('dict_id', $dict_id);
        return $this->add($req);
    }

    public function data_edit(int $id, array $req)
    {
        $this->model = 'dict_data';
        return $this->edit($id, $req);
    }

    public function data_del(string $ids)
    {
        $this->model = 'dict_data';
        $this->destroy($ids);
    }

    public function data_state(string $ids)
    {
        $this->model = 'dict_data';
        $this->state($ids);
    }
}