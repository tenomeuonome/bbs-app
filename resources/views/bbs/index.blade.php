<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('app_name') }}</title>
    
    <!-- Styles -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .link-hover:hover {opacity: 70%;}
        .bg-lightblue {background: #add8e6;}
        .text-single {height: 2rem;}
    </style>
</head>
<body class="bg-lightblue text-black">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   {{-- スレッド削除の確認 --}}
   <script type="text/javascript">
       function Check(){
           var checked = confirm("本当に削除しますか？");
           if (checked == true) { return true; } else { return false; }
       }
   </script>
	<div class="w-75 m-auto fs-6">
        {{-- タイトル --}}
        <h1 class="text-xl font-bold mt-2">{{ env('app_name') }}</h1>
		{{-- 入力フォーム --}}
		<div class="bg-white w-100 rounded-md mt-2 p-3 fs-4">
            <form action="{{route('thread.store')}}" method="POST">
                @csrf
                <input type="hidden" name="user_identifier" value="{{session('user_identifier')}}">
                <div class="d-flex text-single">
                    <p class="font-bold">名前</p>
                    <input class="ms-2 border rounded px-2 input-sm w-25" type="text" name="user_name" value="{{session('user_name')}}" required>
                </div>
                <div class="d-flex mt-2 text-single">
                    <p class="font-bold">件名</p>
                    <input class="border rounded px-2 ms-2 input-sm w-25" type="text" name="message_title" required autofocus>
                </div>
                <div class="d-flex mt-2">
                    <p class="font-bold">本文</p>
                    <textarea class="border rounded px-2 ms-2 input-lg w-50" name="message" required></textarea>
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <input class="my-2 px-2 py-1 rounded bg-primary text-dark font-bold link-hover cursor-pointer fs-6" type="submit" value="投稿">
                </div>
            </form>
        </div>
        {{-- 検索フォーム --}}
		<div class="bg-white w-100 rounded-md mt-3 p-3">
            <form action="{{route('thread.search')}}" method="post">
                @csrf
                <div class="mx-1 flex">
                    <input class="border rounded px-2 flex-auto" type="text" name="search_message">
                    <input class="px-2 py-1 rounded bg-secondary text-white font-bold link-hover cursor-pointer" type="submit" value="検索">
                </div>
            </form>
        </div>
        {{-- ページネーション --}}
		<div class="w-100 fs-5 mt-3">
			<p class="ms-2">{{ $threads->links() }}</p>
		</div>
        {{-- 投稿 --}}
        @foreach ($threads as $thread )
		<div class="bg-white rounded-md mt-2 mb-2 p-3">
			<div class="w-100">
	            {{-- スレッド --}}
	            <div>
	                <p class="mb-2 fs-6">{{$thread->created_at}} ＠{{$thread->user_name}}</p>
	                <p class="mb-2 fs-4 font-bold">{{$thread->message_title}}</p>
	                <p class="mb-2 fs-4">{{$thread->message}}</p>
	            </div>
				<div class="d-flex flex-row">
		            {{-- 返信 --}}
		            <form class="justify-end" action="{{route('reply.store')}}" method="POST">
		                @csrf
		                <input type="hidden" name="thread_id" value={{$thread->id}}>
		                <input class="border rounded px-2 flex-initial" type="text" name="user_name" placeholder="UserName" value="{{session('user_name')}}" required>
	                    <input class="border rounded px-2 ms-1 flex-auto" type="text" name="message" placeholder="ReplyMessage" required>
		                <input class="px-2 py-1 rounded bg-success text-white font-bold link-hover cursor-pointer" type="submit" value="返信">
		            </form>
		            {{-- 削除ボタン --}}
		            @if ($thread->user_identifier == session('user_identifier'))
					<form action="{{route('thread.destroy', ['thread'=>$thread->id])}}" method="post">
	                       @csrf
	                       @method('DELETE')
	                       <input class="px-2 py-1 ms-1 rounded bg-danger text-white font-bold link-hover cursor-pointer" type="submit" value="削除" onclick="return Check()">
	                </form>
	                @endif
				</div>
	            <hr class="mt-2 m-auto">
	            @foreach ($thread->replies as $reply)
	            <div class="justify-end ps-5">
                    <p class="mt-2 fs-6">{{$reply->created_at}} ＠{{$reply->user_name}}</p>
                    <p class="my-2 fs-4">{{$reply->message}}</p>
	            </div>
	            @endforeach
			</div>
        </div>
	    @endforeach
        {{-- ページネーション --}}
		<div class="w-100 fs-4 mt-3">
			<p class="ms-2">{{ $threads->links() }}</p>
		</div>
	</div>
</body>
</html>