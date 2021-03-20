<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/template/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/template/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../../index2.html" class="h1"><b>Login</b>User</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Masukan Username dan Password Kamu</p>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="username" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="button" onclick="check()"  class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="<?= base_url() ?>/assets/template/plugins/jquery/jquery.min.js"></script>
  <script src="<?= base_url() ?>/assets/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>/assets/template/dist/js/adminlte.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <script type="text/javascript">
    function check() {
      var username = $('#username').val();
      var password = $('#password').val();
      if(username != '' && password != ''){
        login()
      }else{
        if(username == ''){
          get_error('Username cannot be empty')
        }else{
          get_error('Password cannot be empty')
        }
      }
    }

    function login(){
      $.ajax({
        type: 'POST',
        url: "<?php echo base_url(); ?>login/verification/",
        dataType: 'json',
        data: {
          "username": $('#username').val(),
          "password": $('#password').val(),
        },
        success: function(response) {
          if(response.status == 'success'){
            get_success(response.message)
          }else{
            get_error(response.message)
          }
          console.log(response)
        },
        error: function(err) {
          get_error(err)
        },
      });
    }

     function get_success(message){
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: message,
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
           window.location.href = "<?= base_url('todolist') ?>"
        })
    }


    function get_error(message){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        })
    }

  </script>
</body>

</html>