@extends('layouts.app')

@section('content')
    <a href="/Aliens/public/post" class="btn btn-default">Go back</a>
    <h1>{{$post->title}}</h1>
    <img style="width:100%" src="/Aliens/public/storage/cover_images/{{$post->cover_image}}">
    <br><br>
    <div>
        {!!$post->body!!}
        {{--  {{$post->body}}   --}}
        {{--  parse HTML with {!! !!}  --}}
    </div>
    <hr>
        <small>Written on {{$post->created_at}}</small>
        <hr>

          @if(!Auth::guest()) {{--If guest user get in the post then they cannot see edit&delete button  --}}
            @if(Auth::user()->id == $post->user_id)
                <a href="/Aliens/public/post/{{$post->id}}/edit" class="btn btn-default"> Edit </a>

                {!!Form::open(['action' => ['PostController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
                {!!Form::close()!!}
            @endif
        @endif

@endsection