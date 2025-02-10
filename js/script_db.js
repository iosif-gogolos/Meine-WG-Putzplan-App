document.addEventListener('DOMContentLoaded', function () {
  // Lottie-Animationen initialisieren
  const animation1 = lottie.loadAnimation({
    container: document.getElementById('lottie1'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'assets/lottie/cleaning_checklist.json'
  });

  const animation2 = lottie.loadAnimation({
    container: document.getElementById('lottie2'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'assets/lottie/data_security.json'
  });

  const animation3 = lottie.loadAnimation({
    container: document.getElementById('lottie3'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'assets/lottie/sustainability.json'
  });

  // Einfaches Carousel-Skript
  const slides = document.querySelectorAll('.carousel-slide');
  let currentSlide = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle('active', i === index);
    });
  }

  // Initial die erste Slide anzeigen
  showSlide(currentSlide);

  // Vorher- und Nächster-Buttons
  document.getElementById('prev-btn').addEventListener('click', () => {
    currentSlide = (currentSlide === 0) ? slides.length - 1 : currentSlide - 1;
    showSlide(currentSlide);
  });

  document.getElementById('next-btn').addEventListener('click', () => {
    currentSlide = (currentSlide === slides.length - 1) ? 0 : currentSlide + 1;
    showSlide(currentSlide);
  });
});
