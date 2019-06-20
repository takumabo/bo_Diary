<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
use App\Http\Requests\CreateDiary; // 追加

class DiaryController extends Controller
{
    public function index()
    {
        //::でメソッドを読んでいるのはLaravelのファサード
        //allはEloquentのメソッド
        //$diaries = Diary::all(); // 追加２
        //order , by , get -> クエリビルダ
        //EloquentもクエリビルダもDBを操作する機能
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

    public function create()
    {
        // views/diaries/create.blade.phpを表示する
        return view('diaries.create');
    }

    public function store(CreateDiary $request)
        {
            // Request 変数名 -> 変数名にリクエスト内容が保存される
            // Request $request   $requestにリクエスト内容が入っている
            //Request->name属性　ユーザーが入力した内容が取れる
            // Request->all() で全部
            $diary = new Diary(); //Diaryモデルをインスタンス化

            $diary->title = $request->title; //画面で入力されたタイトルを代入
            $diary->body = $request->body; //画面で入力された本文を代入
            $diary->save(); //DBに保存

            return redirect()->route('diary.index'); //一覧ページにリダイレクト
        }

        //引数の変数名はなんでもOK
        //引数はルートのワイルドカードに入っている値
    public function destroy(int $id)
        {
            //Diaryモデルを使用して、diariesテーブルから$idと一致するidをもつデータを取得
            $diary = Diary::find($id); 

            //取得したデータを削除
            $diary->delete();

            return redirect()->route('diary.index');
        }


}
