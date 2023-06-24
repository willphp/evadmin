<?php
declare(strict_types=1);
namespace app\admin\controller;
class Image extends Base {
	protected string $model = 'image';
	protected string $order = 'id DESC';

    protected function _parse_list(array $list): array
    {
        foreach ($list as &$vo) {
            $vo['filesize'] = size_format($vo['filesize']);
        }
        return $list;
    }

    public function list()
    {
        return view();
    }
}