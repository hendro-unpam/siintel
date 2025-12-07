/**
 * Main JavaScript
 * Sekolah Insan Teladan
 */

// DOM Ready
document.addEventListener("DOMContentLoaded", function () {
  initScrollToTop();
  initSmoothScroll();
  initFormValidation();
  initImageLazyLoad();
  initAnimateOnScroll();
});

/**
 * Scroll to Top Button
 */
function initScrollToTop() {
  const scrollBtn = document.getElementById("scrollToTop");

  if (!scrollBtn) return;

  // Show/hide button based on scroll position
  window.addEventListener("scroll", function () {
    if (window.pageYOffset > 300) {
      scrollBtn.classList.add("show");
    } else {
      scrollBtn.classList.remove("show");
    }
  });

  // Scroll to top on click
  scrollBtn.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
}

/**
 * Smooth Scroll for Anchor Links
 */
function initSmoothScroll() {
  const links = document.querySelectorAll('a[href^="#"]');

  links.forEach((link) => {
    link.addEventListener("click", function (e) {
      const href = this.getAttribute("href");

      // Skip if href is just "#"
      if (href === "#") {
        e.preventDefault();
        return;
      }

      const target = document.querySelector(href);

      if (target) {
        e.preventDefault();
        const offsetTop = target.offsetTop - 80; // Account for fixed header

        window.scrollTo({
          top: offsetTop,
          behavior: "smooth",
        });
      }
    });
  });
}

/**
 * Form Validation
 */
function initFormValidation() {
  const forms = document.querySelectorAll(".needs-validation");

  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }

      form.classList.add("was-validated");
    });

    // Real-time validation
    const inputs = form.querySelectorAll("input, textarea, select");
    inputs.forEach((input) => {
      input.addEventListener("blur", function () {
        validateField(this);
      });

      input.addEventListener("input", function () {
        if (this.classList.contains("is-invalid")) {
          validateField(this);
        }
      });
    });
  });
}

/**
 * Validate Single Field
 */
function validateField(field) {
  const value = field.value.trim();
  const type = field.type;
  const required = field.hasAttribute("required");
  let isValid = true;
  let errorMessage = "";

  // Check if required field is empty
  if (required && !value) {
    isValid = false;
    errorMessage = "Field ini wajib diisi";
  }
  // Email validation
  else if (type === "email" && value) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(value)) {
      isValid = false;
      errorMessage = "Format email tidak valid";
    }
  }
  // Phone validation
  else if (type === "tel" && value) {
    const phoneRegex = /^[0-9]{10,13}$/;
    if (!phoneRegex.test(value.replace(/[\s-]/g, ""))) {
      isValid = false;
      errorMessage = "Format nomor telepon tidak valid";
    }
  }
  // Min length validation
  else if (field.hasAttribute("minlength") && value) {
    const minLength = parseInt(field.getAttribute("minlength"));
    if (value.length < minLength) {
      isValid = false;
      errorMessage = `Minimal ${minLength} karakter`;
    }
  }

  // Update field state
  if (isValid) {
    field.classList.remove("is-invalid");
    field.classList.add("is-valid");
    removeErrorMessage(field);
  } else {
    field.classList.remove("is-valid");
    field.classList.add("is-invalid");
    showErrorMessage(field, errorMessage);
  }

  return isValid;
}

/**
 * Show Error Message
 */
function showErrorMessage(field, message) {
  removeErrorMessage(field);

  const errorDiv = document.createElement("div");
  errorDiv.className = "invalid-feedback";
  errorDiv.textContent = message;
  errorDiv.style.display = "block";

  field.parentNode.appendChild(errorDiv);
}

/**
 * Remove Error Message
 */
function removeErrorMessage(field) {
  const existingError = field.parentNode.querySelector(".invalid-feedback");
  if (existingError) {
    existingError.remove();
  }
}

/**
 * Lazy Load Images
 */
function initImageLazyLoad() {
  const images = document.querySelectorAll("img[data-src]");

  if ("IntersectionObserver" in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          img.removeAttribute("data-src");
          img.classList.add("loaded");
          observer.unobserve(img);
        }
      });
    });

    images.forEach((img) => imageObserver.observe(img));
  } else {
    // Fallback for browsers without IntersectionObserver
    images.forEach((img) => {
      img.src = img.dataset.src;
      img.removeAttribute("data-src");
    });
  }
}

/**
 * Animate Elements on Scroll
 */
function initAnimateOnScroll() {
  const elements = document.querySelectorAll(".animate-on-scroll");

  if (!elements.length) return;

  if ("IntersectionObserver" in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("animated");
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.1,
      }
    );

    elements.forEach((el) => observer.observe(el));
  } else {
    // Fallback: animate all elements immediately
    elements.forEach((el) => el.classList.add("animated"));
  }
}

/**
 * Confirm Delete Action
 */
function confirmDelete(
  message = "Apakah Anda yakin ingin menghapus data ini?"
) {
  return confirm(message);
}

/**
 * Show Alert Message
 */
function showAlert(message, type = "info") {
  const alertDiv = document.createElement("div");
  alertDiv.className = `alert alert-${type}`;
  alertDiv.style.cssText =
    "position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; animation: slideInRight 0.3s ease;";

  const icon = getAlertIcon(type);
  alertDiv.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
    `;

  document.body.appendChild(alertDiv);

  // Auto remove after 5 seconds
  setTimeout(() => {
    alertDiv.style.animation = "fadeOut 0.3s ease";
    setTimeout(() => alertDiv.remove(), 300);
  }, 5000);
}

/**
 * Get Alert Icon
 */
function getAlertIcon(type) {
  const icons = {
    success: "fa-check-circle",
    error: "fa-exclamation-circle",
    warning: "fa-exclamation-triangle",
    info: "fa-info-circle",
  };
  return icons[type] || icons.info;
}

/**
 * Format Number with Thousand Separator
 */
function formatNumber(num) {
  return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

/**
 * Format Date to Indonesian
 */
function formatDate(dateString) {
  const months = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
  ];

  const date = new Date(dateString);
  const day = date.getDate();
  const month = months[date.getMonth()];
  const year = date.getFullYear();

  return `${day} ${month} ${year}`;
}

/**
 * Debounce Function
 */
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

/**
 * Truncate Text
 */
function truncateText(text, maxLength) {
  if (text.length <= maxLength) return text;
  return text.substr(0, maxLength) + "...";
}

// Make functions available globally
window.confirmDelete = confirmDelete;
window.showAlert = showAlert;
window.formatNumber = formatNumber;
window.formatDate = formatDate;
