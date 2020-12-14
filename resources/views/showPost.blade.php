@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-2">
        <div class="col-md-9 offset-md-2">
            <div class="card mb-3" style="min-width: 18rem;">
                <div class="card-body">
                    <div class="card-title" id="title">
                        <h4> {{$post->title}}</h4>
                    </div>
                    <div class="card-text">
                        <span id="body">{{$post->body}}</span>
                    </div>
                    <hr>
                    <small class="text-muted"> <p> {{$post->created_at}}</p></small>
                <p>created by: {{$post->user->name}}</p>
                    @auth
               @if(auth()->user()->id == $post->user_id)
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="fillInfo()">
                    EDIT
                </button>
                <form action="{{route('posts.destroy', ['id' => $post->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger float-left"> Delete</button>
                </form>
                @endif
                <br>
                <br>
                <br>
                <hr>
                    <div class="form-group">
                      <label for="Comment">Comment</label>
                      <input type="text" class="form-control" id="Comment" name="Comment">
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="comment();">Submit</button>
                    <hr>
                    comments
                    <div id="commentsDIV">
                        <div id="comments" class="comments">
                            @foreach ($comments as $comment)
                                {{$comment->comment}} , {{$comment->user->name}} , {{$comment->created_at}} <br>
                            @endforeach
                        </div>
                    </div>
                @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
              Editing post          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" name="title" id="titleInput" value="">
            </div>

            <div class="form-group">
                <label for="title">Body:</label>
                <textarea name="body" class="form-control" id="bodyInput" cols="30" rows="10"></textarea>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="updatePost()">Save changes</button>
        </div>
      </div>
    </div>
  </div>
<script>

function fillInfo(){
    let title = document.getElementById('title').innerText;
    let body = document.getElementById('body').innerHTML;
    let titleInput = document.getElementById('titleInput');
    let bodyInput = document.getElementById('bodyInput');
    titleInput.value=title;
    bodyInput.value=body;
}
function updatePost(){
            let titleInput = document.getElementById('titleInput');
            let bodyInput = document.getElementById('bodyInput');
            var request = new XMLHttpRequest();
            let windowOBJECT = window.location;
            let apiUrl = windowOBJECT.protocol+"//"+windowOBJECT.host+"/api/posts/{{$post->id}}";
            var params = {
                'title':titleInput.value,
                'body':bodyInput.value,
            }
            var endpoint = apiUrl + formatParams(params);
            request.open('PUT', endpoint, true);
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            request.send();
            updatePage();
}
function updatePage(){
            let title = document.getElementById("title");
            let body = document.getElementById("body");
            let windowOBJECT = window.location;
            let apiUrl = windowOBJECT.protocol+"//"+windowOBJECT.host+"/api/posts/{{$post->id}}";
            var request = new XMLHttpRequest();
            request.open('GET', apiUrl, true);
            request.onload = function() {
                if (this.status >= 200 && this.status < 400) {
                    // Success!
                    var data = JSON.parse(this.response);
                    title.innerText = data.title;
                    body.innerHTML = data.body
                } else {
                }
            };
            request.onerror = function() {
            };
            request.send();
}
    function comment() {
                let comment = document.getElementById("Comment").value;
                var request = new XMLHttpRequest();
                let windowOBJECT = window.location;
                let apiUrl = windowOBJECT.protocol+"//"+windowOBJECT.host+"/api/posts/{{$post->id}}/comments";
                console.log(apiUrl);
                var params = {
                    'comment':comment,
                    'user_id': {{auth()->user()->id}},
                }
                var endpoint = apiUrl + formatParams(params);
                request.open('POST', endpoint, true);
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                request.send();
                reloadComments();
    }


    function reloadComments(){
    let comments = document.getElementById("comments");
    let formattedComments = [];

    let windowOBJECT = window.location;
    let apiUrl = windowOBJECT.protocol+"//"+windowOBJECT.host+"/api/posts/{{$post->id}}/comments";
    var request = new XMLHttpRequest();
    request.open('GET', apiUrl, true);

request.onload = function() {
    if (this.status >= 200 && this.status < 400) {
        comments.innerHTML = '';
        var data = JSON.parse(this.response);
      console.log(data);

        for (let i = 0; i< data.length;i++){

            formattedComments.push("<p>"+data[i].comment+"</p><p>"+data[i].user.name+"</p><p>"+data[i].created_at+"</p><br>");
        }

        for (let i = 0; i< data.length;i++){
            var tag = document.createElement("p");
            var text = document.createElement("EMPTY");
            text.innerHTML = formattedComments[i];
            tag.appendChild(text);
            comments.appendChild(tag);
        }



    } else {


    }
};

    request.onerror = function() {
    // There was a connection error of some sort
    };

    request.send();

}

    function formatParams( params ){
                return "?" + Object
                    .keys(params)
                    .map(function(key){
                        return key+"="+encodeURIComponent(params[key])
                    })
                    .join("&")
            }

    </script>
@endsection
