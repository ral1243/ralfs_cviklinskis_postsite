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
        <div class="col-8 border border-black justify-content-center p-3">
            <form>
                <div class="row justify-content-center">
                    <div class="col-12 ">
                        Ielogojaties savā kontā
                    </div>
                    <div class="col-8 m-2 p-1">
                        <div class="form-floating ">
                            <input type="email" class="form-control" id="email" placeholder="name@example.com">
                            <label for="email">Epasts</label>
                        </div>
                    </div>
                    <div class="col-8 m-2 p-1">
                        <div class="form-floating">
                            <input class="form-control" id="username" placeholder="super sigma">
                            <label for="username">Lietotājvārds</label>
                        </div>
                    </div>
                    <div class="col-8 m-2 p-1">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="phone" placeholder="554134141">
                            <label for="phone">Mobilais nummurs</label>
                        </div>
                    </div>
                    <div class="col-8 m-2 mb-1 p-1">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" placeholder="*********">
                            <label for="password">parole</label>
                        </div>
                    </div>
                    <div class="col-7 small mb-2">
                        <a href="/login">Ir konts? Spiediet šeit!</a>
                    </div>
                    <div class="col-8">
                        <button id="signup-confirm" class="btn btn-primary">Pieslēgties</button>
                    </div>

                </div>
            </form>
        </div>
        <div class="col-2">bilde</div>
    </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        $(function() {
            $("#signup-confirm").on("click", function(e) {
                e.preventDefault();
                const signup = [];
                signup[0] = document.getElementById("email").value; 
                signup[1] = document.getElementById("username").value;
                signup[2] = document.getElementById("phone").value;
                signup[3] = document.getElementById("password").value;
                $.ajax({
                    url: '<?= base_url('post/signup/') ?>/' + signup,
                    method: 'post',
                    success: function(response) {
                        console.log(response.message);
                        if(response.message["login"] == "account_created"){
                            window.location.assign("/home")
                            <?php $session->set('logged_in', "1"); ?>
                        }else{                           
                            console.log("stinky") 
                        }
                        
                    }
                });
            })  
        });
    </script>
</body>

</html>