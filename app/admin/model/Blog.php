<?php
declare(strict_types=1);
namespace app\admin\model;
use willphp\core\Model;
//生成时间：2023-06-24 21:55:38
class Blog extends Model {
	protected string $table = 'blog';
	protected string $pk = 'id';
	protected array $auto = [
		['is_top', '0', 'string', 5, 1],
		['post_time', 'strtotime', 'function', 1, 1],
		['status', '1', 'string', 1, 2],
	];
}