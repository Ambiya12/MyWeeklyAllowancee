function toggleHistory(teenName) {
  const section = document.getElementById("history-" + teenName);
  const toggle = document.getElementById("toggle-" + teenName);

  if (section.classList.contains("active")) {
    section.classList.remove("active");
    toggle.textContent = "▼ Show history";
  } else {
    section.classList.add("active");
    toggle.textContent = "▲ Hide history";
  }
}
