<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD App Using CI 4 and Ajax</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
  <!-- add new post modal start -->
  <div class="modal fade" id="add_post_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add New Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" enctype="multipart/form-data" id="add_post_form" novalidate>


    <div id="res" class="alert"></div>
    <script type="text/javascript" src="deps/jquery.min.js"></script>
    <script type="text/javascript" src="deps/underscore.js"></script>
    <script type="text/javascript" src="deps/opt/jsv.js"></script>
    <script type="text/javascript" src="lib/jsonform.js"></script>
    <script type="text/javascript">
      $('#add_post_form').jsonForm({
        schema: {
            title: {
                type: 'string',
                fieldHtmlClass: 'form-control',
                required: true
              },
              category: {
                type: 'string',
                fieldHtmlClass: 'form-control',
                required: true
            },
            body: {
                type: 'textarea',
                fieldHtmlClass: 'form-control',
                required: true
            },
            file:{
              type: 'file',
              fieldHtmlClass: 'form-control',
           },
    },
    form: [
        {
          type: "fieldset",
          htmlClass: "modal-body p-5",
          items:[
          {
            key: "title",
            title: 'Post Title',
            placeholder: 'Post Title',
            htmlClass: "mb-3"
          },
          {
            key: "category",
            title: 'Post Category',
            placeholder: 'Category',
            htmlClass: "mb-3"
          },
          {
            key: "body",
            title: 'Post Body',
            placeholder: 'Post Body',
            rows: 4,
            htmlClass: "mb-3"
          },
          {
            key: "file",
            id: "file",
            title: 'Post Image',
            htmlClass: "mb-3"       
          },
        ]
        }
    ],
  });
    </script>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="edit_post_btn">Update Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- add new post modal end -->

  <!-- edit post modal start -->
  <div class="modal fade" id="edit_post_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" enctype="multipart/form-data" id="edit_post_form" novalidate>

    <div id="res" class="alert"></div>
    <script type="text/javascript">
      $('#edit_post_form').jsonForm({
      schema: {
          pid:{
            type: 'hidden',
          },
          old_image:{
            type: 'hidden',
          },
          title: {
            type: 'string',
            fieldHtmlClass: 'form-control',
            required: true
          },
          category: {
            type: 'string',
            fieldHtmlClass: 'form-control',
            required: true
        },
          body: {
            type: 'textarea',
            fieldHtmlClass: 'form-control',
            required: true
        },
          file:{
            name: "image",
            type: 'file',
            fieldHtmlClass: 'form-control',
            required: true
          },
        },
        form: [
          {
          type: "fieldset",
          htmlClass: "modal-body p-5",
          items:[
          {
            key: "pid",
            id: "pid",
            name: "id"

          },
          {
            key: "old_image",
            id: "old_image",
            name: "old_image",
            htmlClass: "mb-3"
          },
          {
            key: "title",
            id: "title",
            title: 'Post Title',
            htmlClass: "mb-3"
          },
          {
            key: "category",
            id: "category",
            title: 'Post Category',
            htmlClass: "mb-3"
          },
          {
            key: "body",
            id: "body",
            title: 'Post Body',
            rows: 4,
            htmlClass: "mb-3"
          },
          {

            key: "file",
            name: "file",
            title: 'Post Image',
            htmlClass: "mb-3"
                      
          },
          {
            type: "section",
            id: "post_image"
          }
        ]   
        }
        ],   
      });
    </script>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="edit_post_btn">Update Post</button>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- edit post modal end -->

  <!-- detail post modal start -->
  <div class="modal fade" id="detail_post_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Details of Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img src="" id="detail_post_image" class="img-fluid">
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
  <!-- detail post modal end -->

  <div class="container">
    <div class="row my-4">
      <div class="col-lg-12">
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
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(function() {
      // add new post ajax request
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

      // edit post ajax request
      $(document).delegate('.post_edit_btn', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        $.ajax({
          url: '<?= base_url('post/edit/') ?>/' + id,
          method: 'get',
          success: function(response) {
            $("#pid").val(response.message.id);
            $("#old_image").val(response.message.image);
            $("#title").val(response.message.title);
            $("#category").val(response.message.category);
            $("#body").val(response.message.body);
            $("#post_image").html('<img src="<?= base_url('uploads/avatar/') ?>/' + response.message.image + '" class="img-fluid mt-2 img-thumbnail" width="150">');
          }
        });
      });

      // update post ajax request
      $("#edit_post_form").submit(function(e) {
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

      // delete post ajax request
      $(document).delegate('.post_delete_btn', 'click', function(e) {
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
      // post detail ajax request
      $(document).delegate('.post_detail_btn', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        $.ajax({
          url: '<?= base_url('post/detail/') ?>/' + id,
          method: 'get',
          dataType: 'json',
          success: function(response) {
            $("#detail_post_image").attr('src', '<?= base_url('uploads/avatar/') ?>/' + response.message.image);
            $("#detail_post_title").text(response.message.title);
            $("#detail_post_category").text(response.message.category);
            $("#detail_post_body").text(response.message.body);
            $("#detail_post_created").text(response.message.created_at);
          }
        });
      });

      // fetch all posts ajax request
      fetchAllPosts();

      function fetchAllPosts() {
        $.ajax({
          url: '<?= base_url('post/fetch') ?>',
          method: 'get',
          success: function(response) {
            $("#show_posts").html(response.message);
          }
        });
      }
    });
  </script>

</body>

</html>