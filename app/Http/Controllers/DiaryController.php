<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;

class DiaryController extends Controller
{
    public function index()
    {
        //::でメソッドを読んでいるのはLaravelのファサード
        $diaries = Diary::orderBy('id','desc')->get();
        //allはテーブルの中身を全て取得

        // dd($diaries);
        //dd-> die and dump
        //var_dumpとexsitをまとめて実行してくれる関数

        // veiwsディレクトリの中のdiariesディレクトリのなかのindex(.blade).phpを返す
        //第３引数に連想配列の形の中でviewで使用したいデータをかく
        // key = view で使用する変数名で、viewが実際の変数
         return view('diaries.index' , ['diaries' => $diaries]);
    }
}
