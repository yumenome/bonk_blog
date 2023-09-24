@extends('layouts.app')
@section('content')
        @php
            $i =0;
        @endphp
    <div class="fluid-container" style="display: flex;flex-direction: column;align-items: center;user-select: none">
        {{-- delected feedback  --}}
        @if(session("feedback"))
        <div class="alert alert-primary">
            {{ session("feedback")}}
        </div>
        @endif

        <ul id="list" style="list-style: none;width: 55%;margin-bottom: 5px">
            @foreach ($articles as $article)
            <li class="mb-2" style="border: none; border-radius: 5px">
                <div class="card" style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;" >

                    <header  style="border: 1px solid #7D4CF6;background: #7D4CF6; display: flex;justify-content: space-between;border-bottom: 1px solid #ccc;padding:10px; border-top-left-radius: 5px;border-top-right-radius: 5px;box-shadow: 0 7px 5px rgba(0, 0, 0, 0.1)">
                        <div style="font-size: 18px;color: #fff;">
                              {{$article->user->name}}
                        </div>
                        <small class="text-light" style="font-size: 14px">
                            category:
                            <b style="color: #c6ff09">{{$article->category->name}}</b>
                            <small style="color: #dadbdcf1">
                                {{ $article->created_at->diffForHumans()}}
                            </small>
                        </small>
                    </header>

                    <div class="card-body"
                    style="border: 0; border-radius: 0;display: flex;flex-direction: column;justify-content: center;align-items: center;margin-top: -10px">

                        <div style="align-self: flex-start;margin-bottom: 5px">
                            <h2 class="h4 card-title" style="border-bottom: 1px solid #ccc">
                                {{ $article->title }}
                            </h2>

                            <div class="index mb-1" style="white-space: pre-line;margin-top: -10px;width: 100%">
                                {{ $article->body }}
                                <style>
                                    .index{
                                        max-height: 200px;
                                        overflow-y: scroll;
                                    }
                                    .index::-webkit-scrollbar{
                                        background: transparent;
                                        width: 5px;
                                        margin-right: 10px
                                    }
                                    .index::-webkit-scrollbar-thumb{
                                        background: transparent;
                                    }
                                </style>
                            </div>
                        </div>

                        <img src="/storage/images/{{$article->img}}" alt="{{$article->img}}" style="width: 100%">

                    </div>
                </div>

                {{-- {{$i}} --}}
                <footer style="background: #ececec; padding: 10px;display: flex;justify-content: space-between;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;box-shadow: 0px 10px 50px #9eb8ff">
                    <button id="up"
                    style="display: flex;align-items: center;justify-content: center;border: 0;outline: 0;background: #ececec"
                    onclick="tryme({{$i}},{{$article->id}})">
                    <option class="show" style="margin-right: 2px;font-size: 16px;color: #7D4CF6;"
                    value="{{$article->count}}">{{$article->count}}</option>
                        <img src="{{$article->ballon}}" style="width: 30px;height: 30px;box-shadow: 0px 0px 5px #7D4CF6;border-radius: 50%;padding: 3px">
                    </button>
                    @php
                        $i++;
                    @endphp

                        <a href="{{url("articles/detail/$article->id")}}" class="card-link btn btn-outline-primary" style="box-shadow: 0px 0px 3px #5145ff;border: none;display: flex;align-items: center;justify-content: center;font-size: 15px;padding: 5px;" >comment: {{count($article->comments)}}</a>
                </footer>
            </li>
            @endforeach
        </ul>
        {{-- {{$articles->links()}} --}}
    </div>

    <script>
        let LI = document.getElementById("list").getElementsByTagName("li"); //okakede
        tryme = (i,id) =>{ //arigato
            let foot = LI[i].lastElementChild;
            let final_star = foot.firstElementChild;
            let final_count = final_star.firstElementChild;
            let ballon = final_star.lastElementChild; // ggwp
            let icon =  "/storage/images/after.png"; // ez kid
            let final = ++final_count.value;
            // final_count.innerHTML = final;
            // console.log(value);
            // console.log(LI);
            // console.log(foot);
            // console.log(final_star);
            // foot[i].innerHTML = "none";
            // console.log(i); guys we nailed it!
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "{{url("articles/ballon")}}" + "/" + id , true); // nice try kid
            xhr.setRequestHeader("X-CSRF-Token", "{{csrf_token()}}");
            xhr.onload = () =>{
                if(xhr.readyState == 4 && xhr.status == 200){
                    let data = xhr.response;
                    console.log(data);
                    let two = data.split("png"); // try more
                    console.log(two);
                    final_count.innerHTML = final_count.value = two[1];
                    ballon.src = two[0] + "png"; // u think u could win me, didn't u?
                }
            }
            let form_data =new FormData();
            form_data.append('final', final);
            form_data.append('icon', icon);
            // console.log(form_data.get('final'));

            xhr.send(form_data);

        }
    </script>

@endsection
