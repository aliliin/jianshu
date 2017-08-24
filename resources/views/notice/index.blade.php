@extends("layout.main")
@section("content")

<div class="col-sm-8 blog-main">
    @foreach($notices as $notice)
    <div class="blog-post">

        标题：<p class="blog-post-meta">{{$notice->title}}</p>
        内容：
        <p>{{$notice->content}}</p>
    </div>
    @endforeach
</div>

    @endsection