document.addEventListener("DOMContentLoaded", function () {
  document.body.classList.add("page-loaded");

  const appShell = document.getElementById("appShell");
  const sidebarCollapse = document.getElementById("sidebarCollapse");
  const mobileSidebarToggle = document.getElementById("mobileSidebarToggle");
  const sidebarOverlay = document.getElementById("sidebarOverlay");
  const sidebarStorageKey = "flowstaff-sidebar-collapsed";

  if (appShell && localStorage.getItem(sidebarStorageKey) === "true") {
    appShell.classList.add("sidebar-collapsed");
  }

  if (appShell && sidebarCollapse) {
    sidebarCollapse.addEventListener("click", () => {
      appShell.classList.toggle("sidebar-collapsed");
      localStorage.setItem(
        sidebarStorageKey,
        appShell.classList.contains("sidebar-collapsed")
      );
    });
  }

  const openSidebar = () => {
    if (!appShell || !sidebarOverlay) {
      return;
    }
    appShell.classList.add("sidebar-open");
    sidebarOverlay.hidden = false;
    document.body.style.overflow = "hidden";
  };

  const closeSidebar = () => {
    if (!appShell || !sidebarOverlay) {
      return;
    }
    appShell.classList.remove("sidebar-open");
    sidebarOverlay.hidden = true;
    document.body.style.overflow = "";
  };

  if (mobileSidebarToggle) {
    mobileSidebarToggle.addEventListener("click", openSidebar);
  }

  if (sidebarOverlay) {
    sidebarOverlay.addEventListener("click", closeSidebar);
  }

  document.querySelectorAll(".sidebar__link").forEach((link) => {
    link.addEventListener("click", closeSidebar);
  });

  const dashboardAnimatedItems = document.querySelectorAll(
    ".dashboard-hero, .kpi-card, .dashboard-main > .panel, .dashboard-side > .panel"
  );

  dashboardAnimatedItems.forEach((item, index) => {
    item.classList.add("reveal-on-scroll");
    item.style.setProperty("--reveal-delay", `${Math.min(index * 70, 420)}ms`);
  });

  if ("IntersectionObserver" in window && dashboardAnimatedItems.length) {
    const revealObserver = new IntersectionObserver(
      (entries, observer) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.16,
        rootMargin: "0px 0px -70px 0px",
      }
    );

    dashboardAnimatedItems.forEach((item) => revealObserver.observe(item));
  } else {
    dashboardAnimatedItems.forEach((item) => item.classList.add("is-visible"));
  }

  const employeeSearch = document.getElementById("employeeSearch");
  const employeeRows = document.querySelectorAll(".employee-row");
  const noSearchResult = document.getElementById("noSearchResult");

  if (employeeSearch && employeeRows.length) {
    employeeSearch.addEventListener("input", () => {
      const query = employeeSearch.value.trim().toLowerCase();
      let visibleRows = 0;

      employeeRows.forEach((row) => {
        const matches = row.textContent.toLowerCase().includes(query);
        row.hidden = !matches;
        if (matches) {
          visibleRows += 1;
        }
      });

      if (noSearchResult) {
        noSearchResult.hidden = visibleRows > 0;
      }
    });
  }

  const themeToggle = document.getElementById("themeToggle");
  if (themeToggle) {
    const html = document.documentElement;
    const themeIcon = themeToggle.querySelector(".theme-icon");
    const themeStorageKey = "flowstaff-theme";

    const updateThemeUI = () => {
      const isDark = html.getAttribute("data-theme") === "dark";
      if (themeIcon) {
        themeIcon.textContent = isDark ? "☀" : "☾";
      }
    };

    const savedTheme = localStorage.getItem(themeStorageKey);
    if (savedTheme === "light" || savedTheme === "dark") {
      html.setAttribute("data-theme", savedTheme);
    }

    themeToggle.addEventListener("click", () => {
      const currentTheme = html.getAttribute("data-theme") || "dark";
      const newTheme = currentTheme === "dark" ? "light" : "dark";
      html.setAttribute("data-theme", newTheme);
      localStorage.setItem(themeStorageKey, newTheme);
      updateThemeUI();
    });

    updateThemeUI();
  }
});
