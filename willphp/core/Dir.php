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

namespace willphp\core;

use Exception;

class Dir
{
    public static function create(string $dir, int $auth = 0755): bool
    {
        return !empty($dir) && (is_dir($dir) or mkdir($dir, $auth, true));
    }

    public static function del(string $dir, bool $delRoot = false): bool
    {
        if (!is_dir($dir)) return true;
        $list = array_diff(scandir($dir), ['.', '..']);
        foreach ($list as $file) {
            is_dir("$dir/$file") ? self::del("$dir/$file", true) : unlink("$dir/$file");
        }
        return !$delRoot || rmdir($dir);
    }

    public static function removeRoot(string $path, string $root = ROOT_PATH): string
    {
        return substr($path, strlen($root) + 1);
    }

    public static function make(string $dir, int $auth = 0755): string
    {
        if (!self::create($dir, $auth)) {
            $dir = self::removeRoot($dir);
            throw new Exception($dir . ' 目录创建失败或不可写');
        }
        return $dir;
    }

    public static function getFiles(array $dirs, string $ext = '.php'): array
    {
        $files = [];
        foreach ($dirs as $dir) {
            if (is_file($dir)) {
                $files[] = $dir;
            } elseif (is_dir($dir)) {
                $files = array_merge($files, glob($dir.'/*'.$ext));
            }
        }
        return $files;
    }

    public static function getMtime(array $files): int
    {
        if (!empty($files)) {
            $mtime = array_map(fn(string $file)=>filemtime($file), $files);
            return max($mtime);
        }
        return 0;
    }

    public static function sizeFormat(int $size): string
    {
        $unitByte = [' TB' => 1099511627776, ' GB' => 1073741824, ' MB' => 1048576];
        foreach ($unitByte as $unit => $byte) {
            if ($size >= $byte) {
                return round($size / $byte, 2) . $unit;
            }
        }
        return number_format($size / 1024, 2) . ' KB';
    }
}