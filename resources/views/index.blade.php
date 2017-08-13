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
  <!-- Datatables -->
  <link rel="stylesheet" type="text/css" href="{{ asset('js/datatables/media/css/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('js/datatables/media/css/dataTables.bootstrap.css') }}">

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
      <section class="content-header">
        <h1>
          Comments
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="active">News</li>
        </ol>
      </section>

      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Data News</h3>
              </div>
              <div class="box-body">
                <div class="table-responsive mailbox-messages">
                  <table id="data-comment" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th class="text-center" width="10%">ID Comment</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Comment</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Date</th>
                        <th class="text-center" width="10%">Parent ID</th>
                        <th class="text-center" width="20%">Reply To</th>
                        <th class="text-center" width="10%"></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

  </div> <!-- /container -->

  <div id="ReplyComment" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Reply Comment</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Isi Comment</label>
            <p id="isi-comment">

            </p>
          </div>
          <div class="form-group">
            <label>Reply Comment</label>
            <textarea id="comment" class="form-control tiny-mce"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" data-id="0" data-name="0" id="reply-comment">Reply</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div id="DetailComment" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Detail Comment</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



  <!-- jQuery 2.2.3 -->
  <script src="{{ asset('js/jQuery/jquery-2.2.3.min.js') }}"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="{{ asset('js/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- Datatables -->
  <script type="text/javascript" language="javascript" src="{{ asset('js/datatables/media/js/jquery.dataTables.js') }}"></script>
  <script type="text/javascript" language="javascript" src="{{ asset('js/datatables/media/js/dataTables.bootstrap.js') }}"></script>
  <!-- TinyMCE -->
  <script src="{{ asset('js/tinymce-handler.js') }}"></script>
  <script src="{{ asset('js/tinymce/js/tinymce/tinymce.min.js') }}"></script>

  <script src="{{ asset('js/sweetalert.min.js') }}"></script>
  <script>
  $(document).ready(function(){
    $('#data-comment').DataTable({
      ajax: "{{ url('/api/comments') }}",
      type:"GET",
      dataType: "json",
      columns:[
        {data: "id", className: "dt-center"},
        {data: "email"},
        {data: "comment"},
        {
          data: "status", className: "dt-center", render: function(value, data, type){
            if(value == '1')
            {
              dt = 'Publish';
            }else if (value == '0')
            {
              dt = 'Banned';
            }
            return dt;
          }
        },
        {
          data: "created_at", className: "dt-center", render: function(value, data, type){
            var date_comment = value.split(" ");
            var dt = date_comment[0].split('-');
            var hr = date_comment[1].split(':');
            return dt[2] +'-'+ dt[1] +'-'+ dt[0] +' '+ hr[0] +':'+ hr[1];
          }
        },
        {data: "id_parent", className: "dt-center"},
        {
          data: "reply", className: "dt-center", render: function(value, data, type){
            if(value == 0)
            {
              return '--';
            }else
            {
              return value;
            }
          }
        },
        {
          data: "id", className: "dt-center", "searchable": false, "orderable": false, render: function(value, data, type){
            var id = value;
            return '<button type="button" data-name="'+id+'" data-toggle="modal" data-target="#ReplyComment" onclick="handleClickReply('+id+');" class="btn btn-warning btn-xs"><i class="fa fa-fw fa-reply"></i></button> <button type="button" class="btn btn-danger btn-xs btn-delete" data-toggle="modal" onclick="handleClickDelete('+id+');"><i class="fa fa-fw fa-trash"></i></button> <button type="button" class="btn btn-success btn-xs"  data-name="'+id+'" data-toggle="modal" data-target="#DetailComment"><i class="fa fa-fw fa-ellipsis-v"></i></button>';
          }
        }
      ],
      "order": [[ 1, 'DESC' ]]
    });
  });

  function handleClickReply(id){
    $.ajax({
      url:"/api/one-comment/"+id,
      dataType: "json",
      success:function(data){
        $('p#isi-comment').html(data['data'].comment);
        $('#reply-comment').data('id',data['data'].id);
        $('#reply-comment').data('name',data['data'].name);
      }
    })
  }


  $("#reply-comment").click(function () {
    var email = 'admin@md.com';
    var name = 'Admin';
    var comment = $("#comment").val();
    var status = '1';
    var parent = $("#reply-comment").data("id");
    var reply = $("#reply-comment").data("name");
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
        swal("Comment replied......", "success");
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

  function handleClickDelete(id) {
    swal({
      title: "Are you sure?",
      text: "Banned Comment",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes! Banned",
      cancelButtonText: "Cancel",
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true
    },
    function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          url: "/api/comment/" + id,
          type: "DELETE",
          contentType: false,
          processData: false,
          data: function () {
            var data = new FormData();
            data.append("_method", 'delete');
            data.append("_token", "{{ csrf_token() }}");
            return data;
          }(),
          success: function (data) {
            if (true) {
              setTimeout(function () {
                swal({
                  title: "Success",
                  text: "Data comment banned!!",
                  type: "success"
                },
                function () {
                  location.reload();
                });
              }, 1000);
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            setTimeout(function () {
              swal("Error!", "Try again later...", "error");
            }, 1000);
          }
        });
      } else {
        swal("Cancel", "Canceled", "error");
      }
    });
  }
  </script>
</body>
</html>
