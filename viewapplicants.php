<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leap-Link - Leap into your career with confidence</title>
  <link rel="icon" href="images/261bd026-1826-4ac1-b9f1-de4882e0c0ae.png">
  <link rel="stylesheet" href="CSS/Style.css">
  <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  
</head>
<body class="bg-gradient-to-b from-indigo-50 to-white text-gray-800 font-sans">
  <section class="section__container job__container">
    

  <h2 class="section__header"><span>Internship</span> Applicants</h2>

  <div class="max-w-6xl mx-auto mt-6 flex justify-end">
  <select id="categoryFilter" class="border rounded px-4 py-2">
    <option value="all">All Categories</option>
    <option value="marketing">Marketing</option>
    <option value="designing">Designing</option>
    <option value="sales">Sales</option>
    <option value="computing">Computing</option>
    <option value="finance">Finance</option>
    <option value="automobile">Automobile</option>
    <option value="logistics">Logistics</option>
    <option value="construction">Construction</option>
  </select>
</div>

  <div id="applicantsGrid" class="job__grid"></div>
</section>

<!-- MODAL -->
<div id="applicantModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
  <div class="bg-white w-full max-w-lg rounded-xl p-6 relative">
    <button onclick="closeModal()" class="absolute top-3 right-4 text-xl">&times;</button>

    <div class="text-center">
      <img id="mImage" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover">
      <h3 id="mName" class="text-xl font-semibold"></h3>
      <p id="mYear" class="text-sm text-gray-500"></p>
    </div>

    <p class="mt-4"><b>Skills:</b> <span id="mSkills"></span></p>
    <p class="mt-2"><b>Summary:</b> <span id="mSummary"></span></p>

    <div class="mt-4 flex justify-between">
      <a id="mPortfolio" target="_blank" class="text-indigo-600">Portfolio</a>
      <a id="mResume" target="_blank" class="text-indigo-600">View Resume</a>
    </div>

    <select id="statusSelect" class="mt-4 w-full border rounded p-2">
      <option>Pending</option>
      <option>Reviewed</option>
      <option>Interviewing</option>
      <option>Rejected</option>
      <option>Hired</option>
    </select>

    <button onclick="updateStatus()" class="mt-4 w-full bg-indigo-600 text-white py-2 rounded">
      Update Status
    </button>
  </div>
</div>



<!--------------------------------------------------------------------------------------------->
    <footer class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white text-center py-10 mt-12" id="Contact">
    <div class="max-w-7xl mx-auto px-6">
      <h4 class="text-2xl font-semibold mb-3">Leap-Link</h4>
      <p class="mb-4 text-indigo-100">Your gateway to global internships and career opportunities.</p>
      <div class="flex justify-center space-x-6 mb-4">
        <i data-feather="facebook"></i>
        <i data-feather="twitter"></i>
        <i data-feather="linkedin"></i>
        <i data-feather="github"></i>
      </div>
      <p class="text-sm text-indigo-100">&copy; 2025 Leap-Link. All rights reserved.</p>
    </div>
  </footer>
     <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
   <script src="JAVASCRIPT/script.js"></script>
   <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
let applicants = [];
let currentApplicationId = null;
const IMAGE_BASE = "../backend/uploads/profile_images/";
const RESUME_BASE = "../backend/uploads/resumes/";



/* ---------- LOAD APPLICANTS ---------- */
document.addEventListener("DOMContentLoaded", () => {
  loadApplicants();
  document.getElementById("categoryFilter")
    .addEventListener("change", filterApplicants);
});

function loadApplicants() {
  fetch("../backend/company/get_applicants.php", {
    credentials: "include"
  })
    .then(res => res.json())
    .then(data => {
      if (data.status !== "success") {
        alert("Failed to load applicants");
        return;
      }
      applicants = data.data;
      renderApplicants(applicants);
    });
}

/* ---------- RENDER CARDS ---------- */
function renderApplicants(data) {
  const grid = document.getElementById("applicantsGrid");
  grid.innerHTML = "";

  if (data.length === 0) {
    grid.innerHTML = `
      <p class="text-gray-500 col-span-full text-center">
        No applicants found
      </p>`;
    return;
  }

  data.forEach(a => {
    const card = document.createElement("div");
    card.className = "job__card cursor-pointer";

    card.innerHTML = `
  <div class="job__card__header">
    <img src="${a.profile_image 
  ? IMAGE_BASE + a.profile_image 
  : 'images/default.png'}"
  onerror="this.src='images/default.png'">

    <div>
      <h5>${a.full_name}</h5>
      <h6>${a.internship_title}</h6>
    </div>
  </div>

  <p>${a.professional_summary.substring(0, 80)}...</p>

  <div class="job__card__footer">
    <span>${a.category}</span>
    <span>${a.status}</span>
  </div>
`;


    card.onclick = () => openModal(a);
    grid.appendChild(card);
  });
}

/* ---------- FILTER BY CATEGORY ---------- */
function filterApplicants() {
  const category = document.getElementById("categoryFilter").value;

  if (category === "all") {
    renderApplicants(applicants);
  } else {
    renderApplicants(
      applicants.filter(a => a.category === category)
    );
  }
}

/* ---------- MODAL ---------- */
function openModal(a) {
  currentApplicationId = a.application_id;

document.getElementById("mImage").src = a.profile_image
  ? IMAGE_BASE + a.profile_image
  : "images/default.png";



  document.getElementById("mName").innerText = a.full_name;
  document.getElementById("mYear").innerText = a.academic_year;
  document.getElementById("mSkills").innerText = a.skills;
  document.getElementById("mSummary").innerText = a.professional_summary;
  document.getElementById("mPortfolio").href = a.portfolio_link;
document.getElementById("mResume").href = a.resume
  ? RESUME_BASE + a.resume
  : "#";

  document.getElementById("statusSelect").value = a.status;

  document.getElementById("applicantModal").classList.remove("hidden");
  document.getElementById("applicantModal").classList.add("flex");
}

function closeModal() {
  document.getElementById("applicantModal").classList.add("hidden");
}

/* ---------- UPDATE STATUS ---------- */
function updateStatus() {
  const status = document.getElementById("statusSelect").value;

  fetch("../backend/company/update-application-status.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      application_id: currentApplicationId,
      status: status
    }),
    credentials: "include"
  })
  .then(res => res.json())
  .then(() => {
    alert("Status updated");
    closeModal();
    loadApplicants();
  });
}
</script>

</body>
</html>