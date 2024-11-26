
const addTMonthForm= document.getElementById("addTMonthForm");
const addTMonth = document.getElementById("addTMonth");
const overlay = document.querySelector('#overlay');
const addTWeek=document.getElementById('addTWeek');
const addTWeekForm=document.getElementById("addTWeekForm")
const addBranch=document.getElementById('addBranch');
const addBranchForm=document.getElementById("addBranchForm");



addTMonth.addEventListener("click", function() {
  addTMonthForm.style.display = "block";
  overlay.style.display="block";
  document.body.style.overflow = 'hidden'; 


});
addTWeek.addEventListener("click", function() {
    addTWeekForm.style.display = "block";
    overlay.style.display="block";
    document.body.style.overflow = 'hidden'; 
  
  
  });
  addBranch.addEventListener("click", function() {
    addBranchForm.style.display = "block";
    overlay.style.display="block";
    document.body.style.overflow = 'hidden'; 
  
  
  });


  var closeButtons = document.querySelectorAll('#addTMonthForm .close, #addTWeekForm .close, #addBranchForm .close');

  closeButtons.forEach(function(closeButton) {
      closeButton.addEventListener('click', function() {
          addTMonthForm.style.display = "none";
          addTWeekForm.style.display = "none";
          addBranchForm.style.display="none";
          overlay.style.display = 'none';
          document.body.style.overflow = 'auto'; 
      });
  });
