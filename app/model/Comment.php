<?php


namespace app\model;


class Comment extends BaseModel
{
    protected $hidden = [
        'delete_time', 'update_time','user_id', 'id'
    ];

    public function userinfo()
    {
        return $this->belongsTo('User','user_id','id');
    }

    public static function getCommentByPid($id)
    {
        return self::where('product_id', $id)->order('create_time desc')
            ->with('userinfo')->select();
    }

    public static function addOneComment($id, $comment, $uid)
    {
        return self::create([
            'product_id' => $id,
            'comment' => $comment,
            'user_id' => $uid
        ]);
    }
}