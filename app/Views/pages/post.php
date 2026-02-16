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

    <div class="row m-2 justify-content-evenly">
        <div class="col-12 p-1 row border border-black justify-content-evenly">
            <div class="col-12 row justify-content-evenly">
                <div id="image" class="col-5 row m-1 p-0 justify-content-center border border-black">
                    <?php echo '<img class="col-auto" style="height: 339px" src="' . base_url('uploads/avatar/' . $post_data[0]['image'][0]) . '">' ?>
                </div>
                <div class="col-4 row m-1 justify-content-evenly">
                    <div id="name" class="col-8 h-25 border border-black">
                        <?= $post_data[0]["title"] ?>
                    </div>
                    <div id="price" class="col-4 h-25 border border-black">
                        <?= $post_data[0]["price"] ?>
                    </div>
                    <div id="tags" class="align-items-start col-12 row h-75 mt-1 p-1 border border-black">
                        <?php foreach ($post_data[0]["tags_id"] as $tag) {
                            echo '<div class="col-md-auto mx-1 border border-black">' . $tag . '</div>';
                        } ?>
                    </div>
                </div>
                <div id="poster" class="col-2 m-1 border border-black">
                    faewwrf
                </div>
            </div>
            <div id="description" class="col-11 my-1  border border-black">
                <?= $post_data[0]["description"] ?>
            </div>
            <div class="col-11 p-1 row border border-black justify-content-evenly">

                <div class="col mb-1 me-1 border border-black">
                    s
                </div>
                <button type="button" class="col-1 mb-1 btn btn-primary btn-sm">RRAGGH</button>


                <div class="border border-black">s</div> <!--comments gonna go here, maybe make it a container or drop them -->
            </div>
        </div>

    </div>








    <?= $footer ?>
</body>

</html>