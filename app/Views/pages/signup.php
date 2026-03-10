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

    <div class="container-flex position-absolute top-50 start-50 translate-middle row text-center border border-black w-50">
        <form id="signup_form" class="col-auto row">
            <div class="col-8 border border-black justify-content-center p-3">

                <div class="row justify-content-center">
                    <div class="col-12 ">
                        Izveidojiet savu kontu
                    </div>
                    <div class="col-8 m-2 p-1">
                        <div class="form-floating ">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                            <label for="email">Epasts</label>
                        </div>
                    </div>
                    <div class="col-8 m-2 p-1">
                        <div class="form-floating">
                            <input class="form-control" id="username" name="username" placeholder="super sigma">
                            <label for="username">Lietotājvārds</label>
                        </div>
                    </div>
                    <div class="col-8 m-2 p-1">
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="28192385">
                            <label for="phone">Mobilais nummurs</label>
                        </div>
                    </div>
                    <div class="col-8 m-2 mb-1 p-1">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" name="password" placeholder="*********" minlength="1"><!--change to 9 for the end fganjrhfvkbhjoawenlknknlk -->
                            <label for="password">parole</label>
                        </div>
                    </div>
                    <div class="col-7 small mb-2">
                        <a href="/login">Ir konts? Spiediet šeit!</a>
                    </div>
                    <div class="col-8">
                        <button type="submit" id="signup_btn" class="btn btn-primary">Pieslēgties</button>
                    </div>

                </div>
            </div>
            <div class="col-3">
                <div id="selectedImage"></div>
                <input id="image_select" accept="image/*" name="image_select" TYPE="FILE"></input>

            </div>

        </form>

    </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $("#signup_form").submit(function(e) {
                e.preventDefault();
                console.log("augh");
                const formData = new FormData(this);
                $.ajax({
                    url: '<?= base_url('post/signup') ?>',
                    method: 'post',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.message);
                        if (response.message[1] == "account_created") {
                            window.location.assign("/home");
                        }
                    }
                });
            })
        });

        var selDiv = "";
        var storedFiles = [];
        $(document).ready(function() {
            $("#image_select").on("change", handleFileSelect);
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
                        "' class='avatar rounded lg' alt='Category Image' height='200px' width='200px'>";
                    selDiv.html(html);
                };
                reader.readAsDataURL(f);
            });
        }
    </script>
</body>

</html>