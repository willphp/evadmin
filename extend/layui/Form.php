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

use willphp\core\Single;

class Form
{
    use Single;

    public function build(array $vo, bool $isEdit = false): array
    {
        $push_module = $form_js = $form_post_data = '';
        $title = $vo['input_title'] ?: $vo['field_title'];
        $value = $isEdit ? '{$vo.' . $vo['field_name'] . '}' : $vo['input_default'];
        $input = '';
        if ($vo['form_type'] == 'text') {
            $input = $this->input_text($vo, $value);
        } elseif ($vo['form_type'] == 'textarea' || $vo['form_type'] == 'editor') {
            $input = $this->textarea($vo, $value);
            if ($vo['form_type'] == 'editor') {
                [$push_module, $form_js, $form_post_data] = $this->getEditorJs($vo['field_name']);
            }
        } elseif ($vo['form_type'] == 'switch') {
            $input = $this->switch($vo, $isEdit);
        } elseif ($vo['form_type'] == 'radio' || $vo['form_type'] == 'select' || $vo['form_type'] == 'selects') {
            $input = $this->select_radio($vo, $isEdit);
            if ($vo['form_type'] == 'selects') {
                $push_module = "\n\tlayui_module.push('select');";
            }
        } elseif ($vo['form_type'] == 'date' || $vo['form_type'] == 'datetime') {
            $input = $this->datetime($vo, $isEdit);
            $form_js = $this->datetime_js($vo); //日期时间JS
        } elseif ($vo['form_type'] == 'image') {
            $input = $this->image($vo, $isEdit);
            $form_js = $this->image_js($vo); //单图上传
        }
        $form_item = "<div class=\"layui-form-item\">\n\t<label class=\"layui-form-label\">{$title}</label>\n\t<div class=\"layui-input-block\">{$input}</div>\n</div>\n";
        return [$form_item, $push_module, $form_js, $form_post_data];
    }

    public function buildSearch(array $vo): string
    {
        $str = '<div class="layui-form-item layui-inline"><label class="layui-form-label">'.$vo['input_title'].'</label><div class="layui-input-inline">';
        if ($vo['form_type'] == 'switch') {
            $dataSet = str_contains($vo['input_tip'], '|') ? explode('|', $vo['input_tip']) : ['开启','关闭'];
            $dataSet = [-1 => '全部'] + $dataSet;
            $dataSet = $this->getArrayStr($dataSet);
            $str .= '{:build_select(\'' . $vo['field_name'] . '\', ' . $dataSet . ', -1)}';
        } elseif ($vo['form_type'] == 'radio' || $vo['form_type'] == 'select') {
            $dataSet = ($vo['bind_dict_id'] > 0) ? 'widget(\'dict\')->get(' . $vo['bind_dict_id'] . ', [\'head\'=>[\'全部\']])' : 'widget(\'form_tip\')->get(' . $vo['id'] . ', [\'head\'=>[\'全部\']])';
            $str .= '{:build_select(\'' . $vo['field_name'] . '\', ' . $dataSet . ', 0)}';
        } else {
            $str .= '<input type="text" name="'.$vo['field_name'].'" placeholder="'.$vo['input_tip'].'" class="layui-input">';
        }
        return $str.'</div></div>';
    }

    protected function getArrayStr(array $arr): string
    {
        $str = '[';
        foreach ($arr as $k => $v) {
            $str .= "'$k' => '$v',";
        }
        return $str . ']';
    }

    //文本框
    protected function input_text(array $vo, $value = ''): string
    {
        $lay_verify = ($vo['input_verify'] == 'nullable') ? '' : ' lay-verify="' . $vo['input_verify'] . '"';
        return '<input type="text" name="' . $vo['field_name'] . '" placeholder="' . $vo['input_tip'] . '" value="' . $value . '"' . $lay_verify . ' class="layui-input">';
    }

    //文本域或编辑器
    protected function textarea(array $vo, $value = ''): string
    {
        $id = 'id="editor-' . $vo['field_name'] . '"';
        return '<textarea name="' . $vo['field_name'] . '" ' . $id . ' placeholder="' . $vo['input_tip'] . '" class="layui-textarea">' . $value . '</textarea>';
    }

    //开关
    protected function switch(array $vo, bool $isEdit = false): string
    {
        if ($isEdit) {
            $checked = '{if $vo[\'' . $vo['field_name'] . '\']:} checked="checked"{/if}';
        } else {
            $checked = ($vo['input_default'] == 1) ? ' checked="checked"' : '';
        }
        $lay_text = '开启|关闭';
        if (str_contains($vo['input_tip'], '|')) {
            $tmp = explode('|', $vo['input_tip']);
            $lay_text = $tmp[1].'|'.$tmp[0];
        }
        return '<input type="checkbox" name="' . $vo['field_name'] . '" value="1" lay-skin="switch" lay-text="' . $lay_text . '"' . $checked . '>';
    }

    //下拉框和单选框
    protected function select_radio(array $vo, bool $isEdit = false): string
    {
        $value = $isEdit ? '$vo[\'' . $vo['field_name'] . '\']' : '\''.$vo['input_default'].'\'';
        $dataSet = ($vo['bind_dict_id'] > 0) ? 'widget(\'dict\')->get(' . $vo['bind_dict_id'] . ')' : 'widget(\'form_tip\')->get(' . $vo['id'] . ')';
        if ($vo['form_type'] == 'selects') {
            return '{:build_select(\'' . $vo['field_name'] . '\', ' . $dataSet . ', ' . $value . ', \' xm-select="'.$vo['field_name'].'"\')}';
        }
        return '{:build_' . $vo['form_type'] . '(\'' . $vo['field_name'] . '\', ' . $dataSet . ', ' . $value . ')}';
    }

    //日期时间
    protected function datetime(array $vo, bool $isEdit = false): string
    {
        $format = 'Y-m-d';
        $placeholder = 'yyyy-MM-dd';
        if ($vo['form_type'] == 'datetime') {
            $format .= ' H:i:s';
            $placeholder .= ' HH:mm:ss';
        }
        $value = $isEdit ? '{:date(\'' . $format . '\', $vo[\'' . $vo['field_name'] . '\'])}' : '{:date(\'' . $format . '\')}';
        return '<input type="text" name="' . $vo['field_name'] . '" value="' . $value . '" class="layui-input" id="' . $vo['form_type'] . '-' . $vo['field_name'] . '" placeholder="' . $placeholder . '">';
    }

    //单图上传
    protected function image(array $vo, bool $isEdit = false): string
    {
        $value = $isEdit ? '{$vo.'.$vo['field_name'].'}' : '';
        $html = '<input type="hidden" id="' . $vo['field_name'] . '" name="' . $vo['field_name'] . '" value="'.$value.'"><div class="upload-image layui-upload-drag" id="ID-upload-'.$vo['field_name'].'-drag">';
        $add = '<img id="'.$vo['field_name'].'-preview" src="" style="display:none;" width="90" height="60">上传图片<span id="del_'.$vo['field_name'].'" class="del_pic">删除</span>';
        if ($isEdit) {
            $html .= '{if empty($vo[\'' . $vo['field_name'] . '\']):}'.$add.'{else:}<img id="'.$vo['field_name'].'-preview" src="{$vo.'.$vo['field_name'].'}" width="90" height="60">上传图片<span id="del_'.$vo['field_name'].'" class="del_pic" style="display:inline;">删除</span>{/if}';
        } else {
            $html .= $add;
        }
        return $html.'</div>{:opt_photo(\''.$vo['field_name'].'\')}';
    }

    //编辑器Js
    protected function getEditorJs(string $field_name): array
    {
        $push_module = "\n\tlayui_module.push('tinymce');";
        $form_js = "\n\t\tlet editor = layui.tinymce.render({elem:'#editor-{$field_name}',height:400,images_upload_handler:(blobInfo,success,failure)=>{let formData=new FormData();formData.append('file',blobInfo.blob(),blobInfo.filename());$.ajax({url:\"{:url('api/upload_image')}\",data:formData,type:'post',contentType:false,processData:false,success:function(res){if(res.status===1){success(res.data.path)}else{failure(res.msg)}}})}});";
        $form_post_data = "\n\t\t\tdata.field.content = editor.getContent();";
        return [$push_module, $form_js, $form_post_data];
    }

    //日期时间JS
    protected function datetime_js(array $vo): string
    {
        return "\n\t\tlayui.laydate.render({ elem: '#{$vo['form_type']}-{$vo['field_name']}', type: '{$vo['form_type']}'});";
    }

    //单图上传JS
    protected function image_js(array $vo): string
    {
        $js  = "\n\t\tlayui.upload.render({elem:'#ID-upload-{$vo['field_name']}-drag',url:\"{:url('api/upload_image')}\",done:function(res){if(res.status==1){del_pic();$('#{$vo['field_name']}').val(res.data.path);$('#{$vo['field_name']}-preview').attr('src',res.data.path).show();$('#del_{$vo['field_name']}').show()}}});";
        $js .= "\n\t\t$('#del_{$vo['field_name']}').on('click',function(e){del_pic();$('#{$vo['field_name']}').val('');$('#{$vo['field_name']}-preview').attr('src','').hide();$('#del_{$vo['field_name']}').hide();layui.stope(e)});";
        return $js."\n\t\tfunction del_pic(){let pic=$('#{$vo['field_name']}-preview').attr('src');$('#{$vo['field_name']}').val('');if(pic.trim().length!==0){ $.post(\"{:url('api/image_del')}\",{pic:pic},function(ret){},'json') }}";
    }
}