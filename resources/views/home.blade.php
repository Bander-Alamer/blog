@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3>
                        {{ __('Timeline') }}
                    </h3>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="alert alert-info">
                        Gender mode : <span style="color:green">ON</span>
                    </div>

                    @foreach($posts as $post)
                    <div class="card">
                        <div class="card-header">
                            <a href="/posts/{{$post->id}}">
                                {{$post->title}}
                            </a>
                            <div>
                                <b>{{$post->user->name}}</b> - {{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
