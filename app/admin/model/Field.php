<?php
declare(strict_types=1);
namespace app\admin\model;
use willphp\core\Model;
class Field extends Model
{
    protected string $table = 'field';
    protected string $pk = 'id';
    protected array $validate = [
        ['dict_name', 'required', '字典名称必须', 1, 1],
        ['field_title', 'required', '字段标题必须', 1, 1],
        ['field_name', '/^\w{2,20}$/', '字段名称格式错误', 1, 1],
        ['sort', 'number', '排序值必须是数字', 1, 1],
    ];
    protected array $auto = [
        ['field_name', 'strtolower', 'function', 1, 1],
        ['is_unsigned', 0, 'string', 5, 1],
        ['is_required', 0, 'string', 5, 1],
        ['at_list', 0, 'string', 5, 1],
        ['at_add', 0, 'string', 5, 1],
        ['at_edit', 0, 'string', 5, 1],
        ['is_search', 0, 'string', 5, 1],
        ['verify_on', 0, 'string', 5, 1],
        ['auto_on', 0, 'string', 5, 1],
        ['filter_on', 0, 'string', 5, 1],
        ['status', 1, 'string', 1, 2],
    ];

    protected function _before_insert(array &$data): void
    {
        $data['is_primary'] = ($data['level'] == 2) ? 1 : 0;
        $data['is_autoinc'] = $data['is_primary'];
        $data['input_title'] = $data['field_title'];
        $data['input_tip'] = '请输入'.$data['input_title'];
    }
}