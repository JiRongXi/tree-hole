<?php

namespace Home\Controller;

use Think\Controller;

class MessageController extends BaseController
{
    //发布新树洞
    public function publish_new_message()
    {
        /**校验u_id、m_content是否传入**/
        if (!$_POST['u_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:u_id';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['m_content']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:m_content';

            $this->ajaxReturn($return_data);
        }

        $Message = M('Message');
        $User = M('User');

        $where = array();
        $where['u_id'] = $_POST['u_id'];
        $user = $User->where($where)->find();
        $data = array();

        $data['u_id'] = $_POST['u_id'];
        $data['username'] = $user['username'];
        $data['face_url'] = $user['face_url'];
        $data['m_content'] = $_POST['m_content'];   //树洞消息
        $data['send_time'] = date('Y-m-d H:i:s', time());//发布时间

        $result = $Message->add($data);

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '数据添加成功';

            $this->ajaxReturn($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '数据添加失败';

            $this->ajaxReturn($return_data);
        }

    }

    //获取所有树洞消息
    public function get_all_messages()
    {
        $Message = M('Message');
        $all_message = $Message->order('m_id desc')->select();
        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '数据获取成功';
//        dump($all_message);
//        for ($i = 0; $i < count($all_message); $i++) {
//            $User = M('User');
//            $where = array();
//            $where['u_id'] = $all_message[$i]['u_id'];
//            $user = $User->where($where)->find();
//
//            $return_data['data'][$i]['m_id'] = $all_message[$i]['m_id'];
//            $return_data['data'][$i]['u_id'] = $all_message[$i]['u_id'];
//            $return_data['data'][$i]['username'] = $user['username'];
//            $return_data['data'][$i]['face_url'] = $user['face_url'];
//            $return_data['data'][$i]['m_content'] = $all_message[$i]['m_content'];
//            $return_data['data'][$i]['likes'] = $all_message[$i]['likes'];
//            $return_data['data'][$i]['send_time'] = $all_message[$i]['send_time'];
//        }
        $return_data['data'] = $all_message;

        $this->ajaxReturn($return_data);
    }

    //获取个人树洞消息
    public function get_one_user_all_messages()
    {
        if (!$_POST['u_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:u_id';

            $this->ajaxReturn($return_data);
        } else {
            $Message = M('Message');

            $where = array();
            $where['u_id'] = $_POST['u_id'];
            $one_user_all_message = $Message->where($where)->order('m_id desc')->select();

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '数据获取成功';
            $return_data['data'] = $one_user_all_message;

            $this->ajaxReturn($return_data);

        }
    }

    //点赞
    public function do_likes()
    {
        if (!$_POST['m_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:m_id';

            $this->ajaxReturn($return_data);
        } else if (!$_POST['username']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:username';

            $this->ajaxReturn($return_data);
        }
        $Message = M('Message');

        $where = array();
        $where['m_id'] = $_POST['m_id'];

        $message = $Message->where($where)->find();

        if ($_POST['m_id'] != $message['m_id']) {
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '查询不到该条树洞';

            $this->ajaxReturn($return_data);
        } else {
            //查询消息
            $message['likes']++;
            $result = $Message->where($where)->save($message);

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '点赞成功';
            $return_data['m_id'] = $_POST['m_id'];
            $return_data['likes'] = $message['likes'];

            $this->ajaxReturn($return_data);
        }
    }

    //取消点赞
    public function donot_likes()
    {
        if (!$_POST['m_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:m_id';

            $this->ajaxReturn($return_data);
        } else if (!$_POST['username']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:username';

            $this->ajaxReturn($return_data);
        }
        $Message = M('Message');

        $where = array();
        $where['m_id'] = $_POST['m_id'];

        $message = $Message->where($where)->find();

        if ($_POST['m_id'] != $message['m_id']) {
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '查询不到该条树洞';

            $this->ajaxReturn($return_data);
        } else {
            //查询消息
            $message['likes']--;
            $result = $Message->where($where)->save($message);

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '消赞成功';
            $return_data['m_id'] = $_POST['m_id'];
            $return_data['likes'] = $message['likes'];

            $this->ajaxReturn($return_data);
        }
    }

    //删除树洞消息
    public function delete_message()
    {
        if (!$_POST['m_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:m_id';

            $this->ajaxReturn($return_data);
        } else {
            //查询消息
            $Message = M('Message');
            $Comment = M('Comment');
            $Message_report = M('Message_report');
            $Comment_report = M('Comment_report');

            $where1 = array();
            $where1['m_id'] = $_POST['m_id'];

            $where2 = array();
            $where2['m_id'] = $_POST['m_id'];

            $where3 = array();
            $where3['m_id'] = $_POST['m_id'];


            $comment = $Comment->where($where2)->find();
            $where4 = array();
            $where4['c_id'] = $comment['c_id'];

            //删除对应的树洞消息4231
            $result = $Message->where($where1)->delete();
            //删除对应的评论消息
            $result = $Comment->where($where2)->delete();
            //删除对应的树洞举报消息
            $result = $Message_report->where($where3)->delete();
            //删除对应的评论举报消息
            $result = $Comment_report->where($where4)->delete();

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '数据删除成功';
            $return_data['m_id'] = $_POST['m_id'];

            $this->ajaxReturn($return_data);

        }
    }

    //查找树洞消息
    public function select_message()
    {
        $Message = M('Message');
        $m_content = $_POST['m_content'];
        $where['m_content'] = array('like', '%' . $m_content . '%');

        $message = $Message->where($where)->order('m_id desc')->select();

        $return_data['data'] = $message;
        $this->ajaxReturn($return_data);

    }
}