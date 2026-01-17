// Import main SCSS file (Vite will process it with Sass)
import './styles/scss/main.scss';

// ========================================================================== //
// NAVBAR SCROLL & ACTIVE STATE
// ========================================================================== //

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', () => {
  const nav = document.querySelector(".nav_landing-page");
  const navMobile = document.querySelector(".nav-mobile");

  if (!nav) {
    console.warn('Navbar element not found');
    return;
  }

  // Navbar background on scroll
  const navActive = () => {
    if (window.scrollY > 50) {
      nav.classList.add('active');
      if (navMobile) {
        navMobile.classList.add('is-active');
      }
    } else {
      nav.classList.remove('active');
      if (navMobile) {
        navMobile.classList.remove('is-active');
      }
    }
  };

  window.addEventListener('scroll', navActive);
  
  // Run once on load in case page is already scrolled
  navActive();
});

// ========================================================================== //


// ========================================================================== //
// Apply functionality to the hamburger icon

document.addEventListener('DOMContentLoaded', () => {
  const hamburger = document.querySelector(".burger-container");
  const list = document.querySelector(".nav-mobile");

  if (hamburger && list) {
    const hamburgerActive = () => {
      hamburger.classList.toggle('active');
      list.classList.toggle('active');
    };

    hamburger.addEventListener("click", hamburgerActive);
  }
});

// ========================================================================== //
// TYPING ANIMATION

document.addEventListener('DOMContentLoaded', () => {
  // Function to shuffle an array
  const shuffleArray = (array) => {
    for (let i = array.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [array[i], array[j]] = [array[j], array[i]];
    }
  };

  // Define an array of strings to be displayed and erased
  const textArray = [
    "Transform your dining experience.",
    "Smart dining, personalized for you.",
    "CenDash: Where food meets innovation.",
    "Effortless ordering, delightful dining.",
    "Explore, order, enjoy - all in one place.",
    "Your campus dining revolution starts here.",
    "Discover a world of flavors at your fingertips.",
    "Savor the convenience of campus dining like never before."
  ];

  // Shuffle the array
  shuffleArray(textArray);

  const typeJsText = document.querySelector(".animatedText");
  
  if (typeJsText) {
    let stringIndex = 0;
    let charIndex = 0;
    let isTyping = true;

    const typeJs = () => {
      if (stringIndex < textArray.length) {
        const currentString = textArray[stringIndex];

        if (isTyping) {
          if (charIndex < currentString.length) {
            typeJsText.innerHTML += currentString.charAt(charIndex);
            charIndex++;
          } else {
            isTyping = false;
          }
        } else {
          if (charIndex > 0) {
            typeJsText.innerHTML = currentString.substring(0, charIndex - 1);
            charIndex--;
          } else {
            isTyping = true;
            stringIndex++;

            if (stringIndex >= textArray.length) {
              stringIndex = 0;
            }

            charIndex = 0;
            typeJsText.innerHTML = "";
          }
        }
      }
    };

    // Set an interval to call the typeJs function
    setInterval(typeJs, 75);
  }
});


// IMAGES

document.addEventListener('DOMContentLoaded', () => {
  const sliderContainer = document.querySelector('.slider-container');
  const slideRight = document.querySelector('.right-slide');
  const slideLeft = document.querySelector('.left-slide');
  const upButton = document.querySelector('.up-button');
  const downButton = document.querySelector('.down-button');

  // Only run slider code if elements exist
  if (sliderContainer && slideRight && slideLeft && upButton && downButton) {
    const slidesLength = slideRight.querySelectorAll('div').length;

    let activeSlideIndex = 0;

    slideLeft.style.top = `-${(slidesLength - 1) * 70}vh`;

    const changeSlide = (direction) => {
      const sliderHeight = sliderContainer.clientHeight;
      if (direction === 'up') {
        activeSlideIndex++;
        if (activeSlideIndex > slidesLength - 1) {
          activeSlideIndex = 0;
        }
      } else if (direction === 'down') {
        activeSlideIndex--;
        if (activeSlideIndex < 0) {
          activeSlideIndex = slidesLength - 1;
        }
      }

      slideRight.style.transform = `translateY(-${activeSlideIndex * sliderHeight}px)`;
      slideLeft.style.transform = `translateY(${activeSlideIndex * sliderHeight}px)`;
    };

    upButton.addEventListener('click', () => changeSlide('up'));
    downButton.addEventListener('click', () => changeSlide('down'));
  }
});


// ========================================================================== //
// ACTIVE LINKS (intersection-based for maintainability)

document.addEventListener('DOMContentLoaded', () => {
  const navLinks = document.querySelectorAll(".nav-item-container a, .nav-mobile a");
  const navLinkTargets = Array.from(navLinks)
    .map((link) => {
      const href = link.getAttribute('href');
      if (!href || !href.startsWith('#')) return null;

      const targetId = href.substring(1);
      const section = document.getElementById(targetId);
      return section ? { link, section, id: targetId } : null;
    })
    .filter(Boolean);

  const setActiveLink = (targetId) => {
    navLinks.forEach((link) => link.classList.remove('active'));
    if (!targetId) return;

    navLinkTargets.forEach(({ id, link }) => {
      if (id === targetId) link.classList.add('active');
    });
  };

  if (navLinkTargets.length) {
    const observer = new IntersectionObserver(
      (entries) => {
        const visible = entries
          .filter((entry) => entry.isIntersecting || entry.intersectionRatio > 0)
          .map((entry) => {
            const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
            const entryTop = entry.boundingClientRect.top;
            const distanceToCenter = Math.abs(entryTop - viewportHeight / 2);
            return { id: entry.target.id, distanceToCenter, ratio: entry.intersectionRatio };
          })
          .sort((a, b) => a.distanceToCenter - b.distanceToCenter || b.ratio - a.ratio);

        const nextId = visible.length ? visible[0].id : '';
        setActiveLink(nextId);
      },
      {
        root: null,
        threshold: [0.1, 0.25, 0.4, 0.55, 0.7, 0.85],
        rootMargin: '-20% 0px -20% 0px', // tighter margin to register smaller sections like About
      }
    );

    navLinkTargets.forEach(({ section }) => observer.observe(section));

    // Clear active state when near the very top (hero/home area)
    const clearWhenAtTop = () => {
      if (window.scrollY < 120) setActiveLink('');
    };

    window.addEventListener('scroll', clearWhenAtTop);
  }
});

// ========================================================================== //
// Reviews carousel controls

document.addEventListener('DOMContentLoaded', () => {
  const reviewsTrack = document.querySelector('.reviews-grid');
  const reviewsPrev = document.querySelector('.reviews-prev');
  const reviewsNext = document.querySelector('.reviews-next');

  if (reviewsTrack && reviewsPrev && reviewsNext) {
    const originalCards = Array.from(reviewsTrack.querySelectorAll('.review-card'));
    const baseCount = originalCards.length;

    // Clone cards on both ends to allow seamless infinite wrap
    originalCards.forEach((card) => {
      const clone = card.cloneNode(true);
      clone.setAttribute('aria-hidden', 'true');
      reviewsTrack.appendChild(clone);
    });

    for (let i = originalCards.length - 1; i >= 0; i -= 1) {
      const clone = originalCards[i].cloneNode(true);
      clone.setAttribute('aria-hidden', 'true');
      reviewsTrack.prepend(clone);
    }

    let reviewCards = Array.from(reviewsTrack.querySelectorAll('.review-card'));
    let currentIndex = baseCount; // start at first real card in the middle set
    let scrollTimeout;

    const scrollToIndex = (index, smooth = true) => {
      const card = reviewCards[index];
      if (!card) return;
      const offset = card.offsetLeft - reviewsTrack.offsetLeft;
      reviewsTrack.scrollTo({ left: offset, behavior: smooth ? 'smooth' : 'auto' });
    };

    // Initialize position to first real card block
    scrollToIndex(currentIndex, false);

    const shift = (direction) => {
      // Calculate next index
      let nextIndex = currentIndex + direction;
      
      // Wrap around if we go out of bounds
      if (nextIndex >= reviewCards.length) {
        nextIndex = baseCount; // wrap to start of real cards
      } else if (nextIndex < 0) {
        nextIndex = baseCount * 2 - 1; // wrap to end of real cards
      }
      
      currentIndex = nextIndex;
      scrollToIndex(currentIndex, true);
    };

    // Button click handlers
    reviewsPrev.addEventListener('click', () => shift(-1));
    reviewsNext.addEventListener('click', () => shift(1));
  }
});
