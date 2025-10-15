function post_creator_toggle() {
    var x = document.getElementById("post-creation");
      if (x.style.display === "block") {
       x.style.display = "none";
       } else {
       x.style.display = "block";
      }
}
function post_creator_field_toggle(field){
  switch(field){
    case "navtabs-Main_Fields":
      document.getElementById("navtabs-Main_Fields").style.display = "block";
      document.getElementById("navtabs-Images").style.display = "none";
      document.getElementById("navtabs-Tags").style.display = "none";
      break;
    case "navtabs-Images":
      document.getElementById("navtabs-Images").style.display = "block";
      document.getElementById("navtabs-Main_Fields").style.display = "none";
      document.getElementById("navtabs-Tags").style.display = "none";
      break;
    case "navtabs-Tags":
      document.getElementById("navtabs-Tags").style.display = "block";
      document.getElementById("navtabs-Images").style.display = "none";
      document.getElementById("navtabs-Main_Fields").style.display = "none";
      break;
  }
}