<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterPost;
use Illuminate\Support\Facades\Hash;
use App\Models\User as UserModel;

class UserController extends Controller
{
  /**
   * 会員登録画面の表示
   */
  public function index() {
    return view( 'user.register' );
  }
  
  /**
   * ユーザー新規登録
   */
  public function register( UserRegisterPost $request ) {
    // validate済みのデータの取得
    $datum = $request->validated();
    
    // passwordのHash化
    $datum[ 'password' ] = Hash::make( $datum[ 'password' ] );
    
    // usersテーブルへのINSERT
    try {
      $r = UserModel::create( $datum );
    } catch (\Throwable $e ) {
      // ユーザー登録失敗時
      $request->session()->flash( 'front.user_register_failure' , true );
      return redirect( route( 'front.index' ) );
    }
    
    // ユーザー登録成功時
    $request->session()->flash( 'front.user_register_success' , true );
    
    //
    return redirect( route( 'front.index' ) );
  }
    
}
