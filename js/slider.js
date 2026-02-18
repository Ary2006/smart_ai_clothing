let index = 0;

function showSlide() {
  const slides = document.querySelectorAll(".slide");
  slides.forEach(s => s.style.display = "none");

  index++;
  if (index > slides.length) index = 1;

  slides[index - 1].style.display = "block";
}

setInterval(showSlide, 3000);
window.onload = showSlide;
