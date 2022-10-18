<?php

namespace Home\Controller;

use Think\Controller;

class MessageReportController extends BaseController
{
    /**
     *举报树洞信息
     */
    public function new_messages_report()
    {
        /**校验m_id、u_id1、u_id2、mr_content是否传入**/
        if (!$_POST['m_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:m_id';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['u_id1']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:u_id1';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['u_id2']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:u_id2';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['mr_content']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:mr_content';

            $this->ajaxReturn($return_data);
        }

        $Message_report = M('Message_report');
        $Message = M('Message');
        $User = M('User');

        $where1 = array();
        $where1['u_id1'] = $_POST['u_id1'];
        $user1 = $User->where($where1)->find();

        $where2 = array();
        $where2['u_id2'] = $_POST['u_id2'];
        $user2 = $User->where($where2)->find();

        $where3 = array();
        $where3['m_id'] = $_POST['m_id'];
        $message = $Message->where($where3)->find();

        $data = array();

        $data['m_id'] = $_POST['m_id'];                 //被举报的树洞消息的id
        $data['u_id1'] = $_POST['u_id1'];               //举报人的id
        $data['u_id2'] = $_POST['u_id2'];               //被举报人的id
        $data['username1'] = $user1['username'];
        $data['username2'] = $user2['username'];
        $data['face_url'] = $user2['face_url'];         //被举报者的头像
        $data['m_content'] = $message['m_content'];     //被举报的树洞消息
        $data['mr_content'] = $_POST['mr_content'];     //举报说明
        $data['mr_time'] = date('Y-m-d H:i:s', time());//发布时间

        $result = $Message_report->add($data);

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

    /**
     *获取所有被举报的树洞的举报信息
     */
    public function get_all_message_report()
    {
        $Message_report = M('Message_report');
        $all_message_report = $Message_report->order('mr_id desc')->select();
        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '数据获取成功';
//        dump($all_message);
        for ($i = 0; $i < count($all_message_report); $i++) {
            $User = M('User');
            $Message = M('Message');
            $where1 = array();
            $where1['u_id'] = $all_message_report[$i]['u_id1'];
            $user1 = $User->where($where1)->find();

            $where2 = array();
            $where2['u_id'] = $all_message_report[$i]['u_id2'];
            $user2 = $User->where($where1)->find();

            $where3 = array();
            $where3['m_id'] = $all_message_report[$i]['m_id'];
            $message = $Message->where($where3)->find();

            $return_data['data'][$i]['mr_id'] = $all_message_report[$i]['mr_id'];
            $return_data['data'][$i]['m_id'] = $all_message_report[$i]['m_id'];
            $return_data['data'][$i]['u_id1'] = $all_message_report[$i]['u_id'];
            $return_data['data'][$i]['u_id2'] = $all_message_report[$i]['u_id'];
            $return_data['data'][$i]['username1'] = $user1['username'];
            $return_data['data'][$i]['username2'] = $user2['username'];
            $return_data['data'][$i]['face_url'] = $user2['face_url'];
            $return_data['data'][$i]['m_content'] = $message['m_content'];
            $return_data['data'][$i]['mr_content'] = $all_message_report[$i]['mr_content'];
            $return_data['data'][$i]['mr_time'] = $all_message_report[$i]['mr_time'];
        }


        $this->ajaxReturn($return_data);
    }

}
