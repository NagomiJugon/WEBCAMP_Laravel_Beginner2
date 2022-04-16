<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletedTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('completed_tasks', function (Blueprint $table) {
            $table->unsignedInteger( 'id' );
            $table->string( 'name' , 128 )->comment( 'タスク名' );
            $table->date( 'period' )->comment( 'タスク期限' );
            $table->text( 'detail' )->comment( 'タスク詳細' );
            $table->unsignedTinyInteger( 'priority' )->comment( '重要度：(1:低い, 2:普通, 3:高い)' );
            $table->unsignedBigInteger( 'user_id' )->comment( 'このタスクの所有者' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' ); // 外部キー制約
            //$table->datetime();
            $table->dateTime( 'created_at' )->useCurrent()->comment( 'タスク完了日時' );
            $table->dateTime( 'updated_at' )->useCurrent()->useCurrentOnUpdate(); // こっちのテーブルでは使わないがLaravelの標準カラムなので残す
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('completed_tasks');
    }
}
