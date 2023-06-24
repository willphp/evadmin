<?php
declare(strict_types=1);
namespace app\admin\controller;
class Admin extends Base
{
    protected string $model = 'admin';
    protected string $order = 'id ASC';
    protected string $listExcept = 'password,about';

}