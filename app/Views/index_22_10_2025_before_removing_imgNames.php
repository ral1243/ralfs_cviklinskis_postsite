<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD App Using CI 4 and Ajax</title>
  <link rel="stylesheet" href="/css/home.css"> </link>
  <link rel="stylesheet" href="/css/header.css"> </link>
  <script src="/js/home.js"></script>
  <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">--> 

</head>

<body>
<div id="header" >
  <div id="logo"> logologologologologo </div>
  <div id="page-container">
<a id="page-link">page1</a>
<a id="page-link">page2</a>
<a id="page-link">page3</a>
  </div>
  <div id="user">
    <div id="username"> username</div> 
    <div id="pfp"> </div>
  </div>
</div>
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



  <!-- filter post modal start 
<div id="hide">
  <div class="modal fade" id="filter_post_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">  
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Filter Posts</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Click Me!</button>
        </div>
      </div>
    </div>
  </div>

   filter post modal end -->

  <!-- add new post modal start -->
  <div id="container">
    <div id="container-head">
      <button id="open-filter-post-button">Filtrēt</button>
        <div>
         <input  id="search-bar" placeholder="Ko Meklēt"></input>
         <button id="search">Meklēt</button>
        </div>
      <button id="open-create-post-button" onclick="post_creator_toggle()">izveidot jaunu rakstu</button>  <!-- relink to login if not loged in -->
    </div>
    <div id="container-body"></div>
  </div>

      <div id="post-creation">
        <form action="#" method="POST" enctype="multipart/form-data" id="add_post_form" novalidate>
    <div id="res" class="alert"></div>
    <script type="text/javascript" src="deps/jquery.min.js"></script>
    <script type="text/javascript" src="deps/underscore.js"></script>
    <script type="text/javascript" src="deps/opt/jsv.js"></script>
    <script type="text/javascript" src="lib/jsonform.js"></script>
    <script type="text/javascript">                                     //izveido form priekš POST veidošanas
              JSONForm.fieldTypes['multiplefileupload'] = {
        template: `
                  <input type="file" multiple id="titleimage" name="titleimage[]" 
                  class="form-control mb2" accept="image/*" onchange="displaySelectedFiles(this)" />
                  <div id="fileList"></div>`
        };
      $('#add_post_form').jsonForm({ 

        schema: {
        "title": "Book Form",                                     //nodefinē katru elementu
        "type": "object",
        "properties": {
            "title": {"type": "string", "required": "true", "title": "Raksta Nosaukums"},
            "category": {"type": "string", "required": "true", "title": "fwaffewafw"},
            "body": {"type": "string", "required": "true", "title": "Raksta Apraksts"},
            "tags": {"type": "array", "class": "form-control",  "title": "Tag", "items": { "type": "string", "title": "Tag {{idx}}", "htmlClass": "m-3", "required": "true"}}
        },
      },  
    form: [{
        "type": "fieldset",                             //katru elementu ieliek formā
        "title": "Sadaļas:",
        "items": [{
            "type": "tabs",
            "id": "navtabs",
            "items": [
                {
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
                    "items": [
                      {"type": "multiplefileupload"},
                    ]
                },
                {
                    "title": "Tags",
                    "type": "tab",
                    "items": [
                       "tags"
                    ]
                },
            ]
        }]
    }]
  });

   let selectedFiles = [];
   let fullNamearray = [];
function displaySelectedFiles(input) {                        //parāda izvēlētās bildes formā ar checkbox pie tām
  const fileListDiv = document.getElementById('fileList');
  fileListDiv.innerHTML = ''; 

  if (input.files.length > 0) {
    selectedFiles = Array.from(input.files);  
    const list = document.createElement('ul');
    
    for (let i = 0; i < selectedFiles.length; i++) {
      const file = selectedFiles[i];
      const listItem = document.createElement('li');
      listItem.style.display = 'flex';
      listItem.style.alignItems = 'center';

      const img = document.createElement('img');              //parāda bildi
      img.style.Width = '150px';  
      img.style.maxHeight = '100px';
      img.style.marginRight = '10px';
      img.style.marginLeft = '50px';
      listItem.appendChild(img); 

      const titleName = document.createElement('input');      //parāda nosaukumu
      titleName.id = 'titleName'+i;
      titleName.type = "text";
      titleName.value = file.name;
      listItem.appendChild(titleName); 
      
      const checkbox = document.createElement('input');       //parāda checkbox
      checkbox.id = 'checkbox'+i;
      checkbox.type = 'checkbox';
      checkbox.value = i;  
      checkbox.style.marginLeft = '10px';
      listItem.appendChild(checkbox);

      const fileLabel = document.createElement('label');      //parāda tekstu pie checkbox
      fileLabel.setAttribute("for", 'checkbox'+i);
      fileLabel.textContent = "Mark for deletion";
      listItem.appendChild(fileLabel);
      
      list.appendChild(listItem);

      const reader = new FileReader();
      reader.onload = function (e) {
        img.src = e.target.result;  
      };
      reader.readAsDataURL(file);  
    }
    
    fileListDiv.appendChild(list);
  } else {
    fileListDiv.innerHTML = 'No files selected.';
  }
}

 function renameFile() {                                      //saglabā nomainīto bildes nosaukumu
  const fileListDiv = document.getElementById('fileList');
  fullNamearray = [];
  console.log(selectedFiles)
  for (let i = 0; i < selectedFiles.length; i++) {
    console.log(document.getElementById("titleName"+i).value)
  let newName = document.getElementById("titleName"+i).value;
  let oldName = selectedFiles[i].name;
  fullNamearray.push({filename: oldName, filetitle: newName})
  }
  const names = document.createElement('input');
   names.id = 'fullName';
   names.name = 'fullName';
   names.type = "hidden";
   names.value = JSON.stringify(fullNamearray);
   document.getElementById('add_post_form').appendChild(names);
  fileListDiv.innerHTML = ''; 
} 

function removeSelectedFiles() {                                                      //noņem izvēlētās bildes
  const checkboxes = document.querySelectorAll('#fileList input[type="checkbox"]');
  var attachments = document.getElementById("titleimage").files; 
    var fileBuffer = new DataTransfer();
 var i = 0;
 fullNamearray = [];
 console.log(attachments);
  selectedFiles = selectedFiles.filter((file, index) => {
        if (checkboxes[index].checked == false){
            fileBuffer.items.add(attachments[i]);                           //apskata visus checkbox un izdzēš tos kuri ir atzīmēti
            let newName = document.getElementById("titleName"+i).value;
            let oldName = selectedFiles[i].name;
            fullNamearray.push({filename: oldName, filetitle: newName})
    i++;
        }
return !checkboxes[index].checked;
});
document.getElementById("titleimage").files = fileBuffer.files;
displayUpdatedFileList();
}

function displayUpdatedFileList() {                               //parāda bildes un to nosaukumus pēc izvelēto bilžu izdzēšanas
  const fileListDiv = document.getElementById('fileList');
  fileListDiv.innerHTML = '';  
  
  if (selectedFiles.length > 0) {
    const list = document.createElement('ul');
    
    for (let i = 0; i < selectedFiles.length; i++) {
      const file = selectedFiles[i];

      const listItem = document.createElement('li');
      listItem.style.display = 'flex';
      listItem.style.alignItems = 'center';
      
      const img = document.createElement('img');
      img.style.Width = '150px';  
      img.style.maxHeight = '100px';
      img.style.marginRight = '10px';
      img.style.marginLeft = '50px';
      
      listItem.appendChild(img); 

      const titleName = document.createElement('input');
      titleName.id = 'titleName'+i;
      titleName.type = "text";
      titleName.value = fullNamearray[i].filetitle;
      listItem.appendChild(titleName); 
      
      const checkbox = document.createElement('input');
      checkbox.id = 'checkbox'+i;
      checkbox.type = 'checkbox';
      checkbox.value = i;  
      checkbox.style.marginLeft = '10px';
      listItem.appendChild(checkbox);

      const fileLabel = document.createElement('label');
      fileLabel.setAttribute("for", 'checkbox'+i);
      fileLabel.textContent = "Mark for deletion";
      listItem.appendChild(fileLabel);

      list.appendChild(listItem);

      const reader = new FileReader();
      reader.onload = function (e) {
        img.src = e.target.result; 
      };
      reader.readAsDataURL(file);  
    }

    
    fileListDiv.appendChild(list);
  } else {
    fileListDiv.innerHTML = 'No files remaining.';
  }
} 

   </script>
   </form>
   <div id="post-creation-footer">
    <button onclick="post_creator_toggle()"> Atcelt </button>
    <button onclick="renameFile()"> Saglabāt </button>
   </div>
  </div>
<div id="news">interesanti jaunumi par saiti</div>
<!--          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="removeSelectedFiles()">Remove selected</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button onclick="renameFile()" type="submit" class="btn btn-primary" id="edit_post_btn">Add Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>-->
  <!-- add new post modal end -->

  <!-- edit post modal start 
  <div class="modal fade" id="edit_post_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" enctype="multipart/form-data" id="edit_post_form" novalidate>

    <div id="res" class="alert"></div>
    <script type="text/javascript">                                         //izveido form priekš rediģēšanas
       JSONForm.fieldTypes['multiplefileupload'] = {
        template: `
                  <input type="file" multiple id="edittitleimage" name="edittitleimage[]" class="form-control mb2" accept="image/*" onchange="displaySelectedFilesedit(this)" />
                  `
        };
      $('#edit_post_form').jsonForm({ 

    schema: {                                           //nodefinēt form elementus
          "title": "Book Form",
          "type": "object",
          "properties": {
            "pid": {"type": 'hidden'},
            "old_image": {"type": 'hidden'},
            "title": {"type": "string"},
            "category": {"type": "string"},
            "body": {"type": "string"},
            "tags": {"type": "array", "title": "Tag", "items": { "type": "string"}}
           },
    },
     "value": {
         "tags": [],
            }, 
          
    form: [{                                                //katru elementu ieliek formā
        "type": "fieldset",
        "id": "editform",
        "htmlClass": "modal-body p-5",
        "title": "Sections:",
        "items": [{
            "type": "tabs",
            "id": "navtabsedit",
            "items": [
                {
                    "title": "Main Fields",
                    "type": "tab",
                    "items": [
                      {"key": 'pid', "id": "pid", "name": "id"},
                      {"key": 'old_image', "id": "old_image", "name": "old_image"},
                      {"key": "title", "title": "Post Title", "id": "title"},
                      {"key": "category", "title": "Post Category", "id": "category"},
                      {"key": "body", "title": "Post Body", "id": "body"},
                    ]
                },
                {
                    "title": "Images",
                    "type": "tab",
                    "items": [{"type": "multiplefileupload"},
                    {"type": "section", "id": "post_image"},
                    {"type": "section", "id": "editfileList"},
                    ]
                },
                {
                    "title": "Tags",
                    "type": "tab",
                    "items": [
                      {"key": "tags",
                        "id": "tags"
                      }
                    ]                             
                },
            ]
        }]
    }]
  });


   selectedFiles = [];
   fullNamearray = [];
   dbNamearray = [];
   let oldNamearray = [];
   var oldi;
   var displayi;
   var imagename;
   var tagname;
   var dbtags;
function displaySelectedFilesedit(input) {                           //parāda izvēlētās bildes formā ar checkbox pie tām
  const fileListDiv = document.getElementById('editfileList');
  fileListDiv.innerHTML = ''; 
  displayi = oldi;

  if (input.files.length > 0) {
    selectedFiles = Array.from(input.files);  
    const list = document.createElement('ul');
    
    for (let i = 0; i < selectedFiles.length; i++) {
      const file = selectedFiles[i];
      const listItem = document.createElement('li');
      listItem.style.display = 'flex';
      listItem.style.alignItems = 'center';

      const img = document.createElement('img');
      img.style.Width = '150px';  
      img.style.maxHeight = '100px';
      img.style.marginRight = '10px';
      img.style.marginLeft = '50px';
      listItem.appendChild(img); 

      const titleName = document.createElement('input');
      titleName.id = 'titleName'+displayi;
      titleName.type = "text";
      titleName.value = file.name;
      listItem.appendChild(titleName); 
      
      const checkbox = document.createElement('input');
      checkbox.id = 'checkbox'+displayi;
      checkbox.type = 'checkbox';
      checkbox.value = displayi;  
      checkbox.style.marginLeft = '10px';
      listItem.appendChild(checkbox);

      const fileLabel = document.createElement('label');
      fileLabel.setAttribute("for", 'checkbox'+displayi);
      fileLabel.textContent = "Mark for deletion";
      listItem.appendChild(fileLabel);
      
      list.appendChild(listItem);

      const reader = new FileReader();
      reader.onload = function (e) {
        img.src = e.target.result;  
      };
      reader.readAsDataURL(file);  
      displayi++;
    }
    
    fileListDiv.appendChild(list);
  } else {
    fileListDiv.innerHTML = 'No files selected.';
  }
  displayi = oldi;
}

 function renameFileedit() {                                                       //izveido teksta kasti ar bildes nosaukumu kuru var mainīt
  const fileListDiv = document.getElementById('editfileList');
  fullNamearray = [];
  tempi = oldi;
  for (i = 0; i < selectedFiles.length; i++) {
    let newName = document.getElementById("titleName"+tempi).value;
    let oldName = selectedFiles[i].name;
    fullNamearray.push({filename: oldName, filetitle: newName});
    tempi++;
    console.log("test2");
  }
  const names = document.createElement('input');
   names.id = 'fullName';
   names.name = 'fullName';
   names.type = "hidden";
   names.value = JSON.stringify(fullNamearray);
   document.getElementById('edit_post_form').appendChild(names);

if (dbNamearray == ""){
    for (i = 0; i < oldi; i++) {
      let newName = document.getElementById("titleName"+i).value;
      let origName = imagename[i].originalfilename;
      let oldName = imagename[i].filename;
      dbNamearray.push({filename: oldName, original: origName, filetitle: newName});
      console.log(document.getElementById("titleName"+i).value);
  } 
}
  

   const dbnames = document.createElement('input');
   dbnames.id = 'fulldbName';
   dbnames.name = 'fulldbName';
   dbnames.type = "hidden";
   dbnames.value = JSON.stringify(dbNamearray);
   document.getElementById('edit_post_form').appendChild(dbnames);

   console.log(dbNamearray);
  fileListDiv.innerHTML = '';
 // fileListDiv.innerHTML = ''; 
   //document.getElementById("titleimage")
} 

 function removeSelectedFilesedit() {                                                    //noņem izvēlētās bildes
  const checkboxes = document.querySelectorAll('#editfileList input[type="checkbox"]');
  var attachments = document.getElementById('edittitleimage').files; 
    var fileBuffer = new DataTransfer();
 var i = oldi;
 fullNamearray = [];
 console.log(attachments);
  selectedFiles = selectedFiles.filter((file, index) => {
        if (checkboxes[index].checked == false){
            fileBuffer.items.add(attachments[index]);
            let newName = document.getElementById("titleName"+i).value;
            let oldName = selectedFiles[index].name;
            fullNamearray.push({filename: oldName, filetitle: newName});
    i++;
    
        }
//return !checkboxes[index].checked;
});
console.log("full name array: " + fullNamearray);
document.getElementById("edittitleimage").files = fileBuffer.files; 
displayUpdatedFileListedit();
}

function displayUpdatedFileListedit() {                                           //parāda bildes un to nosaukumus pēc izvelēto bilžu izdzēšanas
  const fileListDiv = document.getElementById('editfileList');
  fileListDiv.innerHTML = '';  
  displayi = oldi;
  
  if (selectedFiles.length > 0) {
    const list = document.createElement('ul');
    
    for (let i = 0; i < selectedFiles.length; i++) {
      const file = selectedFiles[i];
      const listItem = document.createElement('li');
      listItem.style.display = 'flex';
      listItem.style.alignItems = 'center';
      
      const img = document.createElement('img');
      img.style.width = '150px';  
      img.style.maxHeight = '100px';
      img.style.marginRight = '10px';
      img.style.marginLeft = '50px';
      
      listItem.appendChild(img); 

      const titleName = document.createElement('input');
      titleName.id = 'titleName'+displayi;
      titleName.type = "text";
      titleName.value = fullNamearray[i].filetitle;
      listItem.appendChild(titleName); 
      
      const checkbox = document.createElement('input');
      checkbox.id = 'checkbox'+displayi;
      checkbox.type = 'checkbox';
      checkbox.value = displayi;  
      checkbox.style.marginLeft = '10px';
      listItem.appendChild(checkbox);

      const fileLabel = document.createElement('label');
      fileLabel.setAttribute("for", 'checkbox'+displayi);
      fileLabel.textContent = "Mark for deletion";
      listItem.appendChild(fileLabel);

      list.appendChild(listItem);

      const reader = new FileReader();
      reader.onload = function (e) {
        img.src = e.target.result; 
      };
      reader.readAsDataURL(file);  
      displayi++;
    }

    
    fileListDiv.appendChild(list);
  } else {
    fileListDiv.innerHTML = 'No files remaining.';
  }
} 

  function showOldFiles() {                                   //parāda saglabātāš bildes formā ar checkbox pie tām
    var oldfiles = "";  
    document.getElementById('post_image').innerHTML = '';
            oldi = 0;
           imagename.forEach(element => {
            oldfiles += ('<img src="<?= base_url('uploads/avatar/') ?>/' + imagename[oldi].filename + '" id=oldfiles' + oldi + ' class="img-fluid mt-2 img-thumbnail" width="150"><br>');
            oldi++;
              });
              $("#post_image").html(oldfiles);
            oldi=0;
            imagename.forEach(element => {
               const titleName = document.createElement('input');
                titleName.id = 'titleName'+oldi;
                titleName.type = "text";
                titleName.value = imagename[oldi].filetitle;
               document.getElementById("oldfiles"+oldi).after(titleName); 
            
               const checkbox = document.createElement('input');
                checkbox.id = 'checkbox'+oldi;
                checkbox.type = 'checkbox';
                checkbox.value = oldi;  
                checkbox.style.marginLeft = '10px';
               document.getElementById("titleName"+oldi).after(checkbox); 

               const fileLabel = document.createElement('label');
               fileLabel.id = "filelabel" + oldi;
                fileLabel.setAttribute("for", 'checkbox'+oldi);
                fileLabel.textContent = "Mark for deletion";
               document.getElementById("checkbox"+oldi).after(fileLabel);
               oldi++;
           });

           //var temp = [];
           //tagname.forEach((element, index) => 
           //{
            //temp.push(tagname[index].posttag);
            //console.log($("#tags").value);
           // console.log(temp);
         // });
         // $("#tags").value(temp);
         // console.log($("#tags").value);
};

  function removeSelectedOldFiles() {                     //noņem izvēlētās bildes
 dbNamearray = [];
 oldNamearray = []; 
 var temp = 0;
    for(i = 0; i < oldi; i++){
        if (document.getElementById("checkbox" + i).checked){
            oldNamearray.push({oldname: imagename[i].filename});
          document.getElementById("oldfiles" + i).remove();
          document.getElementById("titleName" + i).remove();
          document.getElementById("checkbox" + i).remove();
          document.getElementById("filelabel" + i).remove();
        } else {
          dbNamearray.push({filename: imagename[i].filename, original: imagename[i].originalfilename, filetitle: document.getElementById("titleName" + i).value});
          temp++;
        }
    }
    $("#old_image").val(JSON.stringify(oldNamearray));
    oldi = temp;
    console.log()
removeSelectedFilesedit();
//displayUpdatedFileListedit();
}

   </script>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="removeSelectedOldFiles()">Remove selected</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button onclick="renameFileedit()" type="submit" class="btn btn-primary" id="edit_post_btn">Update Post</button>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
   edit post modal end -->

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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    var tags = [];
    var selectedTags = [];
    $(function() {                                                      // ar ajax request saglabā form
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

      $(document).delegate('.post_edit_btn', 'click', function(e) {               //ar ajax request parāda saglabāto post form
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

      $("#edit_post_form").submit(function(e) {                                     //ar ajax request rediģē saglabāto post
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

      $(document).delegate('.post_delete_btn', 'click', function(e) {               //ar ajax request izdzēš saglabāto post
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

      $(document).delegate('.post_detail_btn', 'click', function(e) {                   //ar ajax request parāda post informāciju
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

      function fetchAllPosts() {                                                //ar ajax request parāda visus saglabātos post
        var tagurl = 'empty';
        $.ajax({
          url: '<?= base_url('post/fetch/') ?>/' + tagurl,
          method: 'get',
          success: function(response) {
            $("#container-body").html(response.message);
          }
        });
      }

    fetchTags();

      function fetchTags() {                                                  //ar ajax request dabū visus tags
        $.ajax({
          url: '<?= base_url('post/fetchTags') ?>',
          method: 'get',
          success: function(posts) {
           for (var i = 0; i < posts.message.length; i++) {
             tags.push(JSON.parse(posts.message[i]));
           }
           for(var i=0; i<tags.length; i++){
            const fileListDiv = document.getElementById('filter_tags_display');
            const test = document.createElement('button');
            if (tags[i] != "") {
            test.textContent = tags[i];
            test.id = "tag"+i;
            test.type = "button";
            test.className="btn btn-secondary";
            test.style.float="left";
            test.style.width="auto";
            fileListDiv.appendChild(test); 
            $("#tag"+i).on( "click", function() {
              var x = document.getElementById(this.id);
              if (x.style.backgroundColor  == "darkblue") {
                x.style.backgroundColor  = "";
                selectedTags.splice(selectedTags.indexOf(x.innerHTML), 1);
              } else {
                x.style.backgroundColor  = "darkblue";
                selectedTags.push("'" + x.innerHTML + "'");
              } 
            });
            }
            }
          }
        });
      }

      $("#selectedTags").on( "click", function() {                                    //ar ajax request filtrē visus post pēc izvēlētajiem tags
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
        login[0] = '"'+document.getElementById("username").value+'"';
        login[1] = '"'+document.getElementById("password").value+'"';
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
        signin[0] = '"'+document.getElementById("username").value+'"';
        signin[1] = '"'+document.getElementById("email").value+'"';
        signin[2] = '"'+document.getElementById("phone").value+'"';
        signin[3] = '"'+document.getElementById("password").value+'"';
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