<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>shit site</title>
  <link rel="stylesheet" href="/css/home.css">
  </link>
  <link rel="stylesheet" href="/css/header.css">
  </link>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<body>
  <?= $header ?>
  <!--    <div class="col-3 border border-black p-3 ">
      <div class="row justify-content-center">
      <div class="col-10 border border-black m-2 p-1">
        setting1
      </div>
      <div class="col-10 border border-black m-2 p-1">
        setting2
      </div>
      <div class="col-10 border border-black m-2 p-1">
        setting3
      </div>
      <div class="col-10 border border-black m-2 p-1">
        setting4
      </div>
      <div class="col-10 border border-black m-2 p-1">
        setting5
      </div>
</div>
    </div> -->

  <div class="container-flex position-absolute top-50 start-50 translate-middle row text-center border border-black w-50">
    <div class="col-12 border border-black justify-content-center p-3">
      <div class="row justify-content-center">
        <div class="col-12 ">
          Ielogojaties savā kontā
        </div>
        <div class="col-8 m-2 p-1">
          <div class="form-floating ">
            <input type="text" class="form-control" id="email" placeholder="RallyMally@gmail.com">
            <label for="email">Epasts/Lietotājvārds</label>
          </div>
        </div>
        <div class="col-8 m-2 mb-1 p-1">
          <div class="form-floating">
            <input type="password" class="form-control" id="password" placeholder="password">
            <label for="password">Parole</label>
          </div>
        </div>
        <div class="col-7 small mb-2">
          <a href="/signup">Nav konts? Spiediet šeit!</a>
        </div>
        <div class="col-8">
          <button type="button" id="login-confirm" class="btn btn-primary">Pieslēgties</button>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <script>
    $(function() {
      $("#login-confirm").on("click", function(e) {
        e.preventDefault();
        const login = [];
        login[0] = document.getElementById("email").value;
        login[1] = document.getElementById("password").value;
        $.ajax({
          url: '<?= base_url('post/login/') ?>' + login,
          method: 'post',
          success: function(response) {
            console.log(response.message);
            if (response.message["login"] == "loged in successfully") {
              window.location.assign("/home")
              <?php $session = session();
              $session->set('logged_in', '1');

              ?>
            }
          }
        });
      })
    });
  </script>
</body>

</html>