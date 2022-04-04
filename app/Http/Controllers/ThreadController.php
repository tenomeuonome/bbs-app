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
    	// ���[�U���ʎq���Z�b�V�����ɓo�^�i�Ȃ���ΐ����j
    	if($request->session()->missing('user_identifier')){
    		session(['user_identifier' => Str::random(20)]);
    	}
    
    	// ���[�U�����Z�b�V�����ɓo�^�i�Ȃ���΃Q�X�g�j
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
    	// ���͂������[�U�����Z�b�V�����ɓo�^
    	session(['user_name' => $request->user_name]);
    
		// �t�H�[���ɓ��͂��ꂽ�X���b�h�����f�[�^�x�[�X�֓o�^
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
        // �X���b�h�����f�[�^�x�[�X����폜
        $thread = Thread::find($id)->delete();

        // �f���y�[�W�փ��_�C���N�g
        return redirect('/');
    }
    
    public function search(Request $request){
    
    	info('search', ['message' => $request->search_message]);
    	
    	// �����t�H�[�����͒l�̃G�X�P�[�v����
    	$search_message = '%' . addcslashes($request->search_message, '%_\\') . '%';
    	
    	// �����t�H�[���̓��͒l��LIKE����
    	$threads = Thread::where('message', 'LIKE', $search_message)->orderBy('created_at', 'desc')->Paginate(3);
    	
    	//$threads = Thread::orderBy('created_at', 'desc')->paginate(3);
    	return view('bbs/index', compact('threads'));
    }
}
