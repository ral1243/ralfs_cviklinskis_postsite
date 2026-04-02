<!DOCTYPE html>
<html lang="lv">

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





  <div class="row p-0 justify-content-center">
    <div class=" col-10 row justify-content-center">

      <div class="col row px-0 py-1 align-items-center bg-white border border-black text-center d-none d-md-flex">
        <div class="col-3">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">Filtrēt</button>
        </div>
        <div class="col-6 ">
          <input id="search-bar1" placeholder="Ko Meklēt"></input>
          <button id="search_confirm" class="btn btn-primary">Meklēt</button>
        </div>
        <div class="col-3">

          <?php
          $session = session();
          if ($session->get('logged_in') == "1") {
            echo "<button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#createModal'>Izveidot</button>";
          } else {
            echo "<a class='btn btn-primary' href='/login'>izveidot jaunu rakstu</a>";
          }
          ?>

        </div>
      </div>

      <div class="col row p-0 py-1 align-items-center justify-content-around bg-white border border-black text-center d-flex d-md-none">
        <div class="col-auto">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">Filtrēt</button>
        </div>
        <div class="col-4 p-0">
          <input id="search-bar2" placeholder="Ko Meklēt" size="9"></input>
          <button id="search_confirm" class="btn btn-primary">Meklēt</button>
        </div>
        <div class="col-auto">

          <?php
          $session = session();
          if ($session->get('logged_in') == "1") {
            echo "<button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#createModal'>Izveidot</button>";
          } else {
            echo "<a class='btn btn-primary' href='/login'>izveidot jaunu rakstu</a>";
          }
          ?>

        </div>
      </div>
      <div id="container-body" class="col-12 row row-cols-auto border border-black justify-content-around p-0">
        <!--where posts get shown-->
      </div>
    </div>
    <div class="col-1 ms-1 container-sm bg-white border border-black m-0 d-none d-lg-flex">interesanti jaunumi par saiti</div>
  </div>


  <div class="modal fade" id="filterModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Filtri</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h1> Mebeles </h1>
          <button id="button_test" type="button" class="btn btn-primary" data-bs-toggle="button" value="1">Krēsli</button>
          <button id="button_test" type="button" class="btn btn-primary" data-bs-toggle="button" value="2">Gultas</button>
          </optgroup>
          <h1> Malka </h1>
          <button id="button_test" type="button" class="btn btn-primary" data-bs-toggle="button" value="3">Egle</button>
          <button id="button_test" type="button" class="btn btn-primary" data-bs-toggle="button" value="4">Bērzs</button>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aizvert</button>
          <button id="tag_filter_confirm" type="button" class="btn btn-primary" data-bs-dismiss="modal">Filtrēt</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="createModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Raksta Izveidošana</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="tab">
            <button class="tablinks" id="default_tab" onclick="openTab(event, 'Main_field')">Galvenie lauki</button>
            <button class="tablinks" onclick="openTab(event, 'titleimage')">Bildes</button>
            <button class="tablinks" onclick="openTab(event, 'Tag_field')">Tags</button>
          </div>
          <form id="post_form">


            <div id="Main_field" class="tabcontent">
              <label for="title">Nosaukums:</label><br>
              <input type="text" id="title" name="title" placeholder="Malka/Mebeles...."><br>
              <label for="price">Cena:</label><br>
              <input type="text" id="price" name="price" placeholder="10,50">€<br>



              <!--<label for="description">Apraksts:</label><br>
              <textarea id="description" name="description" rows="4" cols="50" placeholder="10x20cm...."></textarea><br><br>
-->

              <label for="ql-editor">Apraksts:</label>
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
                <div id="editor">

                </div>
              </div>

            </div>

            <div id="titleimage" class="tabcontent">
              <input type="file" multiple id="titleimage" name="titleimage[]" class="mb2" accept="image/*" onchange="displaySelectedFiles(this)" /></input>
              <div id="fileList"></div>
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
              <button onclick="combineData()" type="submit" id="add_post_form" class="btn btn-primary">Izveidot Rakstu</button>
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
        dropdownParent: $('#createModal'),

      });
    });


    const quill = new Quill("#editor", {
      placeholder: "Apraksts",
      theme: "snow",
      modules: {
      toolbar: '#toolbar-container',
    },
    });


    $(function() {

      fetchAllPosts();

      function fetchAllPosts() { //ar ajax request parāda visus saglabātos rakstus


        var condition = "none";
        $.ajax({
          url: '<?= base_url('post/fetch/') ?>' + condition,
          method: 'get',
          success: function(response) {
            $("#container-body").html(response.message);
          }
        });
      }

      $(document).delegate('#search_confirm', 'click', function() {
        var condition = "search-";
        var search1 = document.getElementById("search-bar1").value;
        var search2 = document.getElementById("search-bar2").value;
        if (search1 == "") {
          condition += search2;
        } else {
          condition += search1;
        }
        $.ajax({
          url: '<?= base_url('post/fetch/') ?>/' + condition,
          method: 'get',
          success: function(response) {
            $("#container-body").html(response.message);
          }
        });
      });

      $(document).delegate('#tag_filter_confirm', 'click', function() {
        var condition = "tags"
        var selected_tags = "";
        document.querySelectorAll('#button_test.btn.btn-primary.active').forEach(buttonElement => {
          selected_tags += "-" + buttonElement.value;
          bootstrap.Button.getOrCreateInstance(buttonElement).toggle();
        })
        condition += selected_tags;
        if (condition == "tags") {
          condition = "none"
        };
        console.log(condition);
        $.ajax({
          url: '<?= base_url('post/fetch/') ?>/' + condition,
          method: 'get',
          success: function(response) {
            $("#container-body").html(response.message);
          }
        });
      });

      $("#post_form").submit(function(e) { // ar ajax request saglabā form
        e.preventDefault();
        const form = document.getElementById("post_form");
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
              var $tagselect = $("#tagselect").select2({
                placeholder: 'izvēlieties tags',
                dropdownParent: $('#createModal'),
              });
              $tagselect.val(null).trigger("change");
              location.reload();

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

          }
        });
      });

      $(document).delegate('.post_delete_button', 'click', function(e) { //ar ajax request izdzēš saglabāto post
        e.preventDefault();
        const id = $(this).attr('id');
        console.log(id);
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


      $(document).delegate('.post', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        window.location.assign("detail/" + id);
      });



      //fetchTags();

      var selectedTags = [];

      function fetchTagsaaaaaaaaaaa() { //most likely remove
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


    });
  </script>

</body>

</html>