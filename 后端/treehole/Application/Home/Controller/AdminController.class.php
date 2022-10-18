<?php

namespace Home\Controller;

use Think\Controller;

class AdminController extends BaseController
{

    /**
     *获取所有用户信息
     */
    public function get_all_user()
    {
        $User = M('User');
        $all_user = $User->order('u_id asc')->select();
        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '数据获取成功';
        $return_data['data'] = $all_user;

        $this->ajaxReturn($return_data);
    }

    /**
     *删除用户所有信息
     */
    public function delete_user()
    {
        if (!$_POST['u_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:u_id';

            $this->ajaxReturn($return_data);
        } else {
            //查询消息
            $User = M('User');
            $Message = M('Message');
            $Comment = M('Comment');
            $Message_report = M('Message_report');
            $Comment_report = M('Comment_report');

            $where1 = array();
            $where1['u_id'] = $_POST['u_id'];

            $where2 = array();
            $where2['u_id'] = $_POST['u_id'];

            $where3 = array();
            $where3['u_id'] = $_POST['u_id'];

            $where4 = array();
            $where4['u_id2'] = $_POST['u_id'];

            $where5 = array();
            $where5['u_id2'] = $_POST['u_id'];

            //删除用户信息
            $result = $User->where($where1)->delete();
            //删除对应的树洞消息
            $result = $Message->where($where2)->delete();
            //删除对应的评论消息
            $result = $Comment->where($where3)->delete();
            //删除对应的树洞举报消息
            $result = $Message_report->where($where4)->delete();
            //删除对应的评论举报消息
            $result = $Comment_report->where($where5)->delete();


            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '数据删除成功';
            $return_data['m_id'] = $_POST['m_id'];

            $this->ajaxReturn($return_data);

        }
    }

    /**
     *获取树洞数据
     **/
    public function get_all_data()
    {
        $User = M('User');
        $Message = M('Message');
        $Comment = M('Comment');
        $Message_report = M('Message_report');
        $Comment_report = M('Comment_report');

        $all_user = $User->select();
        $all_message = $Message->select();
        $all_comment = $Comment->select();
        $all_message_report = $Message_report->select();
        $all_comment_report = $Comment_report->select();

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '数据删除成功';
        $return_data['data']['user_num'] = count($all_user);
        $return_data['data']['message_num'] = count($all_message);
        $return_data['data']['comment_num'] = count($all_comment);
        $return_data['data']['message_report_num'] = count($all_message_report);
        $return_data['data']['comment_report_num'] = count($all_comment_report);
        $this->ajaxReturn($return_data);
    }
}

