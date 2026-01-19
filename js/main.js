//======================= Tailwind Config =======================//
tailwind.config = {
  theme: {
    extend: {
      colors: {
        brand: {
          50: "#eef2ff",
          500: "#6366f1",
          600: "#4f46e5",
          700: "#4338ca",
        },
      },
    },
  },
};

//======================= AOS =======================//
if (typeof AOS !== "undefined") {
  AOS.init({
    duration: 800,
    once: true,
    offset: 100,
  });
}

//======================= Sidebar Toggle Mobile =======================//
document.addEventListener("DOMContentLoaded", function () {
  // Nav toggle for collapsible menu items
  document.addEventListener("click", function (e) {
    const btn = e.target.closest("[data-nav-toggle]");
    if (!btn) return;

    const wrap = btn.closest("[data-nav-group]") || btn.parentElement;
    const panel = wrap ? wrap.querySelector("[data-nav-panel]") : null;
    const icon = btn.querySelector("i.bx-chevron-down");
    if (!panel) return;

    const isOpen = btn.getAttribute("aria-expanded") === "true";
    btn.setAttribute("aria-expanded", (!isOpen).toString());
    panel.classList.toggle("hidden", isOpen);
    if (icon) icon.classList.toggle("rotate-180", !isOpen);
  });

  const sidebar = document.getElementById("sidebar");
  const closeSidebarBtn = document.getElementById("close-sidebar");

  if (!sidebar) {
    console.warn("Sidebar element not found");
    return;
  }

  // Create backdrop if it doesn't exist
  let backdrop = document.getElementById("sidebar-backdrop");
  if (!backdrop) {
    backdrop = document.createElement("div");
    backdrop.id = "sidebar-backdrop";
    backdrop.className =
      "fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity duration-300 opacity-0";
    document.body.appendChild(backdrop);
  }

  function toggleSidebar() {
    if (!sidebar) return;

    const isHidden = sidebar.classList.contains("-translate-x-full");
    if (isHidden) {
      sidebar.classList.remove("-translate-x-full");
      backdrop.classList.remove("hidden");
      setTimeout(() => backdrop.classList.add("opacity-100"), 10);
      document.body.classList.add("overflow-hidden");
    } else {
      sidebar.classList.add("-translate-x-full");
      backdrop.classList.remove("opacity-100");
      setTimeout(() => backdrop.classList.add("hidden"), 300);
      document.body.classList.remove("overflow-hidden");
    }
  }

  if (closeSidebarBtn) {
    closeSidebarBtn.addEventListener("click", toggleSidebar);
  }

  backdrop.addEventListener("click", toggleSidebar);

  // Expose toggleSidebar to window for onclick handlers
  window.toggleSidebar = toggleSidebar;
});

//======================= Sticky Navigation =======================//
document.addEventListener("DOMContentLoaded", function () {
  const header = document.getElementById("main-nav");
  if (!header) return;

  const headerContent = header.querySelector("div.bg-white");
  if (!headerContent) return;

  let ticking = false;
  let isFixed = false;

  // Throttle function untuk optimasi performa
  function updateHeader() {
    const currentScroll =
      window.pageYOffset || document.documentElement.scrollTop;

    if (currentScroll > 50 && !isFixed) {
      // Change from sticky to fixed when scrolled
      headerContent.classList.remove("sticky");
      headerContent.classList.add(
        "fixed",
        "top-0",
        "left-0",
        "right-0",
        "w-full",
        "shadow-md"
      );
      isFixed = true;
    } else if (currentScroll <= 50 && isFixed) {
      // Change back to sticky when at top
      headerContent.classList.remove(
        "fixed",
        "left-0",
        "right-0",
        "w-full",
        "shadow-md"
      );
      headerContent.classList.add("sticky");
      isFixed = false;
    }

    ticking = false;
  }

  window.addEventListener(
    "scroll",
    function () {
      if (!ticking) {
        window.requestAnimationFrame(updateHeader);
        ticking = true;
      }
    },
    { passive: true }
  );
});

//======================= Hamburger Menu Toggle (Mobile Navigation) =======================//
document.addEventListener("DOMContentLoaded", function () {
  const hamburgerBtn = document.getElementById("hamburger-btn");
  const closeMobileMenuBtn = document.getElementById("close-mobile-menu");
  const mobileMenu = document.getElementById("mobile-menu");
  const mobileMenuBackdrop = document.getElementById("mobile-menu-backdrop");

  if (!hamburgerBtn || !mobileMenu || !mobileMenuBackdrop) {
    return;
  }

  const header = document.getElementById("main-nav");
  const headerContent = header ? header.querySelector("div.bg-white") : null;

  function openMobileMenu() {
    mobileMenu.classList.remove("translate-x-full");
    mobileMenuBackdrop.classList.remove("hidden");
    setTimeout(() => {
      mobileMenuBackdrop.classList.add("opacity-100");
    }, 10);
    document.body.classList.add("overflow-hidden");

    if (headerContent) {
      headerContent.style.zIndex = "999";
    }
  }

  function closeMobileMenu() {
    mobileMenu.classList.add("translate-x-full");
    mobileMenuBackdrop.classList.remove("opacity-100");
    setTimeout(() => {
      mobileMenuBackdrop.classList.add("hidden");
    }, 300);
    document.body.classList.remove("overflow-hidden");

    if (headerContent) {
      headerContent.style.zIndex = "";
    }
  }

  hamburgerBtn.addEventListener("click", openMobileMenu);

  if (closeMobileMenuBtn) {
    closeMobileMenuBtn.addEventListener("click", closeMobileMenu);
  }

  mobileMenuBackdrop.addEventListener("click", closeMobileMenu);

  const mobileNavLinks = mobileMenu.querySelectorAll("a[href^='#']");
  mobileNavLinks.forEach((link) => {
    link.addEventListener("click", () => {
      setTimeout(closeMobileMenu, 100);
    });
  });

  document.addEventListener("keydown", function (e) {
    if (
      e.key === "Escape" &&
      !mobileMenu.classList.contains("translate-x-full")
    ) {
      closeMobileMenu();
    }
  });
});

//======================= Service Card Toggle =======================//
function toggleServiceCard(id) {
  const desc = document.getElementById("service-desc-" + id);
  const title = document.getElementById("service-title-" + id);
  const icon = document.getElementById("service-icon-" + id);
  const text = document.getElementById("service-text-" + id);

  if (desc.classList.contains("line-clamp-2")) {
    desc.classList.remove("line-clamp-2");
    if (title) title.classList.remove("line-clamp-1");
    text.textContent = "Show Less";
    icon.style.transform = "rotate(180deg)";
  } else {
    desc.classList.add("line-clamp-2");
    if (title) title.classList.add("line-clamp-1");
    text.textContent = "Learn More";
    icon.style.transform = "rotate(0deg)";
  }
}
window.toggleServiceCard = toggleServiceCard;

//======================= Consultant Card Toggle =======================//
function toggleConsultantCard(id) {
  const desc = document.getElementById("consultant-desc-" + id);
  const title = document.getElementById("consultant-title-" + id);
  const icon = document.getElementById("consultant-icon-" + id);
  const text = document.getElementById("consultant-text-" + id);

  if (desc.classList.contains("line-clamp-2")) {
    desc.classList.remove("line-clamp-2");
    if (title) title.classList.remove("line-clamp-1");
    text.textContent = "Show Less";
    icon.style.transform = "rotate(180deg)";
  } else {
    desc.classList.add("line-clamp-2");
    if (title) title.classList.add("line-clamp-1");
    text.textContent = "Learn More";
    icon.style.transform = "rotate(0deg)";
  }
}
window.toggleConsultantCard = toggleConsultantCard;

//======================= Toggle Password Visibility =======================//
document.addEventListener("DOMContentLoaded", function () {
  // Support for old format (login.php with id="togglePassword")
  const togglePasswordBtn = document.getElementById("togglePassword");
  if (togglePasswordBtn) {
    togglePasswordBtn.addEventListener("click", function () {
      const passwordInput = document.getElementById("password");
      const eyeIcon = document.getElementById("eyeIcon");
      const eyeSlashIcon = document.getElementById("eyeSlashIcon");

      if (!passwordInput || !eyeIcon || !eyeSlashIcon) return;

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.add("hidden");
        eyeSlashIcon.classList.remove("hidden");
      } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("hidden");
        eyeSlashIcon.classList.add("hidden");
      }
    });
  }

  // Support for new format with data-toggle-password attribute (register.php)
  const toggleButtons = document.querySelectorAll("[data-toggle-password]");
  toggleButtons.forEach((btn) => {
    btn.addEventListener("click", function () {
      const passwordId = btn.getAttribute("data-toggle-password");
      const passwordInput = document.getElementById(passwordId);
      const eyeIcon = btn.querySelector(`[data-eye-icon="${passwordId}"]`);
      const eyeSlashIcon = btn.querySelector(
        `[data-eye-slash-icon="${passwordId}"]`
      );

      if (!passwordInput || !eyeIcon || !eyeSlashIcon) return;

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.add("hidden");
        eyeSlashIcon.classList.remove("hidden");
      } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("hidden");
        eyeSlashIcon.classList.add("hidden");
      }
    });
  });
});

//======================= Active Link Highlighting =======================//
document.addEventListener("DOMContentLoaded", function () {
  const currentPath = window.location.pathname;

  // Normalize path to handle / and /index.php equivalence
  const normalizePath = (path) => {
    // Treat root and index.php as the same
    if (path === "/" || path === "/index.php" || path === "") return "/";

    // Remove trailing slash for consistency
    let p = path.endsWith("/") ? path.slice(0, -1) : path;

    // Remove /index.php from end if present (e.g. /contact/index.php -> /contact)
    if (p.endsWith("/index.php")) return p.replace("/index.php", "");

    return p;
  };

  const normalizedCurrent = normalizePath(currentPath);

  // Select all navigation links (Desktop & Mobile)
  // Targeting specific nav structures based on Header.php
  const navLinks = document.querySelectorAll(
    "header#main-nav nav ul li a, #mobile-menu nav ul li a"
  );

  navLinks.forEach((link) => {
    const href = link.getAttribute("href");
    // Skip hash links, mailto, tel, etc.
    if (
      !href ||
      href.startsWith("#") ||
      href.startsWith("mailto:") ||
      href.startsWith("tel:")
    )
      return;

    try {
      const linkUrl = new URL(link.href, window.location.origin);
      const linkPath = linkUrl.pathname;

      if (normalizePath(linkPath) === normalizedCurrent) {
        // Remove default inactive classes
        link.classList.remove("text-[#333]", "font-normal", "no-underline");

        // Add active classes (blue color to match Header.php)
        link.classList.add("text-[#505CEE]", "font-semibold");
      }
    } catch (e) {
      // Ignore invalid URLs
    }
  });
});
