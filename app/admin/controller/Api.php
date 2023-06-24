<?php
declare(strict_types=1);
namespace app\admin\controller;
use willphp\core\Jump;
use willphp\core\Upload;
class Api
{
	use Jump;
    protected string $middleware = 'auth';

    //清除所有缓存
	public function clear()
	{
		cache_flush('[all]');
		$this->success('清除缓存成功', 'index/index');
	}

    //编辑器，单图上传
    public function upload_image()
    {
        $res = Upload::init('img')->save();
        if (!isset($res[0]['path'])) {
            $this->error('上传失败');
        }
        $res[0]['image_id'] = $this->image_insert($res[0]);
        $this->_json(200, '上传成功', $res[0]);
    }

    public function image_del() {
        $pic = input('post.pic', '', 'clear_html');
        $filename = trim($pic, '.');
        db('image')->where('path', $filename)->delete();
        $file = ROOT_PATH.'/public'.$filename;
        if (file_exists($file)) {
            unlink($file);
        }
        $this->success('删除成功');
    }

    //图片上传存入数据库表
    protected function image_insert(array $img)
    {
        $data = [];
        $user = session('user');
        $data['admin_id'] = $user['id'];
        $data['username'] = $user['username'];
        $data['filename'] = basename($img['path']);
        $data['href'] = $img['url'];
        $data['path'] = $img['path'];
        $data['mime'] = $img['type'];
        $data['ext'] = $img['ext'];
        $data['filesize'] = $img['size'];
        $data['create_time'] = $img['uptime'];
        $data['status'] = 1;
        return db('image')->insertGetId($data);
    }

    //图片base64上传，头像上传
    public function upload_base64()
    {
        $type = input('post.type', '', 'clear_html');
        $base64 = input('post.base64');
        $uid = session('user.id');
        $res = Upload::init('avatar')->saveBase64($base64, 'uid_'.$uid);
        if (!$res['path']) {
            $this->error('上传失败');
        }
        if ($type == 'avatar') {
            db('admin')->where('id', $uid)->setField('avatar', $res['path']);
        }
        $this->_json(200, '上传成功', ['path' => $res['path']]);
    }
}