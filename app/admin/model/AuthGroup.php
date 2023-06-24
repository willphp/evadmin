<?php
declare(strict_types=1);
namespace app\admin\model;
use willphp\core\Model;
class AuthGroup extends Model
{
    protected string $table = 'auth_group';
    protected string $pk = 'id';

    //=====待添加验证=====

    protected array $auto = [
        ['status', 1, 'string', 1, 2],
    ];

    protected function _after_update(array $old, array $new): void
    {
        if ($new['id'] == session('user.group_id')) {
            session('user.auth', $new['auth']);
        }
    }
}