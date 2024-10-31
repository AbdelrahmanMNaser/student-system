function confirmEdit(itemName) {
  // Return the promise from swal()
  return swal({
    title: "Are you sure you want to EDIT?",
    text: itemName + ".",
    icon: "warning",
    buttons: true
  }); 
}

function confirmRemove(itemName) {
  // Return the promise from swal()
  return swal({
    title: "Are you sure you want to DELETE?",
    text: itemName + ".",
    icon: "warning",
    buttons: true
  }); 
}
