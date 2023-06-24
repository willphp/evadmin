<?php
declare(strict_types=1);
namespace app\admin\model;
use willphp\core\Model;
class DictData extends Model
{
    protected string $table = 'dict_data';
    protected string $pk = 'id';
    protected array $validate = [
        ['label', 'required', '请输入标签名', 1, 1],
        ['value', 'string', '对应值必须是英文', 1, 1],
        ['sort', 'number', '排序必须是数字', 1, 1],
    ];
    protected array $auto = [
        ['value', 'strtolower', 'function', 1, 1],
        ['status', 1, 'string', 1, 2],
    ];

    protected function _before_insert(array &$data): void
    {
        $data['dict_name'] =  db('dict')->where('id', $data['dict_id'])->value('name'); //添加时加入字典名称
    }
}