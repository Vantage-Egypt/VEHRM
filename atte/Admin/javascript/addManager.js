const addManager=document.getElementById('addManager');
const addManagerForm=document.getElementById("addManagerForm");
addManager.addEventListener("click",function(){
  addManagerForm.style.display = "block";
  overlay.style.display="block";
  document.body.style.overflow = 'hidden'; 

})
var closeButtons = document.querySelectorAll(' #addManagerForm .close');

closeButtons.forEach(function(closeButton) {
    closeButton.addEventListener('click', function() {
        addManagerForm.style.display="none";
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto'; 
    });
});