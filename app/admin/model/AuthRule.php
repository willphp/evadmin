<?php
declare(strict_types=1);
namespace app\admin\model;
use willphp\core\Model;
class AuthRule extends Model
{
    protected string $table = 'auth_rule';
    protected string $pk = 'id';

    //=====待添加验证=====
    protected array $validate = [
        ['pid', 'required', '请选择上级节点', 1, 1],
    ];

    protected array $auto = [
        ['is_system', 0, 'string', 5, 1],
        ['status', 1, 'string', 1, 2],
    ];

    protected function _before_insert(array &$data): void
    {
        $parent = $this->where('id', $data['pid'])->field('id,level,path')->find();
        if (!$parent) {
            $this->errors[] = '上级节点不存在';
        } else {
            $data['level'] = $parent['level'] + 1;
            $data['path'] = $parent['path'].$parent['id'].',';
        }
    }

    protected function _before_delete(array $data): void
    {
        $this->db = $this->db->where('is_system=0 AND id>2'); //禁止删除
    }

    protected function _after_delete(array $data): void
    {
        $this->db->where('path', 'like', '%,'.$data['id'].',%')->delete(); //删除伞下菜单
    }
}