<?php

declare( strict_types = 1 );
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedTask as CompletedTaskModel;

class TaskController extends Controller {
    /**
     * トップページを表示する
     * 
     * @return \Illuminate\View\View
     */
    public function list() {
        // 1Page辺りの表示アイテム数を設定
        $per_page = 2;
        
        // 一覧の取得
        $list = TaskModel::where( 'user_id' , Auth::id() ) 
            ->orderBy( 'priority' , 'DESC' )
            ->orderBy( 'period' )
            ->orderBy( 'created_at' )
            ->paginate( $per_page );
            //->get();
        /*
        $sql = TaskModel::where( 'user_id' , Auth::id() )
            ->orderBy( 'priority' , 'DESC' )
            ->toSql();
        //echo "<pre>\n"; var_dump( $sql , $list ); exit;
        */
        //
        return view( 'task.list' , [ 'list' => $list ] );
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
     
    /**
     * タスクの詳細閲覧
     */
    public function detail( $task_id ) {
        //
        return $this->singleTaskRender( $task_id , 'task.detail' );
    }
    
    
    /**
     * タスクの編集画面
     */
    public function edit( $task_id ) {
        // task_idのレコードを取得する
        // テンプレートに「取得したレコード」の情報を渡す
        return $this->singleTaskRender( $task_id , 'task.edit' );
    }
    
    /**
     * 「単一のタスク」の表示
     */
    protected function singleTaskRender( $task_id , $template_name ) {
        $task = $this->getTaskModel( $task_id );
        if ( $task === null ) {
            return redirect( '/task/list' );
        }
        
        // テンプレートに「取得したレコード」の情報を渡す
        return view( $template_name , [ 'task' => $task ] );
    }
    
    /**
     * タスクの編集
     */
    public function editSave( TaskRegisterPostRequest $request , $task_id ) {
        // formからの情報を取得する(validate済みのデータの取得)
        $datum = $request->validated();
        // task_idのレコードを取得する
        $task = $this->getTaskModel( $task_id );
        if ( $task === null ) {
            return redirect( '/task/list' );
        }
        // レコードの内容をUPDATEする
        $task->name = $datum[ 'name' ];
        $task->period = $datum[ 'period' ];
        $task->detail = $datum[ 'detail' ];
        $task->priority = $datum[ 'priority' ];
        /*
        可変変数を使うと以下の書き方で実装できる
        foreach ( $datum as $k => $v ) {
            $task->$k = $v;
        }
        */
        
        // レコードを更新
        $task->save();
        
        // タスク編集成功
        $request->session()->flash( 'front.task_edit_success' , true );
        // 詳細閲覧画面にリダイレクトする
        return redirect( route( 'detail' , [ 'task_id' => $task->id ] ) );
    }
    
    /**
     * 「単一のタスク」Modelの取得
     */
    protected function getTaskModel( $task_id ) {
        // task_idのレコードを取得する
        $task = TaskModel::find( $task_id );
        if ( $task === null ) {
            return null;
        }
        // 本人以外のタスクならNGとする
        if ( $task->user_id !== Auth::id() ) {
            return null;
        }
        
        return $task;
    }
    
    /**
     * 削除処理
     */
    public function delete( Request $request , $task_id ) {
        // task_idのレコードを取得する
        $task = $this->getTaskModel( $task_id );
        
        // タスクを削除する
        if ( $task !== null ) {
            $task->delete();
            $request->session()->flash( 'front.task_delete_success' , true );
        }
        
        // 一覧に遷移する
        return redirect( '/task/list' );
    }
    
    /**
     * タスクの完了
     */
    public function complete( Request $request , $task_id ) {
        /* タスクを完了テーブルに移動させる */
        try {
            // トランザクション開始
            DB::beginTransaction();
            
            // task_idのレコードを取得する
            $task = $this->getTaskModel( $task_id );
            if ( $task === null ) {
                // task_idが不正なのでトランザクション終了
                throw new \Exception( '' );
            }
            // tasks側を削除する
            $task->delete();
            // completed_tasks側にinsertする
            $task_datum = $task->toArray();
            unset( $task_datum[ 'created_at' ] );
            unset( $task_datum[ 'updated_at' ] );
            $r = CompletedTaskModel::create( $task_datum );
            if ( $r === null ) {
                // insertで失敗した場合はトランザクション終了
                // create()の返り値は作成したレコードのobject
                throw new \Exception( '' );
            }
            
            // トランザクション終了
            DB::commit();
            // 完了メッセージ
            $request->session()->flash( 'front.task_completed_success' , true );
            
        } catch ( \Throwable $e ) {
            // トランザクション異常終了
            DB::rollback();
            // 失敗メッセージ
            $request->session()->flash( 'front.task_completed_failure' , true );
        }
        
        // 一覧に遷移する
        return redirect( '/task/list' );
    }
}