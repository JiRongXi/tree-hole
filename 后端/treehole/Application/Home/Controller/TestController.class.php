<?php

namespace Home\Controller;

use Think\Controller;

class TestController extends BaseController
{
    public function test()
    {
        echo 123;
    }

    public function test1()
    {
        /*添加数据*/
        $User = M('User');

        $data = array();
        $data['u_id'] = 1;
        $data['username'] = '大大';
        $data['phone'] = '13411945033';
        $data['password'] = '123456';
        $data['face_url'] = 'xxx.jpg';

        $result = $User->add($data);

        var_dump($result);
    }

    public function test2()
    {
        /*查询数据*/
        $User = M('User');
        $where = array();
        $where['u_id'] = 1;

        $user = $User->where($where)->select();
        var_dump($user);
        dump($user);
    }

    public function test3()
    {
        /*修改保存数据*/
        $User = M('User');

        $where = array();
        $where['u_id'] = '1';

        $data = array();
        $data['username'] = '硕大的';

        $result = $User->where($where)->save($data);

        dump($result);
    }

    public function test4()
    {
        /*删除数据*/
        $User = M('User');

        $where = array();
        $where['u_id'] = '1';

        $result = $User->where($where)->delete();

        dump($result);
    }
}

