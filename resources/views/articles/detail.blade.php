@extends('layouts.app')
@section('content')

<div class="fluid-container" style="display: flex;flex-direction: column;align-items: center;justify-content: center" >
    @if(session('info'))
    <div class="alert alert-primary">
        {{session('info')}}
    </div>
    @endif

    <div class="card" style="width: 65%;border: 1px solid #7D4CF6">
            <header class=" text-light" style="background: #7D4CF6; display: flex;justify-content: space-between;border-bottom: 1px solid #ccc;padding:10px; border-top-left-radius: 5px;border-top-right-radius: 5px;align-items: center;box-shadow: 0 7px 5px rgba(0, 0, 0, 0.1)">
                <div style="font-size: 22px">
                  {{$article->user->name}}
                </div>
                <small style="font-size: 14px">
                    category:
                    <b style="color: #c6ff09">{{$article->category->name}}</b>
                    <small style="color: #dadbdcf1"> {{ $article->created_at->diffForHumans() }}</small>
                </small>
            </header>

            <div class="card-body">
                   <div style="align-self: flex-start">
                        <h2 class="h3 card-title">
                          >  {{ $article->title }}
                        </h2>
                        <div style="font-size: 16px;white-space: pre-line;margin-top: -20px">
                            {{ $article->body }}
                        </div>
                    </div>
                    <img src="/storage/images/{{$article->img}}" alt="{{$article->img}}" style="width: 100%">
            </div>

            <footer style="display: flex;flex-direction: row;justify-content: space-between;align-items: center;padding: 7px 10px;margin-top: -15px">

                    <button id="up"
                    style="background: #fff;display: flex;align-items: center;justify-content: center;border: 0;outline: 0;"
                    onclick="tryme({{$article->id}})">
                        <option class="count" style="margin-right: 2px;font-size: 16px;color: #7D4CF6"
                        value="{{$article->count}}">{{$article->count}}</option>
                        <img src="{{$article->ballon}}"  class="img" style="width: 30px;height: 30px;box-shadow: 0px 0px 5px #7D4CF6;border-radius: 50%;padding: 3px">
                    </button>

                    @auth
                    <div class="actions" style="display: flex;flex-direction: row;">
                        @can('delete-article', $article)
                        <a href="{{url("articles/delete/$article->id")}}" class="btn me-1 btn-sm btn-lg btn-outline-danger" style="font-size: 16px" >del</a>
                        @endcan

                        @can('edit-article', $article)
                        <a href="{{url("articles/edit/$article->id")}}" class="btn me-1 btn-sm btn-lg btn-outline-primary" style="font-size: 16px" >edit text</a>
                        @endcan
                    </div>
                    @endauth
            </footer>
    </div>

{{-- comment --}}
<div class="cmt" style="width: 65%">
        <ul class="list-group mt-2">
            <li class="list-group-item text-light" style="background: #7D4CF6;border-bottom-right-radius: 0px;border-bottom-left-radius: 0px">
                comments:
                <span  style="padding: 0 5px;">
                    {{count($article->comments)}}
                </span>
            </li>
            @foreach ($article->comments as $cmt)
            <li class="list-group-item" style="border-radius: 0px">
                <header style="display: flex;justify-content: space-between;margin-bottom: 5px;border-bottom: 1px solid #333">
                <span class="text-primary">{{$cmt->user->name}}</span>

                <small class="text-primary" text-muted>{{$cmt->created_at->diffForHumans()}}</small>
                </header>
                @auth
                    @can('delete-cmt', $cmt)
                    {{-- <a href="{{url("/comments/delete/$cmt->id")}}" class="btn btn-close rounded-pill bg-primary float-end"></a> --}}
                    <a href="{{url("/comments/delete/$cmt->id")}}" class="btn btn-sm btn-outline-primary rounded-pill float-end">X</a>
                    @endcan
                @endauth
                {{$cmt->content}}
            </li>
            @endforeach
        </ul>
        @auth

        <form action="{{url("comments/add")}}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{$article->user->id}}">
            <input type="hidden" name="article_id" value="{{$article->id}}" >
            <textarea name="content" class="form-control" style="height: 15vh;border-top-right-radius: 0px;border-top-left-radius: 0px"></textarea>
            <button class="btn btn-primary m-2 float-end" style="width: 30%">comment</button>
        </form>
        @endauth

    </div>

    <script>
        const up = document.querySelector("#up");
       let count = document.querySelector(".count");
       let img = document.querySelector(".img");

       tryme = (id) =>{
               let final = ++ count.value;
               let icon = "/storage/images/after.png";


               let xhr = new XMLHttpRequest();
               xhr.open("POST", "{{url("articles/ballon")}}" + "/" + id , true);
               xhr.setRequestHeader("X-CSRF-Token", "{{csrf_token()}}");
               xhr.onload = () =>{
                   if(xhr.readyState == 4 && xhr.status == 200){
                       let data = xhr.response;
                       console.log(data);
                       let two = data.split("png");
                       console.log(two);
                       count.innerHTML = count.value = two[1];
                       img.src = two[0] + "png"; //bonk!
                   }
               }
               let form_data =new FormData();
               form_data.append('final', final);
               form_data.append('icon', icon);
               console.log(form_data.get('final'));

               xhr.send(form_data);
       }
    </script>
    @endsection

