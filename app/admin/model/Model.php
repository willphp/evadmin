<?php
declare(strict_types=1);
namespace app\admin\model;
use willphp\core\Model as CoreModel;
class Model extends CoreModel
{
    protected string $table = 'model';
    protected string $pk = 'id';

    protected array $validate = [
        ['model_title', 'required|unique', '标题必须|标题已存在', 1, 1],
        ['table_name', '/^\w{3,20}$/|unique', '表名格式错误|表名已存在', 1, 1],
        ['table_comment', 'required', '表注释必须', 1, 1],
        ['table_primary', 'required', '表主键必须', 1, 2],
    ];

    protected array $auto = [
        ['status', 1, 'string', 1, 2],
    ];

    protected function _after_update(array $old, array $new): void
    {
        if ($new['table_name'] != $old['table_name']) {
            $this->db->execute('ALTER TABLE `'.$this->tablePrefix.$old['table_name'].'` RENAME TO `'.$this->tablePrefix.$new['table_name'].'`;');
        }
        if ($new['table_comment'] != $old['table_comment']) {
            $this->db->execute('ALTER TABLE `'.$this->tablePrefix.$new['model_table'].'` COMMENT \''.$new['table_comment'].'\';');
        }
    }

    //删除模型后删除表和模型字段
    protected function _after_delete(array $data): void
    {
        $this->db->execute('DROP TABLE IF EXISTS `'.$data['table_prefix'].$data['table_name'].'`;'); //删除模型表
        db('model_field')->where('model_id', $data['id'])->delete(); //删除模型字段
        db('auth_rule')->where('model_id', $data['id'])->delete(); //删除菜单
        $name = name_camel($data['table_name']);
        $viewPath = ROOT_PATH.'/app/admin/view/'.strtolower($name);
        $build = [];
        $build[] = ROOT_PATH . '/app/admin/controller/' . ucfirst(strtolower($name)) . '.php';
        $build[] = ROOT_PATH . '/app/common/model/' . $name . '.php';
        $build[] = $viewPath.'/index.html';
        $build[] = $viewPath.'/add.html';
        $build[] = $viewPath.'/edit.html';
        $build[] = $viewPath.'/recycle.html';
        foreach ($build as $file) {
            if (is_file($file)) unlink($file);
        }
        if (is_dir($viewPath)) rmdir($viewPath);
    }

    protected function _before_insert(array &$data): void
    {
        $data['table_prefix'] = $this->tablePrefix;
    }

    protected function _after_insert(array $data): void
    {
        $data = $this->parseData($data);
        $this->createTable($data);
        $modelField = db('model_field');
        foreach ($data['model_field'] as $vo) {
            $vo['model_id'] = intval($data['id']);
            $modelField->insert($vo);
        }
    }

    //处理数据
    protected function parseData(array $data): array
    {
        $fieldIds = trim($data['id_field'].','.$data['fields'], ',');
        $list = db('field')->where('id', 'in', $fieldIds, 'or')->where('level', 1)->order('sort ASC,id ASC')->select();
        foreach ($list as $vo) {
            $field = $vo['field_name'];
            if ($field == 'delete_time' && !$data['is_recycle']) {
                continue;
            }
            $data['field_list'][$field]['type'] = $vo['field_type'];
            if ($vo['field_length'] > 0) {
                $data['field_list'][$field]['length'] = $vo['field_length'];
            }
            if ($vo['field_default'] != 'null') {
                $data['field_list'][$field]['default'] = $vo['field_default'];
            }
            $data['field_list'][$field]['comment'] = $vo['field_comment'];
            if ($vo['is_unsigned']) {
                $data['field_list'][$field]['unsigned'] = true;
            }
            if ($vo['is_required']) {
                $data['field_list'][$field]['required'] = true;
            }
            if ($vo['is_autoinc']) {
                $data['field_list'][$field]['autoincrement'] = true;
            }
            unset($vo['id'], $vo['dict_name']);
            $data['model_field'][] = $vo;
        }
        return $data;
    }

    //创建模型表
    protected function createTable(array $data): void
    {
        $data['table_engine'] ??= 'InnoDB';
        $data['table_charset'] ??= 'utf8mb4';
        $data['table_primary'] = ['id'];
        $fields = [];
        foreach ($data['field_list'] as $field => $set) {
            $fields[] = $this->parseField($field, $set, $data, true);
        }
        $fields[] = $this->parsePrimary($data['table_primary']);
        $sql = 'CREATE TABLE `'.$data['table_prefix'].$data['table_name'].'`';
        $sql .= ' (' .implode(' , ', $fields).')';
        $sql .= ' ENGINE='.$data['table_engine'].' DEFAULT CHARSET='.$data['table_charset'].' COLLATE '.$data['table_collate'].' COMMENT=\''.$data['table_comment'].'\';';
        $this->db->execute($sql);
    }

    //字段处理
    protected function parseField(string $field, array $set, array $data, bool $isChange = false): string
    {
        $fields = [];
        $type = $set['type'] ?? 'varchar';
        $fields[] = '`'.$field.'` '.$type;
        if (isset($set['length'])) {
            $fields[] = '('.$set['length'].')';
        }
        if (isset($set['unsigned']) && $set['unsigned'] === true) {
            $fields[] = 'UNSIGNED';
        }
        if (isset($set['required']) && $set['required'] === true) {
            $fields[] = 'NOT NULL';
        }
        if (isset($set['autoincrement']) && $set['autoincrement'] === true) {
            $fields[] = 'AUTO_INCREMENT';
        }
        if (in_array($field, $data['table_primary']) && !$isChange) {
            $fields[] = 'PRIMARY KEY';
        }
        if (isset($set['default'])) {
            $fields[] = "DEFAULT '{$set['default']}'";
        }
        if (isset($set['comment'])) {
            $fields[] = "COMMENT '{$set['comment']}'";
        }
        return implode(' ', $fields);
    }

    //主键处理
    protected function parsePrimary(array $primary): string
    {
        foreach ($primary as &$val) {
            $val = '`'.$val.'`';
        }
        return 'PRIMARY KEY ('.implode(',', $primary).')';
    }
}