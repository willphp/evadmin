<?php
declare(strict_types=1);
namespace app\admin\controller;
class Image extends Base {
	protected string $model = 'image';
	protected string $order = 'id DESC';

    public function list()
    {
        return view();
    }
}