<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Diary;
use App\Http\Requests\CreateDiary; // 追加
use Illuminate\Support\Carbon;

class DiaryController extends Controller
{
    public function index()
    {
        //::でメソッドを読んでいるのはLaravelのファサード
        //allはEloquentのメソッド
        //$diaries = Diary::all(); // 追加２
        //order , by , get -> クエリビルダ
        //EloquentもクエリビルダもDBを操作する機能
        $diaries = Diary::with('likes')->orderBy('id', 'desc')->get();
        //allはテーブルの中身を全て取得するメソッド

        // dd($diaries);
        //dd-> die and dump。//var_dump()とdie()を合わせたメソッド。変数の確認 + 処理のストップ。つまり。
        //var_dumpとexsitをまとめて実行してくれる関数

        // veiwsディレクトリの中のdiariesディレクトリのなかのindex(.blade).phpを返す
        //第３引数に連想配列の形の中でviewで使用したいデータをかく
        // key = view で使用する変数名で、viewが実際の変数
         return view('diaries.index',[
              'diaries' => $diaries,
          ]);
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
            $diary->user_id = Auth::user()->id; //追加 ログインしてるユーザーのidを保存
            $diary->save(); //DBに保存

            return redirect()->route('diary.index'); //一覧ページにリダイレクト
        }

        //引数の変数名はなんでもOK
        //引数はルートのワイルドカードに入っている値
    public function destroy(Diary $diary)
        {
            if (Auth::user()->id !== $diary->user_id) {
            abort(403);
        }
            //Diaryモデルを使用して、diariesテーブルから$idと一致するidをもつデータを取得
            // $diary = Diary::find($id); 

            //取得したデータを削除
            $diary->delete();

            return redirect()->route('diary.index');
        }

    public function edit(Diary $diary)
        {
            if (Auth::user()->id !== $diary->user_id) {
            abort(403);
            }

              //Diaryモデルを使用して、diariesテーブルから$idと一致するidをもつデータを取得
            // $diary = Diary::find($id);

            return view('diaries.edit', [
                'diary' => $diary,
            ]);

        }

        public function update(Diary $diary, CreateDiary $request)
        {
            if (Auth::user()->id !== $diary->user_id) {
            abort(403);
        }
            // $diary = Diary::find($id);

            $diary->title = $request->title; //画面で入力されたタイトルを代入
            $diary->body = $request->body; //画面で入力された本文を代入
            $diary->save(); //DBに保存

            return redirect()->route('diary.index'); //一覧ページにリダイレクト
        }


  //いいね・いいね解除のメソッド
        public function like(int $id)
            {
                $diary = Diary::where('id', $id)->with('likes')->first();

                $diary->likes()->attach(Auth::user()->id);
            }

        public function dislike(int $id)
        {
            $diary = Diary::where('id', $id)->with('likes')->first();

            $diary->likes()->detach(Auth::user()->id);
        }



}
