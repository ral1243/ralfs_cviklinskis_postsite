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
  <script src="/js/home.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<body>
  <?= $header ?>




  <!-- <div style="text-align:right">
  <form action="#" method="POST" id="login">
  <input type="text" style=align-right aria-label="Close" placeholder="username" id="log_username" ></input>  pattern="[^\,]" 
  <input type="text" style=align-right aria-label="Close" placeholder="password" id="log_password" ></input> pattern="[a-zA-Z]{*8}" 
  <input type="submit" value="Log In">
  </form>
  <form action="#" method="POST" id="signin">
  <input type="text" style=align-right aria-label="Close" placeholder="username" id="username" ></input>  pattern="[^\,]" 
  <input type="text" style=align-right aria-label="Close" placeholder="email" id="email" ></input>
  <input type="text" style=align-right aria-label="Close" placeholder="phone" id="phone" ></input>
  <input type="text" style=align-right aria-label="Close" placeholder="password" id="password" ></input> pattern="[a-zA-Z]{*8}" 
  <input type="submit" value="Sign In">
  </form>
  

 <input type="text" style=align-right aria-label="Close" placeholder="username" id="username"></input>
 <input type="password" style=align-right aria-label="Close" placeholder="password"></input>
 <button type="button" style=align-right aria-label="Close" id="login_button">login</button> 
 </div>-->



  <!-- add new post start -->

  <div class="row p-0 justify-content-evenly">
    <div class=" col-10 p-0 row border border-black">
      <div class="col row p-0 align-items-center bg-white border border-black text-center">
        <div class="col-3">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">Filtrēt</button>
        </div>
        <div class="col-6">
          <input id="search-bar" placeholder="Ko Meklēt"></input>
          <button class="btn btn-primary">Meklēt</button>
        </div>
        <div class="col-3">
          <?php
        $session = session();
        if ($session->get('logged_in') == "1") {
          echo "<button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#createModal'>izveidot jaunu rakstu</button>";
        } else {
          echo "<a class='btn btn-primary' href='/login'>izveidot jaunu rakstu</a>";
        }
        ?>
        </div>
      </div>
      <div id="container-body" class="col-12 row border border-black justify-content-start p-0">
        <!--where posts get shown-->
      </div>
    </div>
    <div class="col-1 container-sm bg-white border border-black m-0">interesanti jaunumi par saiti</div>
  </div>


  <div class="modal fade" id="filterModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Filtri</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aizvert</button>
          <button type="button" class="btn btn-primary">Filtrēt</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="createModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Raksta Izveidošana</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="#" method="POST" enctype="multipart/form-data" id="add_post_form" novalidate>
            <div id="res" class="alert"></div>
            <script type="text/javascript" src="deps/jquery.min.js"></script>
            <script type="text/javascript" src="deps/underscore.js"></script>
            <script type="text/javascript" src="deps/opt/jsv.js"></script>
            <script type="text/javascript" src="lib/jsonform.js"></script>
            <script type="text/javascript">
              //izveido form priekš POST veidošanas
              JSONForm.fieldTypes['multiplefileupload'] = {
                template: `
                  <input type="file" multiple id="titleimage" name="titleimage[]" 
                  class="form-control mb2" accept="image/*" onchange="displaySelectedFiles(this)" />
                  <div id="fileList"></div>`
              };

              JSONForm.fieldTypes['select2tags'] = {
                template: `
                <select id="tagselect" class="js-example-basic-multiple" name="states[]" multiple="multiple"> 
                <option value="AL">Alabama</option>
                <option value="WY">Wyoming</option>
                <option value="Wk">Wyomingaaaaa</option>
                </select>`
              }
              $('#add_post_form').jsonForm({
                schema: {
                  "title": "Book Form", //nodefinē katru elementu
                  "type": "object",
                  "properties": {
                    "title": {
                      "type": "string",
                      "required": "true",
                      "title": "Raksta Nosaukums"
                    },
                    "category": {
                      "type": "string",
                      "required": "true",
                      "title": "fwaffewafw"
                    },
                    "body": {
                      "type": "string",
                      "required": "true",
                      "title": "Raksta Apraksts"
                    },
                    "tags": {
                      "type": "string",
                      "class": "js-example-basic-multiple",
                      "multiple": "multiple",
                      "title": "Tags"
                    }
                  },
                },
                form: [{
                  "type": "fieldset", //katru elementu ieliek formā
                  "title": "Sadaļas:",
                  "items": [{
                    "type": "tabs",
                    "id": "navtabs",
                    "items": [{
                        "title": "Galvenie Lauki",
                        "type": "tab",
                        "items": [
                          "title",
                          "category",
                          "body",
                        ]
                      },
                      {
                        "title": "Bildes",
                        "type": "tab",
                        "items": [{
                          "type": "multiplefileupload"
                        }, ]
                      },
                      {
                        "title": "Tags",
                        "type": "tab",
                        "items": [{
                          "type": "select2tags"
                        }, ]
                      },
                    ]
                  }]
                }]
              });
              displaySelectedFiles()
            </script>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aizvert</button>
          <button type="button" class="btn btn-primary">Izveidot Rakstu</button>
        </div>
      </div>
    </div>
  </div>


  <!-- detail post modal start -->
  <div id="hide">
    <div class="modal fade" id="detail_post_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Details of Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="detail_post_image" class="img-fluid"> </div>
            <h3 id="detail_post_title" class="mt-3"></h3>
            <h5 id="detail_post_category"></h5>
            <p id="detail_post_body"></p>
            <p id="detail_post_created" class="fst-italic"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- detail post modal end -->
  <!-- post konteinera starts-->



  <!-- <div class="container">
    <div class="row my-4">
      <div class="col-9">
        <div class="card shadow">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div class="text-secondary fw-bold fs-3">All Posts</div>
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#add_post_modal">Add New Post</button>
          </div>
          <div class="card-body">
            <div class="row" id="show_posts">
              <h1 class="text-center text-secondary my-5">Posts Loading..</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="col-3">
        <h3>Tags</h3>                              parāda visus saglabātos tags 
        <div id="filter_tags_display">
        </div>
        <button class="btn btn-dark" id="selectedTags" >Filter By Tags</button>    pievieno pogu kuru uzpiežot visus post filtrēs pēc tags 
      </div>
      </div>
    </div>
  </div>-->
  <?=  $footer ?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(function() {
      $('.js-example-basic-multiple').select2({
        placeholder: 'izvēlieties tags'

      });
    });


    var tags = [];
    var selectedTags = [];
    $(function() { // ar ajax request saglabā form
      
      $("#add_post_form").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
          $("#add_post_btn").text("Adding...");
          $.ajax({
            url: '<?= base_url('post/add') ?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              if (response.error) {
                $("#image").addClass('is-invalid');
                $("#image").next().text(response.message.image);
              } else {
                $("#add_post_modal").modal('hide');
                $("#add_post_form")[0].reset();
                $("#image").removeClass('is-invalid');
                $("#image").next().text('');
                $("#add_post_form").removeClass('was-validated');
                Swal.fire(
                  'Added',
                  response.message,
                  'success'
                );
                fetchAllPosts();
              }
              $("#add_post_btn").text("Add Post");
            }
          });
        }
      });

      $(document).delegate('.post_edit_btn', 'click', function(e) { //ar ajax request parāda saglabāto post form
        e.preventDefault();
        const id = $(this).attr('id');
        $.ajax({
          url: '<?= base_url('post/edit/') ?>/' + id,
          method: 'get',
          success: function(response) {
            imagename = JSON.parse(response.message.image, true);
            tagname = JSON.parse(response.message.tags, true);
            $("#pid").val(response.message.id);
            $("#title").val(response.message.title);
            $("#category").val(response.message.category);
            $("#body").val(response.message.body);
            showOldFiles(imagename);
          }
        });
      });

      $("#edit_post_form").submit(function(e) { //ar ajax request rediģē saglabāto post
        e.preventDefault();
        const formData = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
          $("#edit_post_btn").text("Updating...");
          $.ajax({
            url: '<?= base_url('post/update') ?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              $("#edit_post_modal").modal('hide');
              Swal.fire(
                'Updated',
                response.message,
                'success'
              );
              fetchAllPosts();
              $("#edit_post_btn").text("Update Post");
            }
          });
        }
      });

      $(document).delegate('.post_delete_btn', 'click', function(e) { //ar ajax request izdzēš saglabāto post
        e.preventDefault();
        const id = $(this).attr('id');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?= base_url('post/delete/') ?>/' + id,
              method: 'get',
              success: function(response) {
                Swal.fire(
                  'Deleted!',
                  response.message,
                  'success'
                )
                fetchAllPosts();
              }
            });
          }
        })
      });

      $(document).delegate('.post_detail_btn', 'click', function(e) { //ar ajax request parāda post informāciju
        e.preventDefault();
        const id = $(this).attr('id');
        $.ajax({
          url: '<?= base_url('post/detail/') ?>/' + id,
          method: 'get',
          dataType: 'json',
          success: function(response) {
            var oldfiles = "";
            oldi = 0;
            var imagename = JSON.parse(response.message.image, true);
            document.getElementById('detail_post_image').innerHTML = '';
            console.log(imagename);
            imagename.forEach(element => {
              oldfiles += ('<img src="<?= base_url('uploads/avatar/') ?>/' + imagename[oldi].filename + '" id=detailfiles' + oldi + ' class="img-fluid mt-2 img-thumbnail" width="300"><br>');
              oldi++;
            });
            $("#detail_post_image").html(oldfiles);
            $("#detail_post_title").text(response.message.title);
            $("#detail_post_category").text(response.message.category);
            $("#detail_post_body").text(response.message.body);
            $("#detail_post_created").text(response.message.created_at);
          }
        });
      });

      fetchAllPosts();

      function fetchAllPosts() { //ar ajax request parāda visus saglabātos post
        var tagurl = 'empty';
        $.ajax({
          url: '<?= base_url('post/fetch/') ?>/' + tagurl,
          method: 'get',
          success: function(response) {
            $("#container-body").html(response.message);
          }
        });
      }

      //fetchTags();

      function fetchTags() { //ar ajax request dabū visus tags
        $.ajax({
          url: '<?= base_url('post/fetchTags') ?>',
          method: 'get',
          success: function(posts) {
            for (var i = 0; i < posts.message.length; i++) {
              tags.push(JSON.parse(posts.message[i]));
            }
            for (var i = 0; i < tags.length; i++) {
              const fileListDiv = document.getElementById('filter_tags_display');
              const test = document.createElement('button');
              if (tags[i] != "") {
                test.textContent = tags[i];
                test.id = "tag" + i;
                test.type = "button";
                test.className = "btn btn-secondary";
                test.style.float = "left";
                test.style.width = "auto";
                fileListDiv.appendChild(test);
                $("#tag" + i).on("click", function() {
                  var x = document.getElementById(this.id);
                  if (x.style.backgroundColor == "darkblue") {
                    x.style.backgroundColor = "";
                    selectedTags.splice(selectedTags.indexOf(x.innerHTML), 1);
                  } else {
                    x.style.backgroundColor = "darkblue";
                    selectedTags.push("'" + x.innerHTML + "'");
                  }
                });
              }
            }
          }
        });
      }

      $("#selectedTags").on("click", function() { //ar ajax request filtrē visus post pēc izvēlētajiem tags
        tagurl = "empty";
        if (selectedTags.length > 0) {
          tagurl = selectedTags;
        }
        console.log(tagurl);
        $.ajax({
          url: '<?= base_url('post/fetch/') ?>/' + tagurl,
          method: 'get',
          success: function(response) {
            $("#show_posts").html(response.message);
          }
        });
      })

      $("#login").submit(function(e) {
        e.preventDefault();
        const login = [];
        login[0] = '"' + document.getElementById("username").value + '"';
        login[1] = '"' + document.getElementById("password").value + '"';
        $.ajax({
          url: '<?= base_url('post/login/') ?>/' + login,
          method: 'post',
          success: function(response) {
            console.log(response.message);
          }
        });
      })

      $("#signin").submit(function(e) {
        e.preventDefault();
        const signin = [];
        signin[0] = '"' + document.getElementById("username").value + '"';
        signin[1] = '"' + document.getElementById("email").value + '"';
        signin[2] = '"' + document.getElementById("phone").value + '"';
        signin[3] = '"' + document.getElementById("password").value + '"';
        console.log(signin);
        $.ajax({
          url: '<?= base_url('post/signin/') ?>/' + signin,
          method: 'post',
          success: function(response) {
            response = response.message;
            response = response.login;
            response = response.split(",");
            console.log(response);
          }
        });
      })
    });
  </script>

</body>

</html>