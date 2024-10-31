function displayAttachement() {
  var attachArea = document.getElementById("attachArea");
  var attachLabel = document.getElementById("attach");
  var fileInput = attachArea.querySelector("input[type='file']");
  var newLabel = attachArea.querySelector("label");
  var removeLabel = attachArea.querySelector("#removeLabel");
  

  if (fileInput) {
    // If file input exists, remove it and change label back to "Attach Files"
    fileInput.remove();
    newLabel.remove();
    
    if (removeLabel) {
      removeLabel.remove();
    }

    attachLabel.innerHTML = "<i class='fa fa-paperclip'></i> Attach Files";
    attachLabel.style.color = "blue";
  } else {
    // If file input doesn't exist, create and add it
    newLabel = document.createElement("label");
    newLabel.innerHTML = "Upload a File";
    newLabel.className = "form-label mt-3 d-block";

    fileInput = document.createElement("input");
    fileInput.type = "file";
    fileInput.name = "file";
    fileInput.className = "form-control d-inline-block";


    // Add an onclick event to the file input to clear its value each time it's clicked
    fileInput.onclick = function() {
      this.value = null;
    };

    // Add an onchange event to the file input
    fileInput.onchange = function() {
      if (this.files) {
        // If a file is selected
        removeLabel = document.createElement("span");
        removeLabel.innerHTML = " Delete";
        removeLabel.id = "removeLabel";
        removeLabel.className = "text-danger ml-2";  
        removeLabel.style.cursor = "pointer";  
        removeLabel.onclick = function() {
          fileInput.value = "";  // Clear the file input
          this.remove();  // Remove the label
        };
        attachArea.appendChild(removeLabel);
      }
    };

    attachLabel.innerHTML = "Remove Attachement";
    attachLabel.style.color = "red";

    attachArea.appendChild(newLabel);
    attachArea.appendChild(fileInput);    
  }
}
