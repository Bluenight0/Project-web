<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

    <?php include 'layout/header_admin.html'; ?>

    <main class="p-6">
        <h1 class="text-2xl font-semibold mb-4">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Card Buku -->
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-medium mb-2">Total Buku</h2>
                <p id="total-books" class="text-3xl font-bold text-blue-600">0</p>
            </div>

            <!-- Card Event -->
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-medium mb-2">Total Event</h2>
                <p id="total-events" class="text-3xl font-bold text-green-600">0</p>
            </div>

            <!-- Card Status -->
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-medium mb-2">Status Peminjaman</h2>
                <p id="total-status" class="text-3xl font-bold text-purple-600">0</p>
            </div>
        </div>

    </main>

    <script>
        async function loadDashboard() {
            try {
                const response = await fetch("api/dashboard-data.php");
                const data = await response.json();

                document.getElementById("total-books").textContent = data.total_books ?? 0;
                document.getElementById("total-events").textContent = data.total_events ?? 0;
                document.getElementById("total-status").textContent = data.total_status ?? 0;
            } catch (error) {
                console.error("Error loading dashboard:", error);
            }
        }

        loadDashboard();
    </script>

</body>
</html>
