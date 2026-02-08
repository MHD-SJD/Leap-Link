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
  <style>
    .fade-in {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(6px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

  </style>
  
</head>
<body class="bg-gradient-to-b from-indigo-50 to-white text-gray-800 font-sans">
    
    <section class="section__container job__container" id="Companies">
      <h2 class="section__header"><span>Latest & Top</span> Job Internships</h2>
      <p class="section__description">
        Discover Exciting New Opportunities and High-Demand Job Internships Available
        Now in Top Industries and Companies
      </p>
<div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search internships, companies...">
 </div>
      <div class="job__grid" id="jobGrid"></div>

    </section>
    <div id="jobModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
  <div class="bg-white rounded-lg max-w-2xl w-full p-6 relative">

    <button onclick="closeModal()" class="absolute top-3 right-4 text-2xl">&times;</button>

    <div class="flex items-center gap-4 mb-4">
      <img id="mLogo" class="w-16 h-16 object-contain">
      <div>
        <h3 id="mCompany" class="text-xl font-semibold"></h3>
        <p id="mCompanyLocation" class="text-gray-500"></p>
        <p id="mCompanyEmail" class="text-sm text-gray-400"></p>
      </div>
    </div>
    <h4 id="mTitle" class="text-lg font-bold mb-2"></h4>
    <p id="mDescription" class="mb-3"></p>
    <p id="mRequirements" class="text-sm mb-3"></p>

    <div class="flex justify-between mb-4">
      <span id="mDuration"></span>
      <span id="mSalary"></span>
      <span id="mLocationType"></span>
    </div>

    <button onclick="applyInternship()" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
      Apply Internship
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
const jobGrid = document.getElementById("jobGrid");
const searchInput = document.getElementById("searchInput");

let allInternships = [];
let filteredInternships = [];
let selectedInternshipId = null;

/* LOAD ALL INTERNSHIPS */
fetch("Backend/student/get_all_automobile_internship.php")
  .then(res => res.json())
  .then(data => {
      allInternships = data;
      filteredInternships = data;
      renderJobs();
  })
  .catch(err => console.error(err));
function renderJobs() {
    jobGrid.innerHTML = "";

    if (filteredInternships.length === 0) {
        jobGrid.innerHTML = `
          <p class="text-center text-gray-500 col-span-full">
            No internships found
          </p>`;
        return;
    }

    filteredInternships.forEach((job, index) => {
        const card = document.createElement("div");
        card.className = "job__card fade-in";
        card.onclick = () => openModal(index);

        card.innerHTML = `
          <div class="job__card__header">
            <img src="${job.logo}" alt="logo">
            <div>
              <h5>${job.company_name}</h5>
              <h6>${job.company_location}</h6>
            </div>
          </div>

          <h4>${job.title}</h4>
          <p>${job.description.substring(0, 120)}...</p>

          <div class="job__card__footer">
            <span>${job.location_type}</span>
            <span>$${job.salary ?? "Not disclosed"}</span>
          </div>
        `;

        jobGrid.appendChild(card);
    });
}
searchInput.addEventListener("input", () => {
    const q = searchInput.value.toLowerCase().trim();

    filteredInternships = allInternships.filter(job =>
        job.title.toLowerCase().includes(q) ||
        job.company_name.toLowerCase().includes(q)
    );

    renderJobs();
});
// Apply internship (backend-ready)
function applyInternship() {
  if (!selectedInternshipId) return;

  fetch("Backend/student/apply_internship.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `internship_id=${selectedInternshipId}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === "success") {
      alert("✅ Internship applied successfully!");
      closeModal();
    } else {
      alert("⚠️ " + data.message);
    }
  })
  .catch(err => {
    console.error(err);
    alert("❌ Server error. Please try again.");
  });
}
function openModal(index) {
    const job = filteredInternships[index];
    selectedInternshipId = job.internship_id;

    document.getElementById("mLogo").src = job.logo;
    document.getElementById("mCompany").innerText = job.company_name;
    document.getElementById("mCompanyLocation").innerText = job.company_location;
    document.getElementById("mCompanyEmail").innerText = job.company_email;
    document.getElementById("mTitle").innerText = job.title;
    document.getElementById("mDescription").innerText = job.description;
    document.getElementById("mRequirements").innerText = job.requirements ?? "";
    document.getElementById("mDuration").innerText = "Duration: " + job.duration;
    document.getElementById("mSalary").innerText = "Salary: $" + (job.salary ?? "N/A");
    document.getElementById("mLocationType").innerText = job.location_type;

    document.getElementById("jobModal").classList.remove("hidden");
}

function closeModal() {
    document.getElementById("jobModal").classList.add("hidden");
}
</script>
</body>
</html>