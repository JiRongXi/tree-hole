<?php

namespace Home\Controller;

use Think\Controller;

class UserController extends BaseController
{

    //用户注册
    public function sign()
    {
        if (!$_POST['username']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:username';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['phone']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:phone';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['password']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:password';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['password_again']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:password_again';

            $this->ajaxReturn($return_data);
        }

        if ($_POST['password'] != $_POST['password_again']) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '两次密码不一致';

            $this->ajaxReturn($return_data);
        }

        /*检验手机号和用户名是否被注册*/
        $where = array();
        $where['phone'] = $_POST['phone'];
        $where2['username'] = $_POST['username'];
        $User = M('User');

        $user = $User->where($where)->find();
        $user2 = $User->where($where2)->find();

        if ($user) {
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '该手机号已被注册';

            $this->ajaxReturn($return_data);
        } elseif ($user2) {
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '该用户名重复请重新输入';

            $this->ajaxReturn($return_data);
        } else {
            $data = array();
            $data['username'] = $_POST['username'];
            $data['phone'] = $_POST['phone'];
            $data['password'] = md5($_POST['password']);
            $data['face_url'] = 'https://img2.baidu.com/it/u=395719964,2145680590&fm=26&fmt=auto';

            $result = $User->add($data);

            if ($result) {
                //插入数据成功
                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '注册成功';
                $return_data['data']['u_id'] = $result;
                $return_data['data']['username'] = $_POST['username'];
                $return_data['data']['phone'] = $_POST['phone'];
                if ($_POST['face_url'])
                    $return_data['data']['face_url'] = $_POST['face_url'];
                else
                    $return_data['data']['face_url'] = $data['face_url'];
                $this->ajaxReturn($return_data);
            } else {
                $return_data = array();
                $return_data['error_code'] = 4;
                $return_data['msg'] = '注册失败';

                $this->ajaxReturn($return_data);
            }
        }


    }

    // 用户登录
    public function login()
    {
        if (!$_POST['phone']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:phone';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['password']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:password';

            $this->ajaxReturn($return_data);
        }

        //查询用户
        $User = M('User');
        $where = array();
        $where['phone'] = $_POST['phone'];
        $user = $User->where($where)->find();

        if ($user) {
            //查询到该用户
            if (md5($_POST['password']) != $user['password']) {
                //密码不一致
                $return_data = array();
                $return_data['error_code'] = 2;
                $return_data['msg'] = '密码错误，请重新输入';

                $this->ajaxReturn($return_data);
            } else {
                //密码一致
                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '登录成功';
                $return_data['data']['u_id'] = $user['u_id'];
                $return_data['data']['username'] = $user['username'];
                $return_data['data']['phone'] = $user['phone'];
                $return_data['data']['face_url'] = $user['face_url'];

                $this->ajaxReturn($return_data);
            }
        } else {
            //查询不到用户
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '不存在该手机号用户，请注册或重新输入';

            $this->ajaxReturn($return_data);
        }
    }

    // 更改用户名
    public function changUsername()
    {
        if (!$_POST['u_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:u_id';

            $this->ajaxReturn($return_data);
        } elseif (!$_POST['username']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:username';

            $this->ajaxReturn($return_data);
        }

        //查找
        $User = M('User');
        $Message = M('Message');
        $Comment = M('Comment');
        $where = array();
        $where['u_id'] = $_POST['u_id'];

        $user = $User->where($where)->find();
        $message = $Message->where($where)->find();

        //查看是否有重名用户
        $where2 = array();
        $where2['username'] = $_POST['username'];
        $findUsername = $User->where($where2)->find();

        $data = array();
        $data['username'] = $_POST['username'];

        //查询到user
        if ($user) {
            if ($findUsername) {
                $return_data = array();
                $return_data['error_code'] = 4;
                $return_data['msg'] = '该用户名重复请重新输入';

                $this->ajaxReturn($return_data);
            } else {//保存
                $result = $User->where($where)->save($data);
                $result = $Message->where($where)->save($data);
                $result = $Comment->where($where)->save($data);
                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '更改用户名成功';
                $return_data['data']['u_id'] = $_POST['u_id'];
                $return_data['data']['username'] = $_POST['username'];
                $this->ajaxReturn($return_data);
            }

        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '查询不到制定数据';

            $this->ajaxReturn($return_data);
        }
    }

    // 更改头像
    public function changeFace_url()
    {
        if (!$_POST['u_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:u_id';

            $this->ajaxReturn($return_data);
        } elseif (!$_POST['face_url']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:face_url';

            $this->ajaxReturn($return_data);
        }

        //查找
        $User = M('User');
        $Message = M('Message');
        $Comment = M('Comment');

        $where = array();
        $where['u_id'] = $_POST['u_id'];

        $user = $User->where($where)->find();

        $data = array();
        $data['face_url'] = $_POST['face_url'];

        //查询到user
        if ($user) {
            //保存
            $result = $User->where($where)->save($data);
            $result = $Message->where($where)->save($data);
            $result = $Comment->where($where)->save($data);
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '更改头像成功';
            $return_data['data']['u_id'] = $_POST['u_id'];
            $return_data['data']['face_url'] = $_POST['face_url'];
            $this->ajaxReturn($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '查询不到制定数据';

            $this->ajaxReturn($return_data);
        }

    }
}