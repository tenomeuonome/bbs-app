<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Thread;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function index()
    public function index(Request $request)
    {
    	// ユーザ識別子をセッションに登録（なければ生成）
    	if($request->session()->missing('user_identifier')){
    		session(['user_identifier' => Str::random(20)]);
    	}
    
    	// ユーザ名をセッションに登録（なければゲスト）
    	if($request->session()->missing('user_name')){
    		session(['user_name' => 'Guest']);
    	}

    	//$threads = Thread::orderBy('created_at', 'desc')->get();
    	$threads = Thread::orderBy('created_at', 'desc')->paginate(3);
    	
    	return view('bbs/index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// 入力したユーザ名をセッションに登録
    	session(['user_name' => $request->user_name]);
    
		// フォームに入力されたスレッド情報をデータベースへ登録
		$threads = new Thread;
		$form = $request->all();
		$threads->fill($form)->save();
		return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // スレッド情報をデータベースから削除
        $thread = Thread::find($id)->delete();

        // 掲示板ページへリダイレクト
        return redirect('/');
    }
    
    public function search(Request $request){
    
    	info('search', ['message' => $request->search_message]);
    	
    	// 検索フォーム入力値のエスケープ処理
    	$search_message = '%' . addcslashes($request->search_message, '%_\\') . '%';
    	
    	// 検索フォームの入力値でLIKE検索
    	$threads = Thread::where('message', 'LIKE', $search_message)->orderBy('created_at', 'desc')->Paginate(3);
    	
    	//$threads = Thread::orderBy('created_at', 'desc')->paginate(3);
    	return view('bbs/index', compact('threads'));
    }
}
