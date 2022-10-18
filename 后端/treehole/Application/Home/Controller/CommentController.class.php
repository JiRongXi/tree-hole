<?php

namespace Home\Controller;

use Think\Controller;

class CommentController extends BaseController
{
    /**
     *发布评论
     */
    public function new_comment()
    {
        /**校验u_id、m_id、c_content是否传入**/
        if (!$_POST['u_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:u_id';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['m_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:m_id';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['c_content']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:c_content';

            $this->ajaxReturn($return_data);
        }


        $User = M('User');
        $Comment = M('Comment');

        $where = array();
        $where['u_id'] = $_POST['u_id'];
        $user = $User->where($where)->find();
        $data = array();

        $data['m_id'] = $_POST['m_id'];
        $data['u_id'] = $_POST['u_id'];
        $data['username'] = $user['username'];
        $data['face_url'] = $user['face_url'];
        $data['c_content'] = $_POST['c_content'];
        $data['audit_time'] = date('Y-m-d H:i:s', time());//发布时间

        $result = $Comment->add($data);

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
     *获取所有评论
     */
    public function get_all_comments()
    {
        $Comment = M('Comment');
        $all_comment = $Comment->order('c_id')->select();

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '数据获取成功';
        $return_data['data'] = $all_comment;

        $this->ajaxReturn($return_data);
    }

    /**
     *点赞
     */
    public function do_likes()
    {
        if (!$_POST['c_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:c_id';

            $this->ajaxReturn($return_data);
        } else if (!$_POST['username']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:username';

            $this->ajaxReturn($return_data);
        }
        $Comment = M('Comment');

        $where = array();
        $where['c_id'] = $_POST['c_id'];

        $comment = $Comment->where($where)->find();

        if ($_POST['c_id'] != $comment['c_id']) {
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '查询不到该条评论';

            $this->ajaxReturn($return_data);
        } else {
            //查询消息
            $comment['likes']++;
            $result = $Comment->where($where)->save($comment);

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '点赞成功';
            $return_data['c_id'] = $_POST['c_id'];
            $return_data['likes'] = $comment['likes'];

            $this->ajaxReturn($return_data);
        }
    }


    /**
     *取消点赞
     */
    public function donot_likes()
    {
        if (!$_POST['c_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:c_id';

            $this->ajaxReturn($return_data);
        } else if (!$_POST['username']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:username';

            $this->ajaxReturn($return_data);
        }
        $Comment = M('Comment');

        $where = array();
        $where['c_id'] = $_POST['c_id'];

        $comment = $Comment->where($where)->find();

        if ($_POST['c_id'] != $comment['c_id']) {
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '查询不到该条评论';

            $this->ajaxReturn($return_data);
        } else {
            //查询消息
            $comment['likes']--;
            $result = $Comment->where($where)->save($comment);

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '消赞成功';
            $return_data['c_id'] = $_POST['c_id'];
            $return_data['likes'] = $comment['likes'];

            $this->ajaxReturn($return_data);
        }
    }


    /**
     *删除树洞消息
     */
    public function delete_comment()
    {
        if (!$_POST['c_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:c_id';

            $this->ajaxReturn($return_data);
        } else {
            //查询消息
            $Comment = M('Comment');
            $Comment_report = M('Comment_report');

            $where1 = array();
            $where1['c_id'] = $_POST['c_id'];

            $where2 = array();
            $where2['c_id'] = $_POST['c_id'];

            $comment = $Comment->where($where1)->find();

            //删除该评论消息对应的举报消息
            $result = $Comment_report->where($where2)->delete();
            //删除该评论消息
            $result = $Comment->where($where1)->delete();
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '数据删除成功';
            $return_data['c_id'] = $_POST['c_id'];

            $this->ajaxReturn($return_data);
        }
    }

    /**
     *获取一条树洞消息的评论
     */
    public function get_one_message_all_comments()
    {
        if (!$_POST['m_id']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足:m_id';

            $this->ajaxReturn($return_data);
        } else {
            $Comment = M('Comment');

            $where = array();
            $where['m_id'] = $_POST['m_id'];

            $one_message_all_comments = $Comment->where($where)->order('c_id asc')->select();

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '数据获取成功';
            $return_data['data'] = $one_message_all_comments;

            $this->ajaxReturn($return_data);

        }
    }
}