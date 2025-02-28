// JavaScript for handling the mobile navigation menu
document.addEventListener("DOMContentLoaded", function() {
    const navLinks = document.querySelector(".nav-links");
    const navToggle = document.querySelector(".nav-toggle");
  
    navToggle.addEventListener("click", function() {
      navLinks.classList.toggle("active");
    });
  });
  
//card sliders
const cardContainer = document.querySelector('.card-container');
const cards = document.querySelectorAll('.card');
const leftBtn = document.querySelector('.slider-btn.left');
const rightBtn = document.querySelector('.slider-btn.right');
let currentIndex = 0;

function updateSlider() {
  cardContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
}

leftBtn.addEventListener('click', () => {
  currentIndex = (currentIndex > 0) ? currentIndex - 1 : cards.length - 1;
  updateSlider();
});

rightBtn.addEventListener('click', () => {
  currentIndex = (currentIndex < cards.length - 1) ? currentIndex + 1 : 0;
  updateSlider();
});

// login

function handleLogin(event) {
  event.preventDefault(); // Prevent default form submission
  const userType = document.getElementById("userType").value; // Get the selected user type
  window.location.href = userType; // Redirect to the corresponding dashboard
}
