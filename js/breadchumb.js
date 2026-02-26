document.addEventListener("DOMContentLoaded", () => {
  const path = window.location.pathname;

  const breadcrumbData = {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    itemListElement: [
      {
        "@type": "ListItem",
        position: 1,
        name: "Home",
        item: "https://surenusantara.com/",
      },
    ],
  };

  const addSecondLevel = (name, url) => {
    breadcrumbData.itemListElement.push({
      "@type": "ListItem",
      position: 2,
      name: name,
      item: url,
    });
  };

  if (path.includes("/vision-mission")) {
    addSecondLevel(
      "Vision & Mission",
      "https://surenusantara.com/vision-mission/"
    );
  } else if (path.includes("/services")) {
    addSecondLevel("Services", "https://surenusantara.com/services/");
  } else if (path.includes("/cosultant") || path.includes("/consultants")) {
    addSecondLevel("Consultants", "https://surenusantara.com/consultants/");
  } else if (path.includes("/contact")) {
    addSecondLevel("Contact", "https://surenusantara.com/contact/");
  }

  const script = document.createElement("script");
  script.type = "application/ld+json";
  script.text = JSON.stringify(breadcrumbData);
  document.head.appendChild(script);
});
