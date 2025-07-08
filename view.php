<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Found Items</title>
    <link rel="stylesheet" href="CSS/view.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
</head>
<body>
    <h1>Found Items</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Location Found</th>
                <th>Date Found</th>
                <th>Description</th>
                <th>Status</th>
                <th>Claimed By</th>
                <th>Date Claimed</th>
            </tr>
        </thead>
        <tbody>
           
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                
            </tr>
           
        </tbody>
    </table>
    <p><a href="sgdashboard.html">Back to Dashboard</a></p>
    <p><a href="record.html">Record New Item</a></p>

    <script>
        // Fetch found items from the server
        fetch('record.html?action=view_found_items')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('tbody');
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.item_name}</td>
                        <td>${item.location_found}</td>
                        <td>${item.date_found}</td>
                        <td>${item.description}</td>
                        <td>${item.status}</td>
                        <td>${item.claimed_by || 'N/A'}</td>
                        <td>${item.date_claimed || 'N/A'}</td>
                    `;
                    tbody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching found items:', error));
    </script>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous"></script>
</div>
    
</body>
</html>