@extends('layouts.app')
@section('content')
<div class="container text-light" style="background: #7D4CF6;width: 60%; border-radius: 10px; padding: 10px;">

    <form method="post" >
        {{-- for action itself --}}
        @csrf
        <div class="mb-2">
            <label class="mb-2">title:</label>
            <input type="text" class="form-control" name="title" value="{{$article->title}}">
        </div>
        <div class="mb-2">
            <label class="mb-2">body:</label>
            {{-- <input type="text" class="form-control" name="body" value="{{$article->body}}" style="height: 50px"> --}}

            <textarea class="detail form-control" name="body" value="{{$article->body}}" style="height: 40vh;">{{$article->body}}</textarea>
            <style>
                .detail{
                    max-height: 200px;
                    overflow-y: scroll;
                }
                .detail::-webkit-scrollbar{
                    background: #fff;
                    width: 5px;
                    margin-right: 10px
                }
                .detail::-webkit-scrollbar-thumb{
                    background: #7D4CF6;
                }
            </style>
        </div>

        <div class="mb-3">
            <label class="mb-2">category:</label>
                <select name="category_id" class="form-select" onclick="dis()">
                    @foreach ($categories as $category)
                        <option  value="{{$category->id}}"
                            @if ($article->category_id == $category->id)
                            selected
                            @endif >
                            {{$category->name}}
                        </option>
                    {{-- {{$category->name}} --}}
                {{-- </option> --}}
                @endforeach
            </select>
        </div>
        <button class="btn btn-light text-primary" style="width: 100%">save!</button>
    </form>
</div>
@endsection
