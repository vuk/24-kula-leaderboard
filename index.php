<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Leaderboard</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: white;
        }
        table, th, td {
            border: 1px solid white;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
        }
        td {
            background-color: #444;
        }
        .message {
            font-size: 40px; /* Bigger font size */
            text-align: center;
            padding: 50px; /* More padding */
            background-color: #ff4444; /* Striking red background */
            color: white; /* White text */
            font-weight: bold; /* Bold text */
            border: 3px solid white; /* Thick white border */
            margin-top: 20px;
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.7); /* Add some glow effect */
        }
    </style>
</head>
<body>
    <h1>Live Leaderboard</h1>
    <div id="content">
        <table id="leaderboard">
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Racer Number</th>
                    <th>Racer Name</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be dynamically inserted here -->
            </tbody>
        </table>
        <div id="message" class="message" style="display: none;"></div>
    </div>

    <script>
        async function fetchData() {
            const url = new URL(document.baseURI + '/api-proxy.php');
            const headers = new Headers();
            headers.set('Authorization', 'Basic ' + btoa('c25ea964b4b92d9aa10f:'));

            try {
                const response = await fetch(url, { headers: headers });
                const data = await response.json();
                
                if (data.error) {
                    showMessage(data.error);
                } else {
                    updateTable(data.racers);
                }
            } catch (error) {
                console.error('Error fetching leaderboard data:', error);
                showMessage('Error fetching leaderboard data.');
            }
        }

        function updateTable(results) {
            const tbody = document.querySelector('#leaderboard tbody');
            const messageDiv = document.getElementById('message');
            const table = document.getElementById('leaderboard');

            // Hide the message and show the table
            messageDiv.style.display = 'none';
            table.style.display = 'table';

            tbody.innerHTML = ''; // Clear the existing table

            let i = 0;

            results.forEach(result => {
                if (i < 10) {
                    const row = document.createElement('tr');

                    const positionCell = document.createElement('td');
                    positionCell.textContent = result.position_in_run;
                    row.appendChild(positionCell);

                    const numberCell = document.createElement('td');
                    numberCell.textContent = result.racer_number;
                    row.appendChild(numberCell);

                    const nameCell = document.createElement('td');
                    nameCell.textContent = result.racer_name;
                    row.appendChild(nameCell);

                    tbody.appendChild(row);
                    i++;
                }
            });
        }

        function showMessage(message) {
            const messageDiv = document.getElementById('message');
            const table = document.getElementById('leaderboard');

            // Hide the table and show the message
            table.style.display = 'none';
            messageDiv.style.display = 'block';
            messageDiv.textContent = message;
        }

        // Fetch data every 15 seconds
        setInterval(fetchData, 15000);

        // Fetch data immediately when the page loads
        fetchData();
    </script>
</body>
</html>
