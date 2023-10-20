<?php
declare(strict_types=1);
namespace app\admin\model;
use willphp\core\Model;
class Image extends Model {
	protected string $table = 'image';
	protected string $pk = 'id';
	protected array $auto = [
		['status', '1', 'string', 1, 2],
	];

    public function getFilesizeAttr(int $val, array $data): string
    {
        return size_format($val);
    }

    protected function _after_delete(array $data): void
    {
        $filename = trim($data['path'], '.');
        $file = ROOT_PATH.'/public'.$filename;
        if (file_exists($file)) {
            unlink($file);
        }
    }
}