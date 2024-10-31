let inputCount = 0;

function addPhoneNumberInput() {
  let isBackspace = false;

  function checkBackspace(event) {
    isBackspace = event.keyCode === 8;
  }

  function formatPhoneNumber() {
    if (isBackspace) {
      isBackspace = false;
      return;
    }
    let value = this.value.replace(/\D/g, "");

    let formatted =
      value.slice(0, 4) + " " + value.slice(4, 7) + " " + value.slice(7, 11);
    this.value = formatted;
  }

  var newLabel = document.createElement("label");
  newLabel.innerHTML = "Phone " + (inputCount + 1) + " ";
  newLabel.className = "form-label text-center";

  var newInput = document.createElement("input");
  newInput.type = "tel";
  newInput.name = "phone" + inputCount;
  newInput.className = "phoneInput";
  newInput.onkeydown = checkBackspace;
  newInput.oninput = formatPhoneNumber;
  newInput.maxLength = "14";
  newInput.placeholder = "Phone Number";
  newInput.className = "form-control text-center";

  if (window.location.href.indexOf("signup.html") > -1) {
    // Change the background color for the specific file
    newInput.style.background = "transparent";
    newInput.style.color = "white";
  } else {
    // Keep the default color for other files
    newInput.style.background = "white";
    newInput.style.color = "black";
  }

  var removeButton = document.createElement("button");
  removeButton.innerHTML = "remove";
  removeButton.className = "btn btn-secondary";

  removeButton.style.marginLeft = "40px";
  removeButton.onclick = function () {
    this.parentElement.remove();
    inputCount--;
  };

  var container = document.createElement("div");
  container.appendChild(newLabel);
  container.appendChild(newInput);
  container.appendChild(removeButton);

  container.className = "col-md-6";

  document.getElementById("inputArea").appendChild(container);
  inputCount++;
}
