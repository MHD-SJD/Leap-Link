<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications</title>
    <link rel="stylesheet" href="CSS/Student.css">
    <style>


    </style>
</head>
<body>

<div class="dashboard-container">
    <main class="dashboard-body">

        <!-- APPLICATION PIPELINE -->
        <div id="applications">
            <h1>My Application Pipeline</h1>
            <div class="app-tracker-grid"></div>
        </div>

    </main>
</div>

<!-- APPLICATION DETAILS MODAL -->
<div id="applicationModal" class="modal-overlay">
    <div class="modal-box">
        <span class="close-modal" id="closeModal">&times;</span>
        <div id="modalContent"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const modal = document.getElementById("applicationModal");
    const modalContent = document.getElementById("modalContent");
    const closeModal = document.getElementById("closeModal");
    const appGrid = document.querySelector(".app-tracker-grid");

    /* ---------------- LOAD APPLICATIONS ON PAGE LOAD ---------------- */
    loadMyApplications();

    /* ---------------- CLOSE MODAL ---------------- */
    closeModal.onclick = () => modal.style.display = "none";
    window.onclick = e => { if (e.target === modal) modal.style.display = "none"; };

    /* ---------------- DELEGATED CLICK ---------------- */
    document.addEventListener("click", e => {
        if (e.target.classList.contains("view-details")) {
            e.preventDefault();
            openApplicationDetails(e.target.dataset.id);
        }
    });

    /* ---------------- VIEW APPLICATION DETAILS ---------------- */
    function openApplicationDetails(id) {
        modal.style.display = "flex";
        modalContent.innerHTML = "Loading...";

        fetch(`Backend/student/get_application_details.php?internship_id=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.status !== "success") {
                    modalContent.innerHTML = "Failed to load details";
                    return;
                }

                const d = data.data;
                const logo = d.logo || "Backend/uploads/company_logos/default-logo.png";

                modalContent.innerHTML = `
                    <div class="modal-header">
                        <img src="${logo}" alt="logo">
                        <div>
                            <h3>${d.title}</h3>
                            <p>${d.company_name}</p>
                            <small>${d.location}</small>
                        </div>
                    </div>
                    <div class="modal-body">
                        <p><strong>Email:</strong> ${d.email}</p>
                        <p><strong>Description:</strong><br>${d.description}</p>
                        <p><strong>Requirements:</strong><br>${d.requirements || "N/A"}</p>
                    </div>
                `;
            });
    }

    /* ---------------- LOAD APPLICATIONS ---------------- */
    function loadMyApplications() {
        fetch("Backend/student/my_Application.php")
            .then(res => res.json())
            .then(data => {

                appGrid.innerHTML = "";

                const columns = {
                    "Applied": [],
                    "Interviewing": [],
                    "Offer Received": [],
                    "Rejected": []
                };

                // Map backend status to columns
            data.forEach(app => {
                let colKey = "Applied"; // default
                if (app.status === "Interviewing") colKey = "Interviewing";
                else if (app.status === "Hired") colKey = "Offer Received";
                else if (app.status === "Rejected") colKey = "Not Selected";

                columns[colKey].push(app);
            });

            // Generate HTML for each column
            for (const [colName, apps] of Object.entries(columns)) {
                const colDiv = document.createElement("div");
                colDiv.className = "status-column";
                colDiv.innerHTML = `<h3>${colName} (${apps.length})</h3>`;

                apps.forEach(app => {
                    const appItem = document.createElement("div");
                    let statusClass = "app-item-applied";
                    if (app.status === "Interviewing") statusClass = "app-item-interview";
                    else if (app.status === "Rejected") statusClass = "app-item-rejected";
                    else if (app.status === "Hired") statusClass = "app-item-hired";

                    appItem.className = `app-item ${statusClass}`;
                    appItem.innerHTML = `
                        <strong>${app.company_name}</strong><br>
                        <small>${app.title}</small>
                        <p><i>Applied on: ${new Date(app.date_applied).toLocaleDateString()}</i></p>
                        <a href="#" class="view-details" data-id="${app.internship_id}"> View Details</a>
                    `;
                    colDiv.appendChild(appItem);
                });

                appGrid.appendChild(colDiv);
            }
                
            })
            .catch(() => {
                appGrid.innerHTML = "<p>Error loading applications</p>";
            });
    }

});
</script>

</body>
</html>
