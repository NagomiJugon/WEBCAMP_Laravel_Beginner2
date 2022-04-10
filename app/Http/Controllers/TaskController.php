<?php

declare( strict_types = 1 );
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;

class TaskController extends Controller {
    /**
     * トップページを表示する
     * 
     * @return \Illuminate\View\View
     */
    public function list() {
        return view( 'task.list' );
    }
    
    /**
     * タスクの新規登録
     */
     public function register( TaskRegisterPostRequest $request ) {
        // validate済みのデータの取得
        $datum = $request->validated();
        //
        //$user = Auth::user();
        //$id = Auth::id();
        //var_dump( $datum , $user , $id );
        
        // user_idの追加
        $datum[ 'user_id' ] = Auth::id();
        
        // テーブルへのINSERT
        try {
            $r = TaskModel::create( $datum );
        } catch ( \Throwable $e ) {
            // XXX 本当はログに書く等の処理をする。今回は出力するだけ
            echo $e->getMessage();
            exit;
        }
        
        // タスク登録成功時
        $request->session()->flash( 'front.task_register_success' , true );
        
        //
        return redirect( '/task/list' );
     }
    
}