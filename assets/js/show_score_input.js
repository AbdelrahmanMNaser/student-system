function displayInput(element) {
    var scoreInput = '<input type="text" style="width: 100px; border: 1px solid black;" class="form-control text-center" name="score" id="score" required>';
    element.innerHTML = scoreInput;
  
    // Add event listener to the input field
    var inputField = element.querySelector('input');
    inputField.addEventListener('change', function() {
      updateScore(this.value, element);
    });
    
  }
  
  function updateScore(score, element) {
    $.ajax({
      url: window.location.href, // Send request to the same file
      type: 'POST',
      data: {score: score},
      success: function(response) {
        console.log(response);
        // Update the element's innerHTML based on the score
        if (score) {
          element.innerHTML = score;
        } else {
          element.innerHTML = '<?php echo print_score_input(); ?>';
        }
      }
    });
  }
  