<?php
declare(strict_types=1);
namespace app\admin\controller;
class Field extends Base
{
    protected string $model = 'field';
    protected string $order = 'sort ASC,id ASC';
    protected int $limit = 20;

    protected function _index_where(): array
    {
        $map = [];
        $title = input('title', '', 'clear_html');
        if (!empty($title)) {
            $field = preg_match('/^\w+$/', $title) ? 'field_name' : 'field_title';
            $map[] = [$field, 'like', '%'.$title.'%'];
        }
        $status = input('status', '-1', 'intval');
        if ($status >= 0) {
            $map['status'] = $status;
        }
        return $map;
    }
}