<?php
/*----------------------------------------------------------------
 | Software: [WillPHP framework]
 | Site: 113344.com
 |----------------------------------------------------------------
 | Author: 无念 <24203741@qq.com>
 | WeChat: www113344
 | Copyright (c) 2020-2023, 113344.com. All Rights Reserved.
 |---------------------------------------------------------------*/
declare(strict_types=1);
namespace extend\layui;
use willphp\core\Dir;
use willphp\core\Single;
class Builder
{
    use Single;

    protected array $model; //模型数据
    protected array $field; //模型字段数据

    private function __construct(int $model_id)
    {
        $this->model = db('model')->where('id', $model_id)->find();
        $this->field = db('model_field')->where('model_id', $model_id)->order('sort ASC,id ASC')->select();
    }

    public function make(string $type): bool
    {
        $method = 'make_' . $type;
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return false;
    }

    //生成控制器类
    public function make_ctrl(): bool
    {
        $table = $this->model['table_name'];
        $name = ucfirst(strtolower(name_camel($table)));
        $desc = '//生成时间：' . date('Y-m-d H:i:s');
        $tmp = "<?php\ndeclare(strict_types=1);\nnamespace app\\admin\\controller;\n{$desc}\nclass {$name} extends Base {";
        $tmp .= "\n\tprotected string \$model = '{$table}';";
        $tmp .= "\n\tprotected string \$order = '{$this->model['list_order']}';";
        $tmp .= "\n\tprotected int \$limit = {$this->model['list_limit']};";
        $tmp .= "\n\tprotected string \$listExcept = '{$this->model['list_except']}';";
        if ($this->model['is_recycle']) {
            $tmp .= "\n\tprotected bool \$isRecycle = true;";
        }
        $tmp .= "\n\t".$this->build_where();
        $tmp .= "\n}";
        file_put_contents(ROOT_PATH . '/app/admin/controller/' . $name . '.php', $tmp);
        return true;
    }

    protected function build_where(): string
    {
        $where = 'protected array $where = [';
        foreach ($this->field as $vo) {
            if ($vo['is_search']) {
                if (in_array($vo['form_type'], ['select', 'radio', 'switch'])) {
                    $default = ($vo['form_type'] == 'switch') ? -1 : 0;
                    $where .= "'{$vo['field_name']}' => ['select', '{$vo['search_exp']}', {$default}, 'intval'],";
                } else {
                    $where .= "'{$vo['field_name']}' => ['{$vo['form_type']}', '{$vo['search_exp']}', '', 'clear_html'],";
                }
            }
        }
        return $where.'];';
    }

    //生成模型类
    public function make_model(): bool
    {
        $name = name_camel($this->model['table_name']);
        $desc = '//生成时间：'.date('Y-m-d H:i:s');
        $tmp = "<?php\ndeclare(strict_types=1);\nnamespace app\\admin\\model;\nuse willphp\\core\\Model;";
        $tmp .= "\n{$desc}\nclass {$name} extends Model {";
        $tmp .= "\n\tprotected string \$table = '{$this->model['table_name']}';";
        $tmp .= "\n\tprotected string \$pk = '{$this->model['table_primary']}';";
        $verify = $auto = $filter = '';
        foreach ($this->field as $vo) {
            if ($vo['verify_on']) {
                $verify .= "\n\t\t['{$vo['field_name']}', '{$vo['verify_rule']}', '{$vo['verify_msg']}', {$vo['verify_at']}, {$vo['verify_in']}],";
            }
            if ($vo['auto_on']) {
                $auto .= "\n\t\t['{$vo['field_name']}', '{$vo['auto_rule']}', '{$vo['auto_way']}', {$vo['auto_at']}, {$vo['auto_in']}],";
            }
            if ($vo['filter_on']) {
                $filter .= "\n\t\t['{$vo['field_name']}', {$vo['filter_at']}, {$vo['filter_in']}],";
            }
        }
        if (!empty($verify)) {
            $tmp .= "\n\tprotected array \$validate = [$verify\n\t];";
        }
        if (!empty($auto)) {
            $tmp .= "\n\tprotected array \$auto = [$auto\n\t];";
        }
        if (!empty($filter)) {
            $tmp .= "\n\tprotected array \$filter = [$filter\n\t];";
        }
        $tmp .= "\n}";
        file_put_contents(ROOT_PATH . '/app/admin/model/' . $name . '.php', $tmp);
        return true;
    }

    //生成菜单
    public function make_menu(): bool
    {
        $menu = db('auth_rule');
        $isFind = $menu->where('model_id', $this->model['id'])->field('id')->find();
        if ($isFind) {
            return false;
        }
        $data = [];
        $data['pid'] = 1;
        $data['level'] = 1;
        $data['path'] = ',1,';
        $data['title'] = $this->model['model_title'];
        $data['icon'] = 'layui-icon-face-smile-fine';
        $data['auth'] = $data['href'] = $this->model['table_name'] . '/index';
        $data['type'] = 1;
        $data['model_id'] = $this->model['id'];
        $data['sort'] = 50;
        $data['status'] = 1;
        $menu->insert($data);
        return true;
    }

    //生成模板
    public function make_view(): bool
    {
        $addReplace = $editReplace = ['', '', '', ''];
        $indexReplace = ['', ''];
        $searchStr = '';
        $form = Form::init();
        foreach ($this->field as $vo) {
            if ($vo['at_list'] || in_array($vo['field_name'], ['id', 'status'])) {
                $index = $this->buildList($vo);
                $indexReplace = array_map(fn($a, $b) => $a.$b, $indexReplace, $index);
            }
            if ($vo['at_add']) {
                $add = $form->build($vo);
                $addReplace = array_map(fn($a, $b) => $a.$b, $addReplace, $add);
            }
            if ($vo['at_edit']) {
                $edit = $form->build($vo, true);
                $editReplace = array_map(fn($a, $b) => $a.$b, $editReplace, $edit);
            }
            if ($vo['is_search']) {
                $searchStr .= $form->buildSearch($vo);
            }
        }
        if (!empty($searchStr)) {
            $searchStr = '<div class="layui-card"><div class="layui-card-body"><form class="layui-form" action="" method="post">'.$searchStr.'<div class="layui-form-item layui-inline"><button class="pear-btn pear-btn-md pear-btn-primary" lay-submit lay-filter="table-search">';
            $searchStr .= '<i class="layui-icon layui-icon-search"></i>查询</button> <button type="reset" class="pear-btn pear-btn-md"><i class="layui-icon layui-icon-refresh"></i>重置</button></div></form></div></div>';
        }
        $indexReplace[] = $searchStr;
        $this->outTpl('index', ['{{$table_cols}}', '{{$field_tpl}}', '{{$table_search}}'], $indexReplace);
        $this->outTpl('add', ['{{$form_item}}', '{{$push_module}}', '{{$form_js}}', '{{$form_post_data}}'], $addReplace);
        $this->outTpl('edit', ['{{$form_item}}', '{{$push_module}}', '{{$form_js}}', '{{$form_post_data}}'], $editReplace);
        if ($this->model['is_recycle']) {
            $this->outTpl('recycle', ['{{$table_cols}}', '{{$field_tpl}}', '{{$table_search}}'], $indexReplace);
        }
        return true;
    }

    protected function buildList(array $vo): array
    {
        $table_cols = $field_tpl = '';
        if ($vo['field_name'] == 'id') {
            $table_cols = "{title: 'ID', field: 'id', width:60, align:'center'},\n";
        } elseif ($vo['field_name'] == 'status') {
            $table_cols = "\t\t{title: '状态', field: 'status', align:'center', unresize: true, templet: '#status'},";
        } else {
            if ($vo['form_type'] == 'radio' || $vo['form_type'] == 'select') {
                $table_cols = "\t\t{title: '{$vo['field_title']}', field: '{$vo['field_name']}', templet: '#{$vo['field_name']}'},\n";
                $dataSet = ($vo['bind_dict_id'] > 0) ? 'widget(\'dict\')->get(' . $vo['bind_dict_id'] . ')' : 'widget(\'form_tip\')->get(' . $vo['id'] . ')';
                $field_tpl = "{:build_templet('{$vo['field_name']}', $dataSet)}\n";
            } elseif (!empty($vo['list_tpl'])) {
                $table_cols = "\t\t{title: '{$vo['field_title']}', field: '{$vo['field_name']}', templet: '<div>" . str_replace("'", "\'", $vo['list_tpl']) . "</div>'},\n";
            } else {
                $table_cols = "\t\t{title: '{$vo['field_title']}', field: '{$vo['field_name']}'},\n";
            }
        }
        return [$table_cols, $field_tpl];
    }

    //输出模板
    protected function outTpl(string $name, array $search, array $replace)
    {
        $viewPath = Dir::make(ROOT_PATH . '/app/admin/view/' . $this->model['table_name']);
        $tpl = file_get_contents(ROOT_PATH . '/app/common/tpl/' . $name . '.tpl');
        $tpl = str_replace($search, $replace, $tpl);
        if ($name == 'index') {
            $recycle = ($this->model['is_recycle']) ? '<button class="layui-btn layui-btn-primary layui-btn-sm" lay-event="recycle"><i class="layui-icon layui-icon-upload-drag"></i>回收站</button>' : '';
            $tpl = str_replace('{{$recycle}}', $recycle, $tpl);
        }
        file_put_contents($viewPath . '/' . $name . '.html', $tpl);
    }
}