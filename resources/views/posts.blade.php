@extends('layouts.app')
@section('css')
    <style>
        .tag-wrapper{
            display: inline-block;
            border-radius: 15px;
            background-color: #000000;
            color: #ffffff;
            padding: 5px 10px;
            font-size: 12px;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Posts') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table">
                        <table id="post_datatable" class="table">
                            <tr>
                                <th>Title</th>
                                <th>Author's Name</th>
                                <th>Comment Count</th>
                                <th>Tags</th>
                            </tr>
                            @forelse ($posts as $post)
                                <tr>
                                    <td>
                                        <p>{{ $post->title }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $post->author_name }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $post->comments_count }}</p>
                                    </td>
                                    <td>
                                        @forelse ($post->tags as $tag)
                                            <span class="tag-wrapper">{{$tag->tag}}</span>
                                        @empty
                                            <p>No Tag's found</p>
                                        @endforelse
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"><p class="text-center">No Posts found</p></td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
