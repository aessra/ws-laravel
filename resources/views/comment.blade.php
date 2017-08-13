<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('js/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
</head>
<body>
  <!-- Static navbar -->
  <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
      </div><!--/.nav-collapse -->
    </div>
  </nav>


  <div class="container">



    <div class="content-wrapper">
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div id="load-comment">

            </div>
            <hr/>
          </hr/>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Email" required>
              <p class="help-block"></p>
            </div>
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" placeholder="Name" required>
              <p class="help-block"></p>
            </div>
            <div class="form-group">
              <label for="comment">Comment</label>
              <textarea id="comment" class="form-control tiny-mce"></textarea>
              <p class="help-block"></p>
            </div>
            <button type="button" class="btn btn-default" id="send_comment">Submit</button>
        </div>
      </div>
    </section>
  </div>

</div> <!-- /container -->



<!-- jQuery 2.2.3 -->
<script src="{{ asset('js/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('js/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/tinymce-handler.js') }}"></script>
<script src="{{ asset('js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script>
$(document).ready(function(){
  $.ajax({
    url: "/api/comments",
    type: "GET",
    contentType: false,
    processData: false,
    success: function (data) {
      console.log(data);
      var comment = new Array();
      for (var i = 0; i < data['data'].length; i++)
      {
        if(data['data'][i]['status'] != 0)
        {
          if(data['data'][i]['id_parent'] != 0)
          {
            comment += '<div class="panel panel-default">\
            <div class="panel-heading">\
              <h3 class="panel-title">[rep] : '+data['data'][i]['name']+'</h3>\
            </div>\
            <div class="panel-body">('+data['data'][i]['reply']+') - '+data['data'][i]['comment']+'</div></div>';
          }else
          {
            comment += '<div class="panel panel-default">\
            <div class="panel-heading">\
              <h3 class="panel-title">'+data['data'][i]['name']+'</h3>\
            </div>\
            <div class="panel-body">'+data['data'][i]['comment']+'</div></div>';
          }
        }
      }
      $('#load-comment').html(comment);
    },
    error: function (data) {
      swal("Error!", "Error loading data from backend", "error");
    }
  })
});
$("#send_comment").click(function () {
  var email = $("#email").val();
  var name = $("#name").val();
  var comment = $("#comment").val();
  var status = '1';
  var parent = '0';
  var reply = '0';
  $.ajax({
    url: "/api/comment",
    type: "POST",
    contentType: false,
    processData: false,
    data: function () {
      var data = new FormData();
      data.append("_token", "{{ csrf_token() }}");
      data.append("email", email);
      data.append("name", name);
      data.append("comment", comment);
      data.append("status", status);
      data.append("parent", parent);
      data.append("reply", reply);
      return data;
    }(),
    success: function (data) {
      swal("Comment sent......", "success");
      $("#email").val('');
      $("#name").val('');
      $("#comment").val('');
      location.reload();
    },
    error: function (data) {
      console.log(data);
      swal("Error!", "Try again later...", "error");
    }
  })
});
</script>
</body>
</html>
