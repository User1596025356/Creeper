<?php


namespace app\controller\v1;


use app\exception\MissException;
use app\service\Token as TokenService;
use app\validate\IDMustBePositiveInt;
use app\model\Comment as CommentModel;
use app\validate\TestToken;
use app\validate\CommentValidate;

class Comment
{
    public function getComments($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $comments = CommentModel::getCommentByPid($id);
        return json($comments);
    }

    public function addComment($comment, $id)
    {
        (new TestToken())->gocheck();
        $uid = TokenService::getCurrentUid();
        (new CommentValidate())->goCheck();
        $result = CommentModel::addOneComment($id, $comment, $uid);
        if($result->isEmpty())
        {
            throw new MissException([
                'code' => 500,
                'errorCode' => 50001,
                'msg' => '评论失败'
            ]);
        }else{
            return json($result);
        }
    }
}