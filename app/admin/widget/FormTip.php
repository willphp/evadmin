<?php
declare(strict_types=1);
namespace app\admin\widget;
use willphp\core\Widget;

class FormTip extends Widget
{
    protected string $tagName = 'model_field';
    protected int $expire = 0;

    //根据模型字段ID获取选顶数组(select,radio)
    public function set($id = '', array $options = [])
    {
        $head = $options['head'] ?? [];
        $tip = db('model_field')->where('id', $id)->where('status', 1)->value('input_tip');
        if (empty($tip)) {
            return $head ?: ['未设置'];
        }
        $tip = $this->parseTip($tip);
        return $head + $tip;
    }

    private function parseTip(string $tip): array
    {
        if (preg_match('/^(\w+)\.(\w+)=(\w+)$/', $tip, $match)) {
            return db($match[1])->where('status=1')->column($match[3], $match[2]);
        }
        $tip = explode('|', $tip);
        $arr = [];
        foreach ($tip as $k => $v) {
            [$key, $val] = pre_split($v, strval($k), '=');
            $arr[$key] = $val;
        }
        return $arr;
    }
}