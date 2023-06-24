<?php
declare(strict_types=1);
namespace app\admin\widget;
use willphp\core\Widget;
class Bind extends Widget
{
    protected string $tagName = 'dict';
    protected int $expire = 0;
    public function set($id = '', array $options = [])
    {
        $bind = ['=未绑定='];
        $list = db('dict')->where('type', 0)->where('status', 1)->order('sort ASC,id ASC')->column('title', 'id');
        $bind += $list;
        return $bind[$id] ?? $bind;
    }
}