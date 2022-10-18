<?php

namespace Home\Controller;

use Think\Controller;

class CommentReportController extends BaseController
{

    /**
     *举报树洞信息
     */
    public function new_comment_report()
    {
        /**校验m_id、u_id1、u_id2、mr_content是否传入**/
        if (!$_POST['c_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:c_id';

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

        if (!$_POST['cr_content']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:cr_content';

            $this->ajaxReturn($return_data);
        }

        $Comment_report = M('Comment_report');
        $Comment = M('Comment');
        $User = M('User');

        $where1 = array();
        $where1['u_id1'] = $_POST['u_id1'];
        $user1 = $User->where($where1)->find();

        $where2 = array();
        $where2['u_id2'] = $_POST['u_id2'];
        $user2 = $User->where($where2)->find();

        $where3 = array();
        $where3['c_id'] = $_POST['c_id'];
        $comment = $Comment->where($where3)->find();

        $data = array();

        $data['c_id'] = $_POST['c_id'];                 //被举报的评论id
        $data['u_id1'] = $_POST['u_id1'];               //举报人的id
        $data['u_id2'] = $_POST['u_id2'];               //被举报人的id
        $data['username1'] = $user1['username'];
        $data['username2'] = $user2['username'];
        $data['face_url'] = $user2['face_url'];         //被举报者的头像
        $data['c_content'] = $comment['c_content'];     //被举报的评论消息
        $data['cr_content'] = $_POST['cr_content'];     //举报说明
        $data['cr_time'] = date('Y-m-d H:i:s', time());//发布时间

        $result = $Comment_report->add($data);

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
     *获取所有被举报的评论的举报信息
     */
    public function get_all_comment_report()
    {
        $Comment_report = M('Comment_report');
        $all_comment_report = $Comment_report->order('cr_id desc')->select();
        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '数据获取成功';
        for ($i = 0; $i < count($all_comment_report); $i++) {
            $User = M('User');
            $Comment = M('Comment');
            $where1 = array();
            $where1['u_id'] = $all_comment_report[$i]['u_id1'];
            $user1 = $User->where($where1)->find();

            $where2 = array();
            $where2['u_id'] = $all_comment_report[$i]['u_id2'];
            $user2 = $User->where($where2)->find();

            $where3 = array();
            $where3['c_id'] = $all_comment_report[$i]['c_id'];
            $comment = $Comment->where($where3)->find();

            $return_data['data'][$i]['cr_id'] = $all_comment_report[$i]['cr_id'];
            $return_data['data'][$i]['c_id'] = $all_comment_report[$i]['c_id'];
            $return_data['data'][$i]['u_id1'] = $all_comment_report[$i]['u_id1'];
            $return_data['data'][$i]['u_id2'] = $all_comment_report[$i]['u_id2'];
            $return_data['data'][$i]['username1'] = $user1['username'];
            $return_data['data'][$i]['username2'] = $user2['username'];
            $return_data['data'][$i]['face_url'] = $user2['face_url'];
            $return_data['data'][$i]['c_content'] = $comment['c_content'];
            $return_data['data'][$i]['cr_content'] = $all_comment_report[$i]['cr_content'];
            $return_data['data'][$i]['cr_time'] = $all_comment_report[$i]['cr_time'];
        }


        $this->ajaxReturn($return_data);
    }

}

