<?php
declare(strict_types=1);
namespace app\admin\widget;
use willphp\core\Widget;
class Field extends Widget
{
    protected string $tagName = 'field';
    protected int $expire = 0;

    //根据字典名称或ID获取字典值
    public function set($id = '', array $options = [])
    {
        $level = $options['level'] ?? 0;
        return db('field')->where('level', $level)->where('status', 1)->order('sort ASC,id ASC')->column('dict_name', 'id');
    }
}