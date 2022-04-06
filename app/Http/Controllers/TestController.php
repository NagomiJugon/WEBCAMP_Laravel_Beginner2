<?php

declare( strict_types = 1 );
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TestPostRequest;

class TestController extends Controller {
    /**
     * トプページを表示する
     * 
     * @return \Illuminate\View\View
     */
    public function index() {
        return view( 'test.index' );
    }
    
    /**
     * 入力を受け取る
     * 
     * @return \Illuminate\View\View
     */
    public function input( TestPostRequest $request ) {
        //validate済み
        
        // データの取得
        $validatedData = $request->validated();
        
        //
        //var_dump( $validatedData ); exit;
        
        return view( 'test.input' , [ 'datum' => $validatedData ] );
    }
}