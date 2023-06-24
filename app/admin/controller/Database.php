<?php
declare(strict_types=1);
namespace app\admin\controller;
use willphp\core\Dir;
use willphp\core\Jump;
class Database
{
    use Jump;

    protected string $dbName;
    protected string $dbPrefix;
    protected string $backPath;

    public function __construct()
    {
        $this->dbName = config('database.default.db_name');
        $this->dbPrefix = config('database.default.db_prefix');
        $this->backPath = ROOT_PATH . '/backup';
    }

    public function index()
    {
        if ($this->isAjax()) {
            $list = db()->getResult('SHOW TABLE STATUS');
            foreach ($list as &$vo) {
                $vo['Data_length'] = size_format($vo['Data_length']);
                $vo['Update_time'] ??= $vo['Create_time'];
            }
            $this->_json(200, '', $list, ['count' => count($list)]);
        }
        return view();
    }

    //表结构
    public function structure()
    {
        $table = input('get.table', '', 'clear_html');
        if (empty($table)) {
            $this->error('表名不能为空');
        }
        $vo = db()->getResult('SHOW CREATE TABLE ' . $table);
        return ['status' => 1, 'table' => $vo[0]['Table'], 'data' => $vo[0]['Create Table']];
    }

    //优化表
    public function optimize()
    {
        $tables = input('get.ids', '', 'clear_html');
        if (empty($tables)) {
            $this->error('请选择表');
        }
        $tables = is_array($tables) ? implode(',', $tables) : $tables;
        db()->execute('OPTIMIZE TABLE ' . $tables);
        $this->success('成功优化表：' . $tables, 'index');
    }

    //修复表
    public function repair()
    {
        $tables = input('get.ids', '', 'clear_html');
        if (empty($tables)) {
            $this->error('请选择表');
        }
        $tables = is_array($tables) ? implode(',', $tables) : $tables;
        db()->execute('REPAIR TABLE ' . $tables);
        $this->success('成功修复表：' . $tables, 'index');
    }

    public function restore() {
        if ($this->isAjax()) {
            $list = $this->getBakList();
            krsort($list); //排序
            $this->_json(200, '', $list, ['count' => count($list)]);
        }
        return view();
    }

    //删除备份
    public function del() {
        $path = input('path', '', 'clear_html');
        if (empty($path)) {
            $this->error('请选择备份');
        }
        $r = Dir::del($this->backPath.'/'.$path, true);
        $this->_jump(['删除成功','删除失败'], $r, 'restore');
    }

    //下载备份
    public function down() {
        $path = input('path', '', 'clear_html');
        if (empty($path)) {
            $this->error('请选择备份');
        }
        if (!is_dir($this->backPath.'/'.$path)) {
            $this->error('备份不存在');
        }
        $zipFile = $this->backPath.'/'.$path.'.zip'; //备份文件.zip
        if(file_exists($zipFile)){
            unlink($zipFile);
        }
        $glob = @glob($this->backPath.'/'.$path.'/*.sql');
        $zip = new \ZipArchive();
        $res = $zip->open($zipFile, \ZipArchive::CREATE);
        if ($res === true) {
            foreach ($glob as $file) {
                $new_filename = substr($file, strrpos($file, '/') + 1);
                $zip->addFile($file, $new_filename);
            }
            $zip->close();
            if (file_exists($zipFile)) {
                //header("Content-type:application/octet-stream");
                header('Content-Type: application/zip');
                header('Content-Disposition:attachment;filename='.$path.'.zip');
                header('Content-Length:'.filesize($zipFile));
                //header("Accept-ranges:bytes");
                //header("Accept-length:".filesize($zipfile));
                @readfile($zipFile);
                @unlink($zipFile);
            } else {
                $this->error('备份文件不存在');
            }
        } else {
            $this->error('不支持ZipArchive');
        }
    }

    //备份列表
    public function restore_data()
    {
        $path = input('path', '', 'clear_html');
        if (empty($path)) {
            $this->error('请选择备份');
        }
        if (!is_dir($this->backPath.'/'.$path)) {
            $this->error('备份不存在');
        }
        $glob = @glob($this->backPath.'/'.$path.'/*.sql');
        sort($glob);
        foreach ($glob as $file) {
            $this->parse_sql_file($file);
        }
        $this->success('数据已还原', 'restore');
    }
    private function parse_sql_file(string $file) {
        $data = file_get_contents($file);
        $data = mb_convert_encoding($data, 'UTF-8', 'auto');
        $sqlList = explode('-- <fen> --', $data);
        if (count($sqlList) > 1) array_pop($sqlList);
        foreach ($sqlList as $sql) {
            db()->execute($sql);
        }
        usleep(100000);
    }
    //获取备份列表
    private function getBakList(): array
    {
        $list = [];
        if (is_dir($this->backPath)) {
            $open = opendir($this->backPath);
            if ($open) {
                $i = 1;
                while (false !== ($name = readdir($open))) {
                    if ($name == '.' || $name == '..') {
                        continue;
                    }
                    $t = filectime($this->backPath.'/'.$name);
                    $list[$t]['name'] = date('Ymd', $t).'-'.$i;
                    $list[$t]['path'] = $name;
                    $list[$t]['time'] = $t;
                    $i ++;
                }
                closedir($open);
            }
        }
        return $list;
    }

    //备份操作
    public function backup()
    {
        function_exists('set_time_limit') && set_time_limit(0);
        $tables = input('post.ids', '', 'clear_html');
        if (empty($tables)) {
            $tables = $this->getAllTable();
            $bakType = 'all';
        } else {
            $tables = explode(',', $tables);
            $bakType = 't' . count($tables) . '-' . ltrim($tables[0], $this->dbPrefix);
        }
        $bakPath = $this->backPath . '/bak-' . $bakType . '-' . date('YmdHis') . '-' . rand(1000, 9999);
        if (!is_dir($bakPath)) {
            mkdir($bakPath, 0777, true);
        }
        $lock = $this->backPath . '/backup.lock';
        $nowTime = time();
        if (is_file($lock)) {
            if (($nowTime - filemtime($lock)) < 600) {
                $this->error('检测到有一个备份任务正在执行，请稍后再试！');
            }
            @unlink($lock);
        }
        $ok_bytes = file_put_contents($lock, $nowTime); //创建锁文件
        if (!$ok_bytes) {
            $this->error('backup目录不存在或不可写，请检查！');
        }
        $error = '';
        $this->sql_drop_tables($tables, $bakPath, $error); //删除所有表SQL
        $this->sql_create_tables($tables, $bakPath, $error); //重建所有表SQL
        $this->sql_data_tables($tables, $bakPath, $error); //插入表数据SQL
        if (!empty($error)) {
            $this->error($error);
        }
        if (file_exists($lock)) @unlink($lock);
        $this->_jump('备份成功！', 1, 'restore');
    }

    //获取全部表名
    private function getAllTable(): array
    {
        $db_name = $this->dbName;
        $list = db()->getResult("SHOW TABLES FROM `$db_name`");
        $tables = [];
        foreach ($list as $vo) {
            $tables[] = $vo['Tables_in_' . $db_name];
        }
        return $tables;
    }

    //生成删除表sql
    private function sql_drop_tables(array $tables, string $bakPath, string &$error)
    {
        $data = '';
        foreach ($tables as $table) {
            $data .= "-- 清空表的: $table --\r\nDROP TABLE IF EXISTS `$table`;\r\n-- <fen> --\r\n";
        }
        $ok_bytes = file_put_contents($bakPath . '/a_drop_tables.sql', $data);
        if ($ok_bytes <= 0) {
            $error .= 'a_drop_tables.sql 写入错误！';
        }
    }

    //重建所有表sql
    private function sql_create_tables(array $tables, string $bakPath, string &$error)
    {
        $data = '';
        foreach ($tables as $table) {
            $sql = "SHOW CREATE TABLE `$table`";
            $res = db()->getResult($sql);
            $data .= "-- 表的结构: $table --\r\n" . $res[0]['Create Table'] . ";\r\n-- <fen> --\r\n";
        }
        $data = mb_convert_encoding($data, 'UTF-8', 'auto');
        $ok_bytes = file_put_contents($bakPath . '/create_tables.sql', $data);
        if ($ok_bytes <= 0) {
            $error .= 'create_tables.sql 写入错误！';
        }
    }

    //插入所有表记录
    private function sql_data_tables(array $tables, string $bakPath, string &$error)
    {
        foreach ($tables as $table) {
            $model = ltrim($table, $this->dbPrefix);
            $count = db($model)->count();
            if ($count > 0) {
                $pageSize = 1000; //每页显示1000条
                $totalPage = ceil($count / $pageSize); //总页数
                $p = 1;
                while ($p <= $totalPage) {
                    $data = "-- 表的数据: {$table}({$p}/{$totalPage}) 每页: {$pageSize} --\r\n";
                    $start = $pageSize * ($p - 1);
                    $list = db($model)->limit($start . ',' . $pageSize)->select();
                    $sql = '';
                    foreach ($list as $vo) {
                        $sql .= db($model)->getSql()->insert($vo);
                        $sql .= ";-- <fen> --\r\n";
                    }
                    $data .= $sql;
                    $ok_bytes = file_put_contents($bakPath . '/insert_' . $table . '_p' . $p . '.sql', $data);
                    if ($ok_bytes <= 0) {
                        $error .= 'insert_' . $table . '_p' . $p . '.sql 写入错误！';
                    }
                    $p++;
                }
                usleep(50000);
            }
            usleep(100000);
        }
    }
}