/**
 * Navbar JavaScript
 * Sekolah Insan Teladan
 */

document.addEventListener("DOMContentLoaded", function () {
  initMobileMenu();
  initDropdownMenu();
  initStickyNavbar();
  setActiveMenuItem();
});

/**
 * Mobile Menu Toggle
 */
function initMobileMenu() {
  const menuToggle = document.getElementById("mobileMenuToggle");
  const navbarMenu = document.getElementById("navbarMenu");

  if (!menuToggle || !navbarMenu) return;

  menuToggle.addEventListener("click", function () {
    this.classList.toggle("active");
    navbarMenu.classList.toggle("active");
    document.body.classList.toggle("menu-open");
  });

  // Close menu when clicking outside
  document.addEventListener("click", function (e) {
    if (!menuToggle.contains(e.target) && !navbarMenu.contains(e.target)) {
      menuToggle.classList.remove("active");
      navbarMenu.classList.remove("active");
      document.body.classList.remove("menu-open");
    }
  });

  // Close menu on window resize
  window.addEventListener("resize", function () {
    if (window.innerWidth > 992) {
      menuToggle.classList.remove("active");
      navbarMenu.classList.remove("active");
      document.body.classList.remove("menu-open");
    }
  });
}

/**
 * Dropdown Menu
 */
function initDropdownMenu() {
  const dropdownItems = document.querySelectorAll(".dropdown");

  dropdownItems.forEach((item) => {
    const dropdownToggle = item.querySelector(".dropdown-toggle");
    const dropdownMenu = item.querySelector(".dropdown-menu");

    if (!dropdownToggle || !dropdownMenu) return;

    // For mobile: toggle on click
    dropdownToggle.addEventListener("click", function (e) {
      if (window.innerWidth <= 992) {
        e.preventDefault();

        // Close other dropdowns
        dropdownItems.forEach((other) => {
          if (other !== item) {
            other.classList.remove("active");
          }
        });

        item.classList.toggle("active");
      }
      window.addEventListener("resize", function () {
        // Tutup semua dropdown saat ganti ukuran layar
        closeAllDropdowns();
      });
    });

    // For desktop: show on hover (CSS handles this, but we can add extra functionality)
    if (window.innerWidth > 992) {
      item.addEventListener("mouseenter", function () {
        // Tutup semua dropdown lain terlebih dahulu
        dropdownItems.forEach((other) => {
          if (other !== item) {
            other.classList.remove("active");
          }
        });

        // Buka dropdown yang dihover
        this.classList.add("active");
      });

      item.addEventListener("mouseleave", function () {
        // Tutup dropdown saat mouse keluar
        this.classList.remove("active");
      });
    }
  });

  // Close dropdown when clicking menu item
  const dropdownLinks = document.querySelectorAll(".dropdown-menu a");
  dropdownLinks.forEach((link) => {
    link.addEventListener("click", function () {
      if (window.innerWidth <= 992) {
        const menuToggle = document.getElementById("mobileMenuToggle");
        const navbarMenu = document.getElementById("navbarMenu");

        menuToggle.classList.remove("active");
        navbarMenu.classList.remove("active");
        document.body.classList.remove("menu-open");
      }
    });
  });
}

/**
 * Sticky Navbar on Scroll
 */
function initStickyNavbar() {
  const navbar = document.querySelector(".navbar");

  if (!navbar) return;

  let lastScroll = 0;

  window.addEventListener("scroll", function () {
    const currentScroll = window.pageYOffset;

    if (currentScroll > 100) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }

    lastScroll = currentScroll;
  });
}

/**
 * Set Active Menu Item based on current page
 */
function setActiveMenuItem() {
  // Normalize current path: remove .php extension and trailing slash
  let currentPath = window.location.pathname.replace(/\/$/, "").replace(/\.php$/, "");

  const menuLinks = document.querySelectorAll(".nav-link:not(.dropdown-toggle), .dropdown-menu a");

  menuLinks.forEach((link) => {
    // Normalize link path
    let linkPath = new URL(link.href, window.location.origin).pathname.replace(/\/$/, "").replace(/\.php$/, "");

    if (currentPath === linkPath) {
      // Add active class to the link
      link.classList.add("current-item");

      // If it's inside a dropdown, also mark the dropdown as active
      const dropdown = link.closest(".dropdown");
      if (dropdown) {
        const dropdownToggle = dropdown.querySelector(".dropdown-toggle");
        if (dropdownToggle) {
          dropdownToggle.classList.add("current-item");
        }
      }

      // Also mark the parent nav-item as active
      const navItem = link.closest(".nav-item");
      if (navItem) {
        navItem.classList.add("current-item");
      }
    }
  });
}

/**
 * Close all dropdowns
 */
function closeAllDropdowns() {
  const dropdowns = document.querySelectorAll(".dropdown");
  dropdowns.forEach((dropdown) => {
    dropdown.classList.remove("active");
  });
}

// Export functions for use in other scripts if needed
window.closeAllDropdowns = closeAllDropdowns;
