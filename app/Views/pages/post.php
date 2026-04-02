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
    <script src="/js/js1.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link
        href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css"
        rel="stylesheet" />
</head>

<body>

    <?= $header ?>

    <div style="display:none;" class="post_id" id=<?= $post_data[0]["id"] ?>></div>


    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Raksta Rediģēšana</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="tab">
                        <button class="tablinks" id="default_tab" onclick="openTab(event, 'Main_field')">Galvenie lauki</button>
                        <button class="tablinks" onclick="openTab(event, 'titleimage')">Bildes</button>
                        <button class="tablinks" onclick="openTab(event, 'Tag_field')">Tags</button>
                    </div>
                    <form id="post_form">

                        <input style="display:none;" type="text" id="postID" name="postID" value="<?= $post_data[0]["id"] ?>">
                        <input style="display:none;" type="text" id="oldimages" name="oldimages" value='<?= json_encode($post_data[0]['image']) ?>'>


                        <div id="Main_field" class="tabcontent">


                            <label for="title">Nosaukums:</label><br>
                            <input type="text" id="title" name="title" value="<?= $post_data[0]["title"] ?>"><br>
                            <label for="price">Cena:</label><br>
                            <input type="text" id="price" name="price" value="<?= $post_data[0]["price"] ?>">€<br>

                            <label for="quilledit">Apraksts:</label>
                            <div id="description" name="description">
                                <div id="toolbar-container">
                                    <span class="ql-formats">
                                        <select class="ql-font"></select>
                                        <select class="ql-size"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        <button class="ql-strike"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-header" value="1"></button>
                                        <button class="ql-header" value="2"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-list" value="ordered"></button>
                                        <button class="ql-list" value="bullet"></button>
                                        <button class="ql-indent" value="-1"></button>
                                        <button class="ql-indent" value="+1"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-clean"></button>
                                    </span>
                                </div>
                                <div id="quilledit">
                                </div>
                            </div>
                        </div>

                        <div id="titleimage" class="tabcontent">
                            <input type="file" multiple id="titleimage" name="titleimage[]" class="mb2" accept="image/*" onchange="displaySelectedFiles(this)" /></input>
                            <div id="fileList">

                                <div id="oldFileList" class="justify-content-start ">
                                    <?php
                                    foreach ($post_data[0]['image'] as $image) {
                                        echo ' <img class="d-block m-0" style="height: 100px" src="' . base_url('uploads/avatar/' . $image) . '"> ';
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div id="Tag_field" class="tabcontent">
                            <select id="tagselect" class="tag-select" name="states[]" multiple="multiple">
                                <optgroup label="Mebeles">
                                    <option value="1">Krēsli</option>
                                    <option value="2">Gultas</option>
                                </optgroup>
                                <optgroup label="Malka">
                                    <option value="3">Egle</option>
                                    <option value="4">Bērzs</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aizvert</button>
                            <button onclick="combineData()" type="submit" id="edit_post_form" class="btn btn-primary">Rediģēt Rakstu</button>
                        </div>
                    </form>
                </div>


                <script>
                    document.getElementById("default_tab").click();

                    function openTab(evt, tabName) {
                        var i, tabcontent, tablinks;
                        tabcontent = document.getElementsByClassName("tabcontent");
                        for (i = 0; i < tabcontent.length; i++) {
                            tabcontent[i].style.display = "none";
                        }
                        tablinks = document.getElementsByClassName("tablinks");
                        for (i = 0; i < tablinks.length; i++) {
                            tablinks[i].className = tablinks[i].className.replace(" active", "");
                        }
                        document.getElementById(tabName).style.display = "block";
                        evt.currentTarget.className += " active";
                    }
                </script>
            </div>

        </div>
    </div>


    <div class="modal fade" id="imageModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="mb-3">
                        <img class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row m-2 justify-content-evenly">
        <div class="col-12 p-1 row border border-black justify-content-evenly">
            <div class="col-12 px-4 row justify-content-evenly">
                <div id="image_container" class="col-7 row m-0 p-0 justify-content-center border border-black">
                    <div id="carouselExample" class="carousel slide">
                        <div class="carousel-indicators">
                            <?php
                            for ($i = 0; $i < count($post_data[0]['image']); $i++) {
                                if ($i == 0) {
                                    echo '<button type="button" data-bs-target="#carouselExample" data-bs-slide-to="' . $i . '" class="active" aria-current="true" aria-label="Slide ' . $i . '"></button>';
                                } else {
                                    echo '<button type="button" data-bs-target="#carouselExample" data-bs-slide-to="' . $i . '" aria-label="Slide ' . $i . '"></button>';
                                }
                            }
                            ?>
                        </div>
                        <div class="carousel-inner">

                            <?php
                            for ($i = 0; $i < count($post_data[0]['image']); $i++) {
                                if ($i == 0) {
                                    echo '<div class="row carousel-item active justify-content-center" style="max-height: 400px; min-height: 300px">
                                          <img class=" mx-auto d-block"  src="' . base_url('uploads/avatar/' . $post_data[0]['image'][$i]) . '" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="' . base_url('uploads/avatar/' . $post_data[0]['image'][$i]) . '">
                                          </div>';
                                } else {
                                    echo   '<div class="row carousel-item " style="max-height: 400px; min-height: 300px">
                                            <img class=" mx-auto d-block"  src="' . base_url('uploads/avatar/' . $post_data[0]['image'][$i]) . '" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="' . base_url('uploads/avatar/' . $post_data[0]['image'][$i]) . '">
                                            </div>';
                                }
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>


                </div>
                <div class="col-4 row m-0 p-0 justify-content-evenly align-items-start">
                    <div id="poster" class="col-12 row mb-1 border border-black">
                        <div class="col-12">
                            <?php echo '<img class="" style="height: 75px" src="' . base_url('uploads/avatar/' . $account_info[0]['image']) . '">' . $account_info[0]['username']  ?>
                        </div>
                    </div>
                    <div id="name" class="col-8 h-25 border border-black">
                        <?= $post_data[0]["title"] ?>
                    </div>
                    <div id="price" class="col-4 h-25 border border-black">
                        <?= $post_data[0]["price"] ?>
                    </div>
                    <div id="tags" class="align-items-start col-12 row mt-1 p-1 border border-black">
                        <?php $session = session();
                        $i = 0;
                        foreach ($post_data[0]["tags"] as $tag) {
                            echo '<div id="' . $post_data[0]["tags_id"][$i] . '" class="post_tags col-md-auto mx-1 border border-black">' . $tag . '</div>';
                            $i++;
                        } ?>
                    </div>

                    <?php
                    if ($session->get('account_id') == $post_data[0]['account_id']) {
                        echo '<div class="col-12 p-1 border border-black">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" id="' . $post_data[0]["id"] . '" >Rediģēt</button>
                             <a href="#" class="post_delete_button" id="' . $post_data[0]["id"] . '" ">Dzēst</a>
                             </div>';
                    }

                    ?>

                </div>

            </div>
            <div id="description" class="col-11 my-1  border border-black">
                <div id="toolbar-container">
                </div>
                <div id="quilldescription">
                    <?= $post_data[0]["description"] ?>
                </div>
            </div>


            <div class="col-11 p-1 row border border-black justify-content-evenly">

                <div class="col-12 row justify-content-center">
                    <?php
                    if ($session->get("logged_in") == "1") {
                        echo ('<input id="comment" class="col-10" type="text"></input>
                        <button id="post_comment" type="button" class="col-1 m-0 btn btn-primary btn-sm">Komentēt</button>');
                    } else {
                        echo ('<div class="col-11 border border-black text-start">Ierakstieties savā kontā lai komentētu</div>');
                    }

                    ?>

                </div>


                <div id="comment_container" class="col-11 my-1 mx-0 justify-content-center"></div>
                <button id="show_comments" type="button" class="btn btn-primary">Rādīt Vairāk Komentārus</button><!--comments gonna go here, maybe make it a container or drop them -->
            </div>
        </div>

    </div>








    <?= $footer ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
    <script>
        $(function() {
            $('#tagselect').select2({
                placeholder: 'izvēlieties tags',
                dropdownParent: $('#editModal'),

            });
        });

        var desc = document.getElementById("quilldescription").innerText
        desc = desc.replace("' ", "");
        desc = desc.replace(" '", "");
        desc = JSON.parse(desc);
        const quilldesc = new Quill("#quilldescription", {
            placeholder: "Apraksts",
            theme: "snow",
            modules: {
                toolbar: false
            }
        });
        quilldesc.enable(false);
        quilldesc.setContents(desc);

        const quill = new Quill("#quilledit", {
            placeholder: "Apraksts",
            theme: "snow",
            modules: {
                toolbar: '#toolbar-container',
            },
        });
        quill.setContents(desc);


        const exampleModal = document.getElementById('imageModal')
        if (exampleModal) {
            exampleModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const recipient = button.getAttribute('data-bs-image')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const modalTitle = exampleModal.querySelector('.modal-title')
                const modalBodyInput = exampleModal.querySelector('.modal-body img')

                //modalTitle.textContent = `New message to ${recipient}`
                modalBodyInput.src = recipient
            })
        }


        $(function() {

            listTags();

            function listTags() {
                var temp = document.getElementsByClassName("post_tags");
                var tag_array = [];
                for (var i = 0; i < temp.length; i++) {
                    tag_array.push(temp[i].id)
                }
                $('#tagselect').val(tag_array);
                $('#tagselect').trigger('change');
            };


            $(document).delegate('#post_comment', 'click', function(e) { //ar ajax saglabā komentārus
                e.preventDefault();
                var post_id = document.getElementsByClassName("post_id");
                var comment = document.getElementById("comment").value;
                var contents = post_id[0].id + "," + comment;
                if (comment != "") {
                    $.ajax({
                        url: '<?= base_url('comment/add/') ?>' + contents,
                        method: 'post',
                        success: function(response) {
                            $("#comment_container").prepend(response.message);
                            document.getElementById("comment").value = "";
                        }
                    });
                }
            });

            var last_comment_id;
            fetchComments();

            function fetchComments() {
                var post_id = document.getElementsByClassName("post_id");
                var comment_id = "0";
                contents = post_id[0].id + "," + comment_id;
                $.ajax({
                    url: '<?= base_url('comment/fetch/') ?>/' + contents,
                    method: 'get',
                    success: function(response) {
                        last_comment_id = response.id;
                        if (response.message != "") {
                            $("#comment_container").html(response.message);
                        }
                    }
                });
            }


            $(document).delegate('#show_comments', 'click', function(e) { //ar ajax request parāda komentārus
                var post_id = document.getElementsByClassName("post_id");
                var comment_id = "1";
                contents = post_id[0].id + "," + last_comment_id;
                $.ajax({
                    url: '<?= base_url('comment/fetch/') ?>/' + contents,
                    method: 'get',
                    success: function(response) {
                        last_comment_id = response.id
                        $("#comment_container").add(response.message).appendTo(document.getElementById("comment_container"));
                    }
                });
            })


            $("#post_form").submit(function(e) {
                e.preventDefault();
                const form = document.getElementById("post_form");
                const formData = new FormData(this);
                $.ajax({
                    url: '<?= base_url('post/edit') ?>',
                    method: 'post',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        location.reload();
                    }
                });

            });


            $(document).delegate('.post_delete_button', 'click', function(e) { //ar ajax request parāda komentārus
                var post_id = document.getElementsByClassName("post_id");
                post_id = post_id[0].id;
                Swal.fire({
                    title: 'Vai jūs esat pārliecināti?',
                    text: "Jūs šo nevarēsiet atsaukt!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Atcelt',
                    confirmButtonText: 'Piekrītu'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('post/delete/') ?>/' + post_id,
                            method: 'get',
                            success: function(response) {
                                if (response.message == "success") {
                                    window.location.assign("/home");
                                }
                            }
                        });
                    }
                })
            })

            $(document).delegate('.delete_comment', 'click', function(e) { //ar ajax request parāda komentārus
                comment_id = this.id,
                    comment_id = comment_id.split("_")
                comment_id = comment_id[0]
                Swal.fire({
                    title: 'Vai jūs esat pārliecināti?',
                    text: "Jūs šo nevarēsiet atsaukt!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Atcelt',
                    confirmButtonText: 'Piekrītu'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('comment/delete/') ?>' + comment_id,
                            method: 'post',
                            success: function(response) {
                                if (response.message == "success") {
                                    document.getElementById(comment_id + "_comment").remove();
                                }
                            }
                        });
                    }
                })
            })


            $(document).delegate('.edit_comment_confirm', 'click', function(e) { //ar ajax request parāda komentārus
                var comment_id = this.id;
                comment_id = comment_id.split("_")
                comment_id = comment_id[0]
                var comment = document.getElementById(comment_id + "_comment_text").value;
                full_comment = comment_id + "_" + comment;
                $.ajax({
                    url: '<?= base_url('comment/edit/') ?>' + full_comment,
                    method: 'post',
                    success: function(response) {
                        if (response.message == "success") {
                            const input = document.createElement("div");
                            input.setAttribute("id", comment_id + "_comment_text");
                            input.setAttribute("class", "col-11 mb-1 border border-black");
                            input.setAttribute("value", comment);
                            input.innerText = comment;
                            document.getElementById(comment_id + "_comment_text").replaceWith(input);

                            const deletebtn = document.createElement("button");
                            deletebtn.setAttribute("id", comment_id + "_delete");
                            deletebtn.setAttribute("class", "delete_comment col m-1 btn btn-primary btn-sm");
                            deletebtn.innerText = "Dzēst";
                            document.getElementById(comment_id + "_cancel").replaceWith(deletebtn);

                            const edit = document.createElement("button");
                            edit.setAttribute("id", comment_id + "_edit");
                            edit.setAttribute("class", "edit_comment col m-1 btn btn-primary btn-sm ");
                            edit.setAttribute("onclick", "commentEdit(this.id)")
                            edit.innerText = "edit";
                            document.getElementById(comment_id + "_edit").replaceWith(edit);
                        }
                    }
                });

            })


        })
    </script>
</body>

</html>