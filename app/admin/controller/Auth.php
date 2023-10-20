<?php
declare(strict_types=1);
namespace app\admin\controller;
class Auth extends Base
{
    protected string $model = 'auth_rule';
    protected string $order = 'sort ASC,id ASC';
    protected int $limit = 0;
}