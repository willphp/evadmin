<?php
declare(strict_types=1);
//生成form:select
function build_select(string $name, $options, $selected = '', string $attr = ''): string
{
    $options = is_array($options) ? $options : explode(',', $options);
    $selected = explode(',', strval($selected));
    $html = "<select name=\"{$name}\" $attr>\n";
    foreach ($options as $val => $key) {
        if (in_array($val, $selected)) {
            $html .= "\t<option value=\"{$val}\" selected=\"selected\">{$key}</option>\n";
        } else {
            $html .= "\t<option value=\"{$val}\">{$key}</option>\n";
        }
    }
    $html .= "</select>\n";
    return $html;
}

//生成form:radio
function build_radio(string $name, $options, $selected = ''): string
{
    $options = is_array($options) ? $options : explode(',', $options);
    $html = '';
    foreach ($options as $val => $key) {
        if ($selected == $val) {
            $html .= "<input type=\"radio\" name=\"{$name}\" value=\"{$val}\" title=\"{$key}\" checked=\"checked\" />\n";
        } else {
            $html .= "<input type=\"radio\" name=\"{$name}\" value=\"{$val}\" title=\"{$key}\" />\n";
        }
    }
    return $html;
}

//生成列字段模板
function build_templet(string $field, array $options): string
{
    $str = "<script type=\"text/html\" id=\"{$field}\">\n\t{{ ";
    foreach ($options as $k => $v) {
        $str .= 'd.' . $field . ' == ' . $k . ' ? \'' . $v . '\' : ';
    }
    return $str . " '' }}\n</script>\n";
}

//获取头像
function get_avatar(string $avatar = ''): string
{
    return !empty($avatar) ? trim($avatar, '.') : __STATIC__.'/admin/images/avatar.png';
}

//获取头像
function get_image(string $image = ''): string
{
    return !empty($image) ? trim($image, '.') : __STATIC__.'/admin/images/box.png';
}

function opt_photo(string $field): string
{
    $field .= '-opt';
    return '&nbsp;<button class="pear-btn pear-btn-primary pear-btn-sm" id="'.$field.'" type="button">图库选择</button><script>layui.use(["jquery"],function(){let $=layui.jquery;function screen(width,height){if(typeof width!==\'number\'||width===0){width=$(window).width()*0.8}if(typeof height!==\'number\'||height===0){height=$(window).height()-20}return[width+\'px\',height+\'px\']}$("#'.$field.'").on("click",function(){layer.open({type:2,maxmin:true,title:"图库选择",shade:0.1,area:screen(),content:"'.url('image/list').'",success:function(layero,index){let iframe=window["layui-layer-iframe"+index];iframe.child("'.$field.'")}})})})</script>';
}