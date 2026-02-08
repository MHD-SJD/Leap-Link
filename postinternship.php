<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leap-Link - Leap into your career with confidence</title>
  <link rel="icon" href="images/261bd026-1826-4ac1-b9f1-de4882e0c0ae.png">
  <link rel="stylesheet" href="CSS/Style.css">
  <link rel="stylesheet" href="CSS/Companies.css">
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

    <div class="page-title">
  <h1>
    <i class="ri-add-circle-fill"></i>
    Add New Internship
  </h1>
  <p>Fill in the details below to publish a new internship opportunity</p>
</div>
                    <form id="add-internship-form" class="widget" method="POST" action="">
    <div class="post-form-grid">
        <div>
            <div class="form-group">
                <label>Internship Title</label>
                <input type="text" name="title" placeholder="e.g., Summer Software Engineer Intern" required>
            </div>
            <div class="form-group">
                <label>Location Type</label>
                <select name="location" required>
                    <option>Remote</option>
                    <option>On-Site</option>
                    <option>Hybrid</option>
                </select>
            </div>
            <div class="form-group">
                <label>Required Skills (Comma-separated)</label>
                <input type="text" name="requirements" placeholder="Python, Django, AWS">
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category" id="category">
                    <option value="marketing">Marketing</option>
                    <option value="designing">Designing</option>
                    <option value="sales">Sales</option>
                    <option value="computing">Computing</option>
                    <option value="finance">Finance</option>
                    <option value="automobile">AutoMobile</option>
                    <option value="logistics">Logistics/Delivery</option>
                    <option value="construction">Construction</option>
                </select>
            </div>
            <div class="form-group">
                <label>Duration (Months)</label>
                <input type="number" name="duration" value="3">
            </div>
        </div>
        <div>
            <div class="form-group">
                <label>Stipend / Salary Range(Per Month)</label>
                <input type="number" name="salary" step="0.01">
            </div>
            <div class="form-group">
                <label>Application Deadline</label>
                <input type="date" name="deadline">
            </div>
            <div class="form-group">
                <label>Job Description</label>
                <textarea name="description" placeholder="Provide responsibilities and requirements..." required></textarea>
            </div>
        </div>
    </div>
    <button type="submit" class="submit">Post Internship Now</button>
</form>
                
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
document.addEventListener('DOMContentLoaded', () => {

    /* ---------------- Add Internship ---------------- */
 const internshipForm = document.getElementById("add-internship-form");

    internshipForm.addEventListener("submit", function (e) {
        e.preventDefault(); // prevent default form submit

        const title = this.querySelector("[name=title]").value.trim();
        const description = this.querySelector("[name=description]").value.trim();

        if (!title || !description) {
            alert("⚠️ Please enter both Title and Description");
            return;
        }

        const formData = new FormData(this);

        fetch("../Backend/company/add_internship.php", {
            method: "POST",
            body: formData,
            credentials: "include"
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "posted") {
                alert("✅ Internship posted successfully");
                internshipForm.reset();
                loadInternships();
            } else {
                alert("❌ " + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert("❌ Server error");
        });
    });

  
});
</script>
</body>
</html>






