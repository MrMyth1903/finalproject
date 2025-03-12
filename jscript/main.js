document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('.carousel');
    const items = document.querySelectorAll('.carousel-item');
    const firstItemClone = items[0].cloneNode(true);
    carousel.appendChild(firstItemClone);
  });
  