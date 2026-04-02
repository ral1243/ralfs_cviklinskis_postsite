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

      const img = document.createElement("img"); 
      img.style.Width = "125px";
      img.style.height = "100px";
      img.style.objectFit = "cover";
      listItem.appendChild(img);

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
function combineData() {
  fullTags = [];
  $("#tagselect").select2("data").forEach(CombineTags);
  tag = document.createElement("input");
  tag.id = "fullTags";
  tag.name = "fullTags";
  tag.type = "hidden";
  tag.value = JSON.stringify(fullTags);
  document.getElementById("post_form").appendChild(tag);

  var description = "";
  description = quill.getContents();
  desc = document.createElement("input");
  desc.id = "description";
  desc.name = "description";
  desc.type = "hidden";
  desc.value = JSON.stringify(description);
  document.getElementById("post_form").appendChild(desc);
}


orig_comment = "";
function commentEdit(comment_id){
  comment_id = comment_id.split("_");
  comment_id = comment_id[0];
  orig_comment = document.getElementById(comment_id+"_comment_text").innerText;

  const input = document.createElement("input");
  input.setAttribute("id", comment_id+"_comment_text");
  input.setAttribute("class", "col-11 mb-1 border border-black");                             
  input.setAttribute("value", document.getElementById(comment_id+"_comment_text").innerText);
  input.innerText = document.getElementById(comment_id+"_comment_text").innerText;
  document.getElementById(comment_id+"_comment_text").replaceWith(input);
  input.focus();

  const cancel = document.createElement("button");
  cancel.setAttribute("id", comment_id+"_cancel");
  cancel.setAttribute("class", "cancel_comment col m-1 btn btn-primary btn-sm");              
  cancel.setAttribute("onclick", "commentCancel(this.id)");               
  cancel.innerText = "Atcelt";
  document.getElementById(comment_id+"_delete").replaceWith(cancel);

  const edit = document.createElement("button");
  edit.setAttribute("id", comment_id+"_edit");
  edit.setAttribute("class", "edit_comment_confirm col m-1 btn btn-primary btn-sm");                  
  edit.innerText = "edit";
  document.getElementById(comment_id+"_edit").replaceWith(edit); 

}

function commentCancel(comment_id){
  comment_id = comment_id.split("_");
  comment_id = comment_id[0];

    const input = document.createElement("div");
  input.setAttribute("id", comment_id+"_comment_text");
  input.setAttribute("class", "col-11 mb-1 border border-black");                         
  input.setAttribute("value", orig_comment);
  input.innerText = orig_comment;
  document.getElementById(comment_id+"_comment_text").replaceWith(input);

const deletebtn = document.createElement("button");
  deletebtn.setAttribute("id", comment_id+"_delete");
  deletebtn.setAttribute("class", "delete_comment col m-1 btn btn-primary btn-sm");                  
  deletebtn.innerText = "Dzēst";
  document.getElementById(comment_id+"_cancel").replaceWith(deletebtn);

  const edit = document.createElement("button");
  edit.setAttribute("id", comment_id+"_edit");
  edit.setAttribute("class", "edit_comment col m-1 btn btn-primary btn-sm ");    
  edit.setAttribute("onclick", "commentEdit(this.id)")              
  edit.innerText = "edit";
  document.getElementById(comment_id+"_edit").replaceWith(edit);   

  orig_comment = "";
}


