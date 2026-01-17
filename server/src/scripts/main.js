// ========================================================================== //
// Loader

const loader = document.querySelector('.loader');

window.addEventListener('load', () => {
  if (!loader) {
    return;
  }

  setTimeout(() => {
    loader.classList.add('loaded');
  }, 1000);
});

document.addEventListener("DOMContentLoaded", () => {
  // ========================================================================== //
  //   Navigation Scroll Logic

  const nav = document.getElementById("nav");
  const scrollContainer = document.querySelector(".parallax") || window;

  if (nav) {
    const handleScroll = () => {
      const scrollY = scrollContainer === window ? window.scrollY : scrollContainer.scrollTop;
      if (scrollY > 50) {
        nav.classList.add("active");
      } else {
        nav.classList.remove("active");
      }
    };

    scrollContainer.addEventListener("scroll", handleScroll);
    // Initial check
    handleScroll();
  }

  // ========================================================================== //
  //   Navigation Toggle

  const navToggle = document.getElementById("nav-toggle");

  if (navToggle && nav) {
    navToggle.addEventListener("click", () => {
      nav.classList.toggle("show");
      navToggle.classList.toggle("active");
    });
  }


  const navLinks = document.querySelectorAll(".nav-list li a");

  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      // Only toggle dropdown on desktop (width > 798px)
      // On mobile, dropdowns are auto-expanded via CSS
      if (window.innerWidth > 798 && link.nextElementSibling) {
        link.nextElementSibling.classList.toggle("show");
      }
    });
  });

  // ========================================================================== //
  // Nested Submenu Toggle (Mobile Only)

  const submenuToggles = document.querySelectorAll(".submenu-toggle");

  submenuToggles.forEach((toggle) => {
    toggle.addEventListener("click", (e) => {
      e.preventDefault();

      // Only on mobile
      if (window.innerWidth <= 798) {
        const parentLi = toggle.closest(".has-submenu");
        const isExpanded = parentLi.classList.contains("expanded");

        // Close all other submenus
        document.querySelectorAll(".has-submenu.expanded").forEach((item) => {
          if (item !== parentLi) {
            item.classList.remove("expanded");
          }
        });

        // Toggle current submenu
        parentLi.classList.toggle("expanded");
      }
    });
  });

  // ========================================================================== //
  // Vendor Filter

  const container = document.querySelector(".sort-container");
  const links = document.querySelectorAll("div.filter a");

  if (container && links.length && window.Isotope) {
    const isotope = new Isotope(container, {
      filter: "*",
    });

    links.forEach((link) => {
      link.addEventListener("click", function () {
        const selector = this.getAttribute("data-filter");
        isotope.arrange({ filter: selector });
      });
    });
  }
});
