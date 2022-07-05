window.addEventListener("load", function () {
  // Store tabs variables
  let tabs = document.querySelectorAll("ul.nav-tabs > li");

  for (let i = 0; i < tabs.length; i++) {
    tabs[i].addEventListener("click", switchTab);
  }

  function switchTab(event) {
    event.preventDefault();
    document.querySelector("ul.nav-tabs li.active").classList.remove("active");
    document.querySelector(".tab-pane.active").classList.remove("active");

    let clickedTab = event.currentTarget;
    let anchor = event.target;
    let activePanID = anchor.getAttribute("href");

    clickedTab.classList.add("active");
    document.querySelector(activePanID).classList.add("active");
  }
});
