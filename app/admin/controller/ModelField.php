<?php
declare(strict_types=1);
namespace app\admin\controller;
use extend\layui\Builder;

class ModelField extends Base
{
    protected string $model = 'model_field';
    protected string $order = 'sort ASC,id ASC';
    protected int $modelId;

    public function __construct()
    {
        $this->modelId = input('model_id', 0, 'intval');
        if ($this->modelId == 0) {
            $this->error('非法操作');
        }
        $this->jumpUrl .= '?model_id=' . $this->modelId;
        view_with('model_id', $this->modelId);
    }

    protected function _index_where(): array
    {
        return ['model_id' => $this->modelId];
    }

    //生成控制器
    public function build_ctrl(int $model_id)
    {
        Builder::init($model_id)->make('ctrl');
        $this->success('生成成功', 'index?model_id=' . $model_id);
    }

    //生成模型
    public function build_model(int $model_id)
    {
        Builder::init($model_id)->make('model');
        $this->success('生成成功', 'index?model_id=' . $model_id);
    }

    //生成菜单
    public function build_menu(int $model_id)
    {
        $r = Builder::init($model_id)->make('menu');
        $this->_jump(['生成成功', '菜单已存在'], $r, 'index?model_id=' . $model_id);
    }

    //生成模板
    public function build_view(int $model_id)
    {
        Builder::init($model_id)->make('view');
        $this->success('生成成功', 'index?model_id=' . $model_id);
    }
}