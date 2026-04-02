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
  <div class="row p-0 justify-content-center">
    <div class="col-10 border border-black p-1">

      <div class="border border-black mb-1">
        <h3>Konta Informācija</h3>

        <form id="editForm">
          <div class="row p-1 align-middle">
            <div class="col-8 row">
              <div class="col-5 m-2 p-1">
                <div class="form-floating ">
                  <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                  <label for="email">Epasts</label>
                </div>
              </div>
              <div class="col-5 m-2 mb-1 p-1">
                <div class="form-floating">
                  <input type="password" class="form-control" id="password" name="password" placeholder="*********" minlength="8"><!--change to 9 for the end fganjrhfvkbhjoawenlknknlk -->
                  <label for="password">Parole</label>
                </div>
              </div>
              <div class="col-5 m-2 mb-0 p-1 pb-0">
                <div class="form-floating">
                  <input class="form-control" id="username" name="username" placeholder="super sigma" required>
                  <label for="username">Lietotājvārds</label>
                </div>
              </div>
              <div class="col-5 m-2 mb-0 p-1 pb-0">
                <div class="form-floating">
                  <input type="tel" class="form-control" id="phone" name="phone" placeholder="28192385" required>
                  <label for="phone">Mobilais nummurs</label>
                </div>
              </div>
              <div class="form-text mt-0 mb-2">Ierakstiet tos, kurus vēlaties mainīt</div>
            </div>
            <div class="col-3">

              <div id="selectedImage">
                <?php $session = session();
                echo ('<img class="" style="height: 120px" src="' . base_url('uploads/avatar/' . $session->get('pfp')) . '">')
                ?>
              </div>
              <input id="file" accept="image/*" name="file" TYPE="FILE"></input>

            </div>
            <div class="col-auto row align-items-center">
              <div class="col-auto">
                <button type="submit" id="signup_btn" class="btn btn-primary">Saglabāt</button>
              </div>
              <div class="col">
                <div class="form-floating">
                  <input type="password" class="form-control" id="passwordConfirmEdit" name="passwordConfirmEdit" placeholder="*********" minlength="8" required><!--change to 9 for the end fganjrhfvkbhjoawenlknknlk -->
                  <label for="password">Parole lai apstiprinātu</label>
                </div>
              </div>
            </div>
          </div>
        </form>

      </div>
      <div class="border border-black p-1">
        <h3>Konta Kontrole</h3>
        <div class="row">
          <div class="col-auto">
            <button type="button" class="btn btn-primary" id="logout-confirm">
              izrakstīties
            </button>
          </div>
          <p class="m-1"></p>
          <div class="col-8 row align-items-center">
            <div class="col-auto me-0">
              <button type="button" class="btn btn-danger" id="delete-account">Izdzēst kontu</button>
            </div>
            <div class="col-4">
              <div class="form-floating">
                <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder="*********" minlength="8" required><!--change to 9 for the end fganjrhfvkbhjoawenlknknlk -->
                <label for="password">Parole lai apstiprinātu</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <script>
    $(function() {
      $("#logout-confirm").on("click", function(e) {
        e.preventDefault();
        var status = "log out"
        $.ajax({
          url: '<?= base_url('account/logout/') ?>' + status,
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
        var password = document.getElementById("passwordConfirm").value;
        $.ajax({
          url: '<?= base_url('account/delete/') ?>' + password,
          method: 'post',
          success: function(response) {
            console.log(response.message);
            if (response.message == "account deleted succesfully") {
              window.location.assign("/home");
            } else {
              console.log(response.message);
            }
          }
        });
      })

      var selDiv = "";
      var storedFiles = [];
      $(document).ready(function() {
        $("#file").on("change", handleFileSelect);
        selDiv = $("#selectedImage");
      });

      function handleFileSelect(e) {
        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        filesArr.forEach(function(f) {
          if (!f.type.match("image.*")) {
            return;
          }
          storedFiles.push(f);

          var reader = new FileReader();
          reader.onload = function(e) {
            var html =
              '<img id="image" name="image" src="' +
              e.target.result +
              "\" data-file='" +
              f.name +
              "' class='avatar rounded lg' alt='Category Image' height='120px' width='120px'>";
            selDiv.html(html);
          };
          reader.readAsDataURL(f);
        });
      }

      fetchAccount();

      function fetchAccount() {

        $.ajax({
          url: '<?= base_url('account/fetch') ?>',
          method: 'post',
          success: function(response) {
            var response = response.message;
            if (response) {
              document.getElementById("email").value = response["email"];
              document.getElementById("username").value = response["username"];
              document.getElementById("phone").value = response["phone"];
            }
          }
        });
      }

      $("#editForm").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        $.ajax({
          url: '<?= base_url('account/edit') ?>',
          method: 'post',
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if(response.message == "success"){
              location.reload();
            }

          }
        });
      })
    });
  </script>