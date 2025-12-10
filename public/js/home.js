function post_creator_toggle() {
    var x = document.getElementById("post-creation");
      if (x.style.display === "block") {
       x.style.display = "none";
       } else {
       x.style.display = "block";
      }
}

function show_post_date(id){
  var x = document.getElementById(id); 
  x.style.display = "block";
}

function hide_post_date(id){
  var x = document.getElementById(id)
  x.style.display = "none";
}

function displaySelectedFiles(input) {                        //parāda izvēlētās bildes formā ar checkbox pie tām
  let selectedFiles = [];
  let fullNamearray = [];
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
      img.style.Width = '125px';  
      img.style.height = '100px';
      img.style.objectFit = 'cover';
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
    fileListDiv.innerHTML = 'No files selected.';
  }
  
}

