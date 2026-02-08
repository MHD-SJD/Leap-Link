<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/admin.css">
</head>
<body>
    
    <div id="admin-view" class="dashboard-container">
        
        <aside class="sidebar">
            <div class="logo" style="color: var(--primary-color);"><i class="fas fa-user-shield"></i> Admin Panel</div>
            <nav class="nav-links">
                <a class="nav-item active" data-target="dashboard-admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a class="nav-item" data-target="manage-students"><i class="fas fa-user-graduate"></i> Manage Students <span class="badge">1200</span></a>
                <a class="nav-item" data-target="manage-companies"><i class="fas fa-building"></i> Manage Companies <span class="badge">50</span></a>
                <a class="nav-item" data-target="post-moderation"><i class="fas fa-flag"></i> Post Moderation <span class="badge" style="background-color: var(--danger-color); color: white;">5</span></a>
                <a class="nav-item" data-target="analytics-admin"><i class="fas fa-chart-bar"></i> Platform Analytics</a>
                <a class="nav-item" data-target="system-settings"><i class="fas fa-cogs"></i> System Settings</a>
            </nav>
        </aside>

        <div class="main-content">
            

            <main class="dashboard-body">
                
                <div id="dashboard-admin" class="content-section active">
                    <h1>Platform Overview</h1>
                   <div class="stat-card">
    <h3>Total Users</h3>
    <p class="stat-number" id="totalUsers">0</p>
</div>

<div class="stat-card">
    <h3>Active Internships</h3>
    <p class="stat-number" id="activeInternships">0</p>
</div>

<div class="stat-card">
    <h3>New Signups (Today)</h3>
    <p class="stat-number" id="newSignups" style="color: var(--success-color);">0</p>
</div>

<div class="stat-card">
    <h3>Reported Posts</h3>
    <p class="stat-number" id="reportedPosts" style="color: var(--danger-color);">0</p>
</div>

                    
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                        <div class="widget">
                            <h2>Recent Activity Log</h2>
                            <ul style="list-style: none; padding: 0;">
                                <li style="padding: 8px 0; border-bottom: 1px solid var(--bg-light);">[2:05 PM] Company **'Acme Corp'** updated their profile.</li>
                                <li style="padding: 8px 0; border-bottom: 1px solid var(--bg-light);">[1:40 PM] New internship **'UX Design Intern'** posted.</li>
                                <li style="padding: 8px 0; border-bottom: 1px solid var(--bg-light);">[1:15 PM] Student **'Sara Chen'** completed profile.</li>
                                <li style="padding: 8px 0;">[12:30 PM] **5** applicants received for SDE Intern (Google).</li>
                            </ul>
                            <a class="view-all-link" data-target="analytics-admin">View Full Audit Log →</a>
                        </div>
                        <div class="widget">
                            <h2>Quick Actions</h2>
                            <button class="cta-button" data-target="manage-companies" style="display: block; width: 100%; margin-bottom: 10px;"><i class="fas fa-check"></i> Verify Pending Companies</button>
                            <button class="cta-button" data-target="post-moderation" style="display: block; width: 100%; background-color: var(--danger-color);"><i class="fas fa-flag"></i> Review Reports</button>
                            <button class="cta-button" data-target="system-settings" style="display: block; width: 100%; background-color: var(--secondary-color); margin-top: 10px;"><i class="fas fa-database"></i> Backup System</button>
                        </div>
                    </div>
                </div>

                <div id="manage-students" class="content-section">
    <h1><i class="fas fa-user-graduate"></i> Manage Student Accounts</h1>
    <div class="widget">
        <table class="list-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Academic Year</th>
                    <th>Major</th>
                    <th>Total Application Applied</th>
                </tr>
            </thead>
            <tbody id="studentTableBody"></tbody>
        </table>
    </div>
</div>


               <div id="manage-companies" class="content-section">
    <h1><i class="fas fa-building"></i> Manage Company Accounts</h1>
    <div class="widget">
        <table class="list-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Company Name</th>
                    <th>Total Posts</th>
                    <th>Total Application received</th>
                </tr>
            </thead>
            <tbody id="companyTableBody"></tbody>
        </table>
    </div>
</div>


                <div id="post-moderation" class="content-section">
                    <h1><i class="fas fa-flag"></i> Internship Post Moderation</h1>
                    <div class="widget">
                        <table class="list-table">
                            <thead>
                                <tr><th>Post ID</th><th>Internship Title</th><th>Report Count</th><th>Reason</th><th>Actions</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>P101</td><td>Data Entry Clerk</td><td>3</td><td>Suspicious Stipend</td>
                                    <td>
                                        <a class="action-link" style="color: var(--warning-color);">Review</a>
                                        <button class="btn-danger-small">Take Down</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>P105</td><td>Python Developer</td><td>2</td><td>Inappropriate Content</td>
                                    <td><a class="action-link" style="color: var(--warning-color);">Review</a><button class="btn-danger-small">Take Down</button></td>
                                </tr>
                                <tr>
                                    <td>P109</td><td>Remote Marketing</td><td>0</td><td>Pending Admin Approval</td>
                                    <td><button class="cta-button" style="padding: 5px 10px;">Approve</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="analytics-admin" class="content-section">
                    <h1><i class="fas fa-chart-bar"></i> Platform Analytics</h1>
                    <div class="widget" style="margin-bottom: 20px;">
                        <h2>User Growth Over Time</h2>
                        <div class="placeholder-content" style="min-height: 250px; background-color: var(--bg-light);"></div>
                    </div>
                    <div class="widget">
                        <h2>Top Internships by Applications</h2>
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 8px 0; border-bottom: 1px solid var(--bg-light);">1. SDE Intern (Microsoft) - **150 Apps**</li>
                            <li style="padding: 8px 0; border-bottom: 1px solid var(--bg-light);">2. Financial Analyst (JP Morgan) - **120 Apps**</li>
                            <li style="padding: 8px 0;">3. Data Scientist (Google) - **95 Apps**</li>
                        </ul>
                    </div>
                </div>
                
                <div id="system-settings" class="content-section">
                    <h1><i class="fas fa-cogs"></i> System Configuration</h1>
                    <form class="widget">
                        <h2>Platform Features</h2>
                        <div class="form-group">
                            <label for="reg-status">Student Registration Status</label>
                            <select id="reg-status">
                                <option value="open" style="color: var(--success-color);" selected>Open</option>
                                <option value="closed" style="color: var(--danger-color);">Closed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="min-match">Minimum Match Score for Messaging</label>
                            <input type="number" id="min-match" value="70">
                        </div>
                        <div class="form-group">
                            <label for="default-stipend">Default Stipend Currency</label>
                            <input type="text" id="default-stipend" value="USD">
                        </div>
                        <button type="submit" class="cta-button">Save System Settings</button>
                    </form>
                </div>

            </main>
        </div>

    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            const navTriggers = document.querySelectorAll('[data-target]');
            const contentSections = document.querySelectorAll('.content-section');
            const navItems = document.querySelectorAll('.nav-item');

            function navigateTo(targetId) {
                // 1. Hide all content sections and remove 'active' class from all nav items
                contentSections.forEach(section => {
                    section.classList.remove('active');
                });
                navItems.forEach(item => {
                    item.classList.remove('active');
                });

                // 2. Show the target content section
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add('active');
                }

                // 3. Set the corresponding sidebar item as active
                const activeNavItem = document.querySelector(`.nav-item[data-target="${targetId}"]`);
                if (activeNavItem) {
                    activeNavItem.classList.add('active');
                }
            }

            // Add click listener to all navigation triggers 
            navTriggers.forEach(trigger => {
                trigger.addEventListener('click', (event) => {
                    event.preventDefault(); 
                    const targetId = trigger.getAttribute('data-target');
                    navigateTo(targetId);
                });
            });
            
            // Set initial state
            navigateTo('dashboard-admin');

            // Dummy form submission for demonstration
            document.getElementById('admin-view').querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    alert("Admin settings saved successfully!");
                });
            });
        });
    </script>

    <script>
document.addEventListener('DOMContentLoaded', () => {

    /* ================= MANAGE STUDENTS ================= */

    function loadStudents() {
        fetch("Backend/admin/manage_student.php")
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("studentTableBody");
            tbody.innerHTML = "";

            data.forEach(student => {
                tbody.innerHTML += `
                    <tr>
                        <td>${student.email}</td>
                        <td>${student.full_name}</td>
                        <td>${student.academic_year}</td>
                        <td>${student.field ?? '-'}</td>
                        <td>${student.total_applications}</td>
                    </tr>
                `;
            });
        })
        .catch(err => {
            console.error("Failed to load students", err);
        });
    }

    // Load students when Manage Students tab is clicked
    document.querySelector('[data-target="manage-students"]')
        .addEventListener('click', loadStudents);

});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ================= MANAGE COMPANIES ================= */

    function loadCompanies() {
        fetch("Backend/admin/manage_Company.php")
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("companyTableBody");
            tbody.innerHTML = "";

            data.forEach(company => {
                tbody.innerHTML += `
                    <tr>
                        <td>${company.email}</td>
                        <td>${company.company_name}</td>
                        <td>${company.total_posts}</td>
                        <td>${company.total_applications}</td>
                    </tr>
                `;
            });
        })
        .catch(err => {
            console.error("Failed to load companies", err);
        });
    }

    // Load companies when Manage Companies tab is clicked
    document.querySelector('[data-target="manage-companies"]')
        .addEventListener('click', loadCompanies);

});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    function loadDashboardStats() {
        fetch("Backend/admin/dashboard_states.php")
        .then(res => res.json())
        .then(data => {
            document.getElementById("totalUsers").textContent = data.total_users;
            document.getElementById("activeInternships").textContent = data.active_internships;
            document.getElementById("newSignups").textContent = data.new_signups;
            document.getElementById("reportedPosts").textContent = data.reported_posts;
        })
        .catch(err => {
            console.error("Failed to load dashboard stats", err);
        });
    }

    // Load stats when dashboard opens
    document.querySelector('[data-target="dashboard-admin"]')
        .addEventListener('click', loadDashboardStats);

    // Initial load
    loadDashboardStats();
});
</script>


</body>
</html>