function showInputMessageId() {
  var msg = document.getElementById('msg-enter-id');
  msg.innerHTML = 'Press ENTER to Search for Student';
}

function showInputMessageScore() {
  var msg = document.getElementById('msg-score');
  msg.innerHTML = 'Press ENTER to Submit Score';
}

function hideInputMessageId() {
  var msg_id = document.getElementById('msg-enter-id');
  msg_id.innerHTML = '';
}

function hideInputMessageScore() {
  var msg_score = document.getElementById('msg-score');
  msg_score.innerHTML = '';
}

function formatStdId() {
  let value = this.value;
  let numOnly = value.replace(/\D/g, '');
  this.value = numOnly;
} 


function applyHandlers(inputId) {
  let inputElement = document.getElementById(inputId);

  inputElement.oninput = formatStdId;

  if (inputId == "student_id") {
    inputElement.onfocus = showInputMessageId;
    inputElement.onblur = hideInputMessageId;
  }

  if (inputId == "score") {
    inputElement.onfocus = showInputMessageScore;
    inputElement.onblur = hideInputMessageScore;
    
  }

}

document.addEventListener('DOMContentLoaded', (event) => {
  applyHandlers('student_id');
  applyHandlers('score');
});

