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
  <h1>Konta Lapa</h1>
  <button type="button" id="logout-confirm">
    <div>
      izrakstīties

    </div>
</button>

<div>
  <button type="button" id="delete-account">
    <div>
      izdzēst kontu

    </div>
</button>
<input type="text" id="password" placeholder="parole"></input>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <script>
    $(function() {
      $("#logout-confirm").on("click", function(e) {
        e.preventDefault();
        var status = "log out"
        $.ajax({
          url: '<?= base_url('post/logout/') ?>' + status,
          method: 'post',
          success: function(response) {
            console.log(response.message);
            if (response.message == "loged out successfully") {
              window.location.assign("/home");
            }
          }
        });
      })

      $("#delete-account").on("click", function(e) {
        e.preventDefault();
        var status = "delete account";
        var password = document.getElementById("password").value;
        $.ajax({
          url: '<?= base_url('post/delete/') ?>' + password,
          method: 'post',
          success: function(response) {
            console.log(response.message);
            if (response.message == "account deleted succesfully") {
              window.location.assign("/home");
            }else{console.log(response.message);}
          }
        });
      })
    });
  </script>