<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Analytics | Leap-Link</title>
  <link rel="stylesheet" href="CSS/Style.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body {
  font-family: 'Inter', sans-serif;
}

canvas {
  width: 100% !important;
  height: 300px !important;
}

.shadow {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.shadow:hover {
  transform: translateY(-4px);
  box-shadow: 0 15px 25px rgba(0,0,0,0.1);
}

</style>
</head>
<body class="bg-gray-50 font-sans">

  <section class="max-w-7xl mx-auto p-6">
   <div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-3xl font-bold text-gray-800">Company Analytics</h1>
    <p class="text-gray-500 mt-1">Overview of internships and applications</p>
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white shadow rounded-lg p-6 text-center">
      <h2 class="text-lg font-semibold">Total Applications</h2>
      <p id="totalApplications" class="text-2xl font-bold text-indigo-600">0</p>
    </div>
    <div class="bg-white shadow rounded-lg p-6 text-center">
      <h2 class="text-lg font-semibold">Total Internships</h2>
      <p id="totalInternships" class="text-2xl font-bold text-green-600">0</p>
    </div>
    <div class="bg-white shadow rounded-lg p-6 text-center">
      <h2 class="text-lg font-semibold">Conversion Rate</h2>
      <p id="conversionRate" class="text-2xl font-bold text-pink-600">0%</p>
    </div>
  </div>

  <!-- Charts -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white shadow rounded-lg p-6">
      <h2 class="text-lg font-semibold mb-4">Applications Over Time</h2>
      <canvas id="lineChart"></canvas>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
      <h2 class="text-lg font-semibold mb-4">Application Pipeline</h2>
      <canvas id="barChart"></canvas>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
fetch("../backend/company/analytics.php", { credentials: "include" })
  .then(res => res.json())
  .then(data => {
    // Update Cards
    document.getElementById("totalApplications").innerText = data.applications;
    document.getElementById("totalInternships").innerText = data.internships;
    const rate = data.internships > 0 
      ? ((data.applications / data.internships) * 100).toFixed(1) 
      : 0;
    document.getElementById("conversionRate").innerText = rate + "%";

    // LINE CHART - Applications Over Time
    const lineCtx = document.getElementById("lineChart").getContext("2d");
    new Chart(lineCtx, {
      type: 'line',
      data: {
        labels: data.lineChart.map(d => d.date),
        datasets: [{
          label: 'Applications',
          data: data.lineChart.map(d => d.total),
          backgroundColor: 'rgba(99,102,241,0.2)',
          borderColor: 'rgba(99,102,241,1)',
          borderWidth: 2,
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          x: { title: { display: true, text: 'Date' } },
          y: { title: { display: true, text: 'Applications' }, beginAtZero: true }
        }
      }
    });

    // BAR CHART - Pipeline
    const barCtx = document.getElementById("barChart").getContext("2d");
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: Object.keys(data.pipeline),
        datasets: [{
          label: 'Applicants',
          data: Object.values(data.pipeline),
          backgroundColor: [
            '#FBBF24', '#60A5FA', '#10B981', '#EC4899', '#F87171'
          ]
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
      }
    });
  });
</script>

</body>
</html>
