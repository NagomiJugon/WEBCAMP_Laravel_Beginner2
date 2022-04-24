<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedTask as CompletedTaskModel;
use Illuminate\Support\Facades\Auth;

class CompletedTaskController extends Controller
{
    //
    /**
     * 完了タスクの一覧
     * 
     * @return \Illuminate\View\View
     */
    public function completed_list() {
        // 1Page辺りの表示アイテム数を設定
        $per_page = 2;
        
        $completed_task = CompletedTaskModel::where( 'user_id', Auth::id() )
                                            ->orderBy( 'created_at' )
                                            ->paginate( $per_page );
        return view( 'task.completed_list' , [ 'list' => $completed_task ] );
    }
}
