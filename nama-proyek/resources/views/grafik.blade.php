<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Penduduk Indonesia 2024</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jsPDF Library (for PDF export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- PapaParse Library (for CSV export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

    <!-- SheetJS Library (for Excel export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

    <style>
        body {
            background-color: #007bff;
            color: #fff;
        }

        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
            padding-top: 20px;
            width: 250px;
            transition: all 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 999;
            padding-left: 20px;
            padding-right: 20px;
        }

        .sidebar .nav-link {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            transition: background-color 0.3s ease, font-weight 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: #28a745;
            font-weight: bold;
            color: #fff;
        }

        .sidebar.collapsed {
            width: 0;
            padding: 0;
            overflow: hidden;
        }

        .content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            padding: 20px;
        }

        .content.collapsed {
            margin-left: 0;
        }

        .toggle-btn {
            font-size: 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }

        .card {
            background-color: #fff;
            color: #000;
        }

        .card-body {
            padding: 2rem;
        }

        /* Styling Search Bar in Header */
        .header-search {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .header-search select,
        .header-search input {
            margin-right: 10px;
        }

        /* Make Sidebar and Content Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                width: 0;
                height: 100%;
                top: 0;
                left: 0;
                transition: width 0.3s ease;
            }

            .content {
                margin-left: 0;
            }

            .sidebar.collapsed {
                width: 0;
            }

            .toggle-btn {
                display: block;
                left: 10px;
                top: 10px;
                position: absolute;
            }

            .content.collapsed {
                margin-left: 0;
            }

            /* Make Sidebar's Links stacked on smaller screens */
            .sidebar .nav-item {
                text-align: center;
            }

            .sidebar .nav-link {
                padding: 15px 20px;
                font-size: 16px;
            }
        }

        /* Styling for Footer */
        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            width: 100%;
            bottom: 0;
        }

        footer a {
            color: #28a745;
            text-decoration: none;
        }

        /* Logo Styling */
        .sidebar img {
            width: 100px;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3" id="sidebar">
            <img src="https://www.w3.org/html/logo/downloads/HTML5_Logo_512.png" alt="Logo W3Schools" class="img-fluid">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Grafik Penduduk</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Laporan</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="content flex-fill p-4" id="content">
            <!-- Header with Search Bar and Filters -->
            <div class="header-search">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <select class="form-select me-2" aria-label="Filter by Year">
                        <option selected>Filter by Year</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                    </select>
                    <select class="form-select me-2" aria-label="Filter by Month">
                        <option selected>Filter by Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <select class="form-select me-2" id="downloadFormat" aria-label="Download Format">
                        <option selected>Download Format</option>
                        <option value="pdf">PDF</option>
                        <option value="csv">CSV</option>
                        <option value="excel">Excel</option>
                    </select>
                    <button class="btn btn-outline-light" id="downloadButton" type="button">Download</button>
                </form>
            </div>

            <h1 class="text-center mb-4">Grafik Jumlah Penduduk Indonesia per Provinsi Tahun 2024</h1>
            <div class="card shadow-sm">
                <div class="card-body">
                    <canvas id="pendudukChart" class="w-100" height="400"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 20225 Grafik Penduduk Indonesia. All Rights Reserved.</p>
        <p><a href="#">Khoerul Umam </a> | <a href="#">Tes TAPG</a></p>
    </footer>

    <!-- Button Toggle Sidebar -->
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

    <script>
        var ctx = document.getElementById('pendudukChart').getContext('2d');
        var pendudukChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: {!! json_encode($jumlah) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Function to toggle Sidebar visibility
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var content = document.getElementById('content');
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
        }

        // Download Function
        document.getElementById('downloadButton').addEventListener('click', function() {
            var selectedFormat = document.getElementById('downloadFormat').value;

            if (selectedFormat === 'pdf') {
                downloadPDF();
            } else if (selectedFormat === 'csv') {
                downloadCSV();
            } else if (selectedFormat === 'excel') {
                downloadExcel();
            } else {
                alert("Please select a valid download format.");
            }
        });

        // Download PDF
        function downloadPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            doc.text("Grafik Jumlah Penduduk Indonesia per Provinsi Tahun 2024", 10, 10);
            const chartImage = document.getElementById('pendudukChart').toDataURL("image/png");
            doc.addImage(chartImage, 'PNG', 10, 20, 180, 100);
            doc.save('grafik-penduduk.pdf');
        }

        // Download CSV
        function downloadCSV() {
            const chartData = pendudukChart.data.datasets[0].data;
            const chartLabels = pendudukChart.data.labels;
            const data = chartLabels.map((label, index) => ({
                Provinsi: label,
                Jumlah_Penduduk: chartData[index]
            }));
            const title = "Grafik Jumlah Penduduk Indonesia per Provinsi Tahun 2024\n\n";
            const csv = Papa.unparse(data);
            const blob = new Blob([title + csv], {
                type: 'text/csv'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'grafik-penduduk.csv';
            link.click();
        }

        // Download Excel
        function downloadExcel() {
            const chartData = pendudukChart.data.datasets[0].data;
            const chartLabels = pendudukChart.data.labels;
            const data = chartLabels.map((label, index) => ({
                Provinsi: label,
                Jumlah_Penduduk: chartData[index]
            }));
            const ws = XLSX.utils.json_to_sheet(data);
            const wb = XLSX.utils.book_new();
            const titleRow = [
                ["Grafik Jumlah Penduduk Indonesia per Provinsi Tahun 2024"]
            ];
            XLSX.utils.sheet_add_aoa(ws, titleRow, {
                origin: 'A1'
            });
            XLSX.utils.book_append_sheet(wb, ws, "Grafik Penduduk");
            XLSX.writeFile(wb, 'grafik-penduduk.xlsx');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
