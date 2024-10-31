var message;
var text;
var icon;
var buttonText;

function showAlert(title, text, icon, buttonText) {
  swal({
    title: title,
    text: text,
    icon: icon,
    button: buttonText,
  });
}

window.onload = function () {
  if (message && text && icon && buttonText) {
    showAlert(message, text, icon, buttonText);
  }
};
