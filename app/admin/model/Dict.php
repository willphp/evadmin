<?php
declare(strict_types=1);
namespace app\admin\model;
use willphp\core\Model;
class Dict extends Model
{
    protected string $table = 'dict';
    protected string $pk = 'id';
    protected array $validate = [
        ['name', 'string', '名称必须是英文', 1, 1],
        ['title', 'required', '请输入描述', 1, 1],
        ['sort', 'number', '排序必须是数字', 1, 1],
    ];
    protected array $auto = [
        ['name', 'strtolower', 'function', 1, 1],
        ['status', 1, 'string', 1, 2],
    ];

    protected function _after_delete(array $data): void
    {
        db('dict_data')->where('dict_id', $data['id'])->delete(); //删除字典数据
    }

    protected function _after_update(array $old, array $new): void
    {
        if ($new['name'] != $old['name']) {
            db('dict_data')->where('dict_id', $old['id'])->setField('dict_name', $new['name']); //更新对应名称
        }
    }

}