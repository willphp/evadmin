<?php
declare(strict_types=1);
namespace app\admin\model;
use willphp\core\Model;
class ModelField extends Model
{
    protected string $table = 'model_field';
    protected string $pk = 'id';
    protected array $validate = [
        ['field_title', 'required', '字段标题必须', 1, 1],
        ['field_name', '/^\w{2,20}$/', '字段名称格式错误', 1, 1],
        ['field_after', '/^\w{2,20}$/|checkField', '字段之后格式错误|字段之后字段不存在', 2, 2], //有值，新增
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

    public function checkField(string $value, string $field, string $params, array $data): bool
    {
        $isFind = $this->db->where('model_id', $data['model_id'])->where('field_name', $value)->field('id')->find();
        return (bool)$isFind;
    }

    protected function _unique_where(array $data): array
    {
        return ['model_id' => $data['model_id']];
    }

    protected function _before_insert(array &$data): void
    {
        $data['input_title'] = $data['field_title'];
        $data['input_tip'] = '请输入'.$data['input_title'];
    }

    //添加字段
    protected function _after_insert(array $data): void
    {
        $this->fieldSave($data);
    }

    //修改字段
    protected function _after_update(array $old, array $new): void
    {
        $this->fieldSave($new, $old['field_name']);
    }

    protected function _before_delete(array $data): void
    {
        $this->db = $this->db->where('field_name', '<>', 'id')->where('field_name', '<>', 'status');
    }

    //删除字段
    protected function _after_delete(array $data): void
    {
        $modelTable = $this->getModelTable($data['model_id']);
        $sql = "ALTER TABLE `{$modelTable}` DROP COLUMN `{$data['field_name']}`;";
        $this->db->execute($sql);
    }

    //字段添加或修改操作
    protected function fieldSave(array $data, string $oldField = ''): void
    {
        $modelTable = $this->getModelTable($data['model_id']);
        $length = ($data['field_length'] > 0) ? '('.$data['field_length'].')' : '';
        $type = $data['field_type'].$length;
        $unsigned = '';
        if ($data['is_unsigned'] && !in_array($data['field_type'], ['VARCHAR','CHAR','TEXT'])) {
            $unsigned = ' UNSIGNED';
        }
        $notNull = $data['is_required'] ? ' NOT NULL' : ' NULL';
        $default = '';
        if ($data['field_default'] == 'null') {
            if (!$data['is_primary']) {
                $default = ' DEFAULT NULL';
                $notNull = ' NULL';
            }
        } else {
            $default = " DEFAULT '{$data['field_default']}'";
        }
        $comment = " COMMENT '{$data['field_comment']}'";
        if (!empty($oldField)) {
            $sql = "ALTER TABLE `{$modelTable}` CHANGE `{$oldField}` `{$data['field_name']}` ".$type.$unsigned.$notNull.$default.$comment.";";
        } else {
            $after = !empty($data['field_after'])? " AFTER `{$data['field_after']}`" : '';
            $sql = "ALTER TABLE `{$modelTable}` ADD COLUMN `{$data['field_name']}`".$type.$unsigned.$notNull.$default.$comment.$after.";";
        }
        $this->db->execute($sql);
    }

    //获取模型表全称
    protected function getModelTable(int $model_id): string
    {
        $vo = db('model')->where('id', $model_id)->field('table_name,table_prefix')->find();
        return $vo['table_prefix'].$vo['table_name'];
    }

}