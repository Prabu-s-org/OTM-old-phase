<script>

const tabs = document.querySelectorAll(".tab");
const nextBtn = document.getElementById("nextBtn");
const cancelBtn = document.getElementById("cancelBtn");

nextBtn.addEventListener("click", () => {
  tabs[0].classList.remove("active");
  tabs[1].classList.add("active");
});

cancelBtn.addEventListener("click", () => {
  tabs[1].classList.remove("active");
  tabs[0].classList.add("active");
});


</script>