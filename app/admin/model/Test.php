<?php
declare(strict_types=1);
namespace app\admin\model;
use willphp\core\Model;
//生成时间：2023-06-21 22:20:43
class Test extends Model {
	protected string $table = 'test';
	protected string $pk = 'id';
	protected array $auto = [
		['post_time', 'strtotime', 'function', 1, 1],
		['status', '1', 'string', 1, 2],
	];
}