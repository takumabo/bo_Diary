<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//diariesテーブルのデータを扱うためのクラス
//クラス名を先頭で小文字で複数形にした形の、
//テーブルと自動的に関連づけされる
//Diary -> diaries]
//モデル　先頭大文字　単数系　キャメルケース
//→ 単横するDBのテーブルは　小文字　複数形　スネークケース
//※キャメルケース　単語の区切り　→ 大文字
//※スネークケース　単語の区切り　→ _

//例　モデル　NexSeed テーブル名: nex_seed

class Diary extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

}
