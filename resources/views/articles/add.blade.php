@extends('layouts.app')
@section('content')
    <div class="container text-light" style="background: #ffffff;width: 50%; border-radius: 10px; padding: 10px;border: 1px solid #7D4CF6">

    @if ($errors->any())
        <div class="alert alert-primary">
            @foreach ($errors->all() as $err)
            {{$err}}
            @endforeach
        </div>
    @endif

        <form method="post" enctype="multipart/form-data" >
            {{-- for action itself --}}
            @csrf
            <div class="mb-1">
                <label class="mb-2 text-primary">title:</label>
                <input type="text" class="form-control" name="title" style="border: 1px solid #7D4CF6" spellcheck="false">
            </div>
            <div class="mb-1">
                <label class="mb-2 text-primary">body:</label>
                {{-- <input type="text" class="form-control" name="body"> --}}
                <textarea class="form-control text" name="body" style="height: 40vh;border: 1px solid #7D4CF6" spellcheck="false"></textarea>

            </div>
            <div class="mb-3 text-primary ">
                <label class="mb-2">category:</label>
                <select name="category_id" class="form-select" style="border: 1px solid #7D4CF6">
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}">
                        {{$category->name}}
                    </option>}
                    @endforeach
                </select>
            </div>
 {{-- btn --}}
            <div class="mb-2 ">
                <input type="file" class="form-control" id="photo" accept="image/*" name="img" hidden>
                <button class="btn btn-primary" id="upload" style="width: 100%" onclick="upload_photo()">
                     with photo_?</button>
                <script>
                    upload_photo = () =>{
                        event.preventDefault()
                        const input =document.querySelector("#photo");
                        input.click();
                        input.onchange = () =>{
                            document.querySelector("#upload").textContent = "i got it!";
                            document.querySelector("#upload").disabled = "true";

                        }
                    }
                </script>
            </div>
            <button class="btn btn-primary" style="width: 100%">post!</button>
        </form>
    </div>
@endsection

