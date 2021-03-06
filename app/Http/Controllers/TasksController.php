<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasklist = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            $tasklist = $user->tasks()->get();
        }

        return view('tasklist.index', [
            'tasklist' => $tasklist,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasklist = new Task;
        if (\Auth::check()) {
            // メッセージ作成ビューを表示
            return view('tasklist.create', [
                'tasklist' => $tasklist,
            ]);
        }
        
        return redirect('/');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // postでmessages/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {

       // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);
        if (\Auth::check()) {
            // メッセージを作成
            $tasklist = new Task;
            $tasklist->status = $request->status;    // 追加
            $tasklist->content = $request->content;
            $tasklist->user_id = \Auth::id();
            $tasklist->save();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // getでmessages/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でメッセージを検索して取得
        $tasklist = Task::findOrFail($id);
        if (\Auth::id() === $tasklist->user_id) {
            // メッセージ詳細ビューでそれを表示
            return view('tasklist.show', [
                'tasklist' => $tasklist,
            ]);
        }
        
        return redirect('/');

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        $tasklist = Task::findOrFail($id);
        if (\Auth::id() === $tasklist->user_id) {
            // メッセージ編集ビューでそれを表示
            return view('tasklist.edit', [
                'tasklist' => $tasklist,
            ]);
        }
        
        return redirect('/');
        
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  // putまたはpatchでmessages/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {

        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);

        // idの値でメッセージを検索して取得
        $tasklist = Task::findOrFail($id);
        if (\Auth::id() === $tasklist->user_id) {
            
            // メッセージを更新
            $tasklist->status = $request->status;
            $tasklist->content = $request->content;
            $tasklist->save();

        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // idの値でメッセージを検索して取得
        $tasklist = Task::findOrFail($id);
        
        if (\Auth::id() === $tasklist->user_id) {
            // メッセージを削除
            $tasklist->delete();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }
    
}
