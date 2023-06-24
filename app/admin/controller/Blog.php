<?php
declare(strict_types=1);
namespace app\admin\controller;
//生成时间：2023-06-24 21:55:34
class Blog extends Base {
	protected string $model = 'blog';
	protected string $order = 'id DESC';
	protected int $limit = 10;
	protected string $listExcept = 'content';
	protected array $where = ['title' => ['text', 'like', '', 'clear_html'],'category_id' => ['select', '=', 0, 'intval'],'status' => ['select', '=', -1, 'intval'],];
}