function post_creator_toggle() {
  var x = document.getElementById("post-creation");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block"; //prob remove this bs------------------------------------------------------------------------
  }
}

function show_post_date(id) {
  var x = document.getElementById(id);
  x.style.display = "block";
}

function hide_post_date(id) {
  var x = document.getElementById(id);
  x.style.display = "none";
}

let selectedFiles = [];
function displaySelectedFiles(input) {
  //parāda izvēlētās bildes formā ar checkbox pie tām
  const fileListDiv = document.getElementById("fileList");
  fileListDiv.innerHTML = "";
  selectedFiles = [];
  if (input.files.length > 0) {
    selectedFiles = Array.from(input.files);
    const list = document.createElement("ul");

    for (let i = 0; i < selectedFiles.length; i++) {
      const file = selectedFiles[i];
      const listItem = document.createElement("li");
      listItem.style.display = "flex";
      listItem.style.alignItems = "center";

      const img = document.createElement("img"); //parāda bildi
      img.style.Width = "125px";
      img.style.height = "100px";
      img.style.objectFit = "cover";
      listItem.appendChild(img);

      const titleName = document.createElement("input");
      titleName.id = "titleName" + i;
      titleName.type = "text";
      titleName.value = file.name;
      listItem.appendChild(titleName);

      list.appendChild(listItem);

      const reader = new FileReader();
      reader.onload = function (e) {
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }

    fileListDiv.appendChild(list);
  } else {
    fileListDiv.innerHTML = "No files selected.";
  }
}

var fullTags = [];
function CombineTags(item, index) {
  fullTags.push(item.id);
}

var names = "undefined";
function combineImage() {
  fullTags = [];
  $("#tagselect").select2("data").forEach(CombineTags);
  tag = document.createElement("input");
  tag.id = "fullTags";
  tag.name = "fullTags";
  tag.type = "hidden";
  tag.value = JSON.stringify(fullTags);
  document.getElementById("add_post_form").appendChild(tag);

  const fileListDiv = document.getElementById("fileList");
  fullNamearray = [];
  for (let i = 0; i < selectedFiles.length; i++) {
    let Name = document.getElementById("titleName" + i).value;
    fullNamearray.push({ filetitle: Name });
  }

  if (names != "undefined") {
    document.getElementById("fullName").remove();
  }

  names = document.createElement("input");
  names.id = "fullName";
  names.name = "fullName";
  names.type = "hidden";
  names.value = JSON.stringify(fullNamearray);
  document.getElementById("add_post_form").appendChild(names);
  fileListDiv.innerHTML = "";
}


