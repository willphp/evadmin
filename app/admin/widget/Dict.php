<?php
declare(strict_types=1);
namespace app\admin\widget;
use willphp\core\Widget;
class Dict extends Widget
{
    protected string $tagName = 'dict_data';
    protected int $expire = 0;

    //根据字典名称或ID获取字典值
    public function set($id = '', array $options = [])
    {
        $head = $options['head'] ?? [];
        $field = is_numeric($id) ? 'dict_id' : 'dict_name';
        $list = db('dict_data')->where($field, $id)->where('status', 1)->order('sort ASC,id ASC')->column('label', 'value');
        return $head + $list;
    }
}