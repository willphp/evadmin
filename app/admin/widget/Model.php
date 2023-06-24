<?php
declare(strict_types=1);
namespace app\admin\widget;
use willphp\core\Widget;
class Model extends Widget
{
    protected string $tagName = 'model';
    protected int $expire = 0;

    public function set($id = '', array $options = [])
    {
        if (!empty($id)) {
            return db('model')->where('id', $id)->value('table_name');
        }
        return db('model')->where('status', 1)->order('id ASC')->column('table_name', 'id');
    }
}