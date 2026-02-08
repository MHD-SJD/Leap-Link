<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Internships | Leap-Link</title>

  <link rel="stylesheet" href="CSS/Style.css" />
  <link rel="stylesheet" href="CSS/Companies.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

  <!-- Page Title -->
  <div class="page-title">
    <h1><i class="ri-clipboard-fill"></i> Manage Posted Internships</h1>
    <p>View, manage and track your internship postings</p>
  </div>
  <!-- Filter -->
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

<!-- Table -->
<div class="max-w-6xl mx-auto mt-4 bg-white rounded-xl shadow-lg p-6">
  <table class="w-full">
    <thead class="bg-indigo-600 text-white">
      <tr>
        <th class="p-3 text-left">Title</th>
        <th class="p-3">Category</th>
        <th class="p-3">Location</th>
        <th class="p-3">Applicants</th>
        <th class="p-3">Actions</th>
      </tr>
    </thead>
    <tbody id="internshipTable"></tbody>
  </table>
</div>
<!-- Edit Internship Modal -->
<div id="editModal" class="modal hidden">
  <div class="modal-content">
    <h2 class="text-2xl font-semibold mb-4">
      <i class="ri-edit-2-fill"></i> Edit Internship
    </h2>

    <form id="editInternshipForm">
      <input type="hidden" name="internship_id" id="edit_id">

      <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" id="edit_title" required>
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea name="description" id="edit_description" required></textarea>
      </div>

      <div class="form-group">
        <label>Required Skills</label>
        <input type="text" name="requirements" id="edit_requirements">
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label>Duration (Months)</label>
          <input type="number" name="duration" id="edit_duration">
        </div>

        <div class="form-group">
          <label>Salary</label>
          <input type="number" name="salary" id="edit_salary">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label>Location</label>
          <select name="location" id="edit_location">
            <option>Remote</option>
            <option>On-Site</option>
            <option>Hybrid</option>
          </select>
        </div>

        <div class="form-group">
          <label>Deadline</label>
          <input type="date" name="deadline" id="edit_deadline">
        </div>
      </div>

      <div class="flex justify-end gap-3 mt-6">
        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">
          Cancel
        </button>
        <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded">
          Update Internship
        </button>
      </div>
    </form>
  </div>
</div>

<!------------------------------------------------------------>
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
  <script src="JAVASCRIPT/manage-internship.js"></script>

  <script>
    let internships = [];

document.addEventListener("DOMContentLoaded", () => {
  loadInternships();
  document.getElementById("categoryFilter").addEventListener("change", filterData);
});

function loadInternships() {
  fetch("../Backend/company/list_internship.php", {
    credentials: "include"
  })
    .then(res => res.json())
    .then(data => {
      if (data.status !== "success") {
        alert(data.message);
        return;
      }
      internships = data.data;
      renderTable(internships);
    });
}

function renderTable(data) {
  const table = document.getElementById("internshipTable");
  table.innerHTML = "";

  if (data.length === 0) {
    table.innerHTML = `
      <tr>
        <td colspan="5" class="text-center p-6 text-gray-500">
          No internships found
        </td>
      </tr>`;
    return;
  }

  data.forEach(i => {
    table.innerHTML += `
      <tr class="border-b hover:bg-gray-50">
        <td class="p-3 font-semibold">${i.title}</td>
        <td class="p-3 text-center">${i.category}</td>
        <td class="p-3 text-center">${i.location}</td>
        <td class="p-3 text-center">
          <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">
            ${i.total_applications}
          </span>
        </td>
        <td class="p-3 text-center space-x-3">
          <button onclick="editPost(${i.internship_id})" class="text-green-600">
            Edit
          </button>
          <button onclick="deletePost(${i.internship_id})" class="text-red-600">
            Delete
          </button>
        </td>
      </tr>
    `;
  });
}

function filterData() {
  const category = document.getElementById("categoryFilter").value;
  if (category === "all") {
    renderTable(internships);
  } else {
    renderTable(internships.filter(i => i.category === category));
  }
}

function editPost(id) {
  window.location.href = `edit-internship.html?id=${id}`;
}

function deletePost(id) {
  if (!confirm("Are you sure you want to delete this internship?")) return;

  fetch("../Backend/company/delete_internship.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `internship_id=${id}`,
    credentials: "include"
  })
    .then(res => res.json())
    .then(data => {
      if (data.status === "success") {
        alert("Internship deleted");
        loadInternships();
      } else {
        alert(data.message);
      }
    });
}
//---------------------------------------------------------------------
function editPost(id) {
  fetch(`../Backend/company/get_internship.php?id=${id}`, {
    credentials: "include"
  })
    .then(res => res.json())
    .then(data => {
      if (data.status !== "success") return alert("Failed to load data");

      const i = data.data;
      document.getElementById("edit_id").value = i.internship_id;
      document.getElementById("edit_title").value = i.title;
      document.getElementById("edit_description").value = i.description;
      document.getElementById("edit_requirements").value = i.requirements;
      document.getElementById("edit_duration").value = i.duration;
      document.getElementById("edit_salary").value = i.salary;
      document.getElementById("edit_location").value = i.location;
      document.getElementById("edit_deadline").value = i.deadline;

      openModal();
    });
}

function openModal() {
  document.getElementById("editModal").classList.remove("hidden");
}

function closeModal() {
  document.getElementById("editModal").classList.add("hidden");
}

/* ---------- SUBMIT UPDATE ---------- */
document.getElementById("editInternshipForm").addEventListener("submit", e => {
  e.preventDefault();

  const formData = new FormData(e.target);

  fetch("../Backend/company/update_internship.php", {
    method: "POST",
    body: formData,
    credentials: "include"
  })
    .then(res => res.json())
    .then(data => {
      if (data.status === "updated") {
        alert("Internship updated successfully");
        closeModal();
        loadInternships();
      } else {
        alert(data.message || "Update failed");
      }
    });
});

  </script>
</body>
</html>
