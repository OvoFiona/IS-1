<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost and Found Search</title>
    <link rel="stylesheet" href="CSS/search.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
</head>
<body>
    <div class="container">
        <header>
            <h1>Lost and Found Dashboard</h1>
            <p>Search for your lost items on campus</p>
        </header>
        
        <section class="search-section">
            <h2>Search Filters</h2>
            <form id="searchForm" class="search-form">
                <input type="text" id="itemName" placeholder="Item name">
                <input type="text" id="itemDescription" placeholder="Description">
                <input type="text" id="lostLocation" placeholder="Where lost">
                <input type="date" id="lostDate" placeholder="When lost">
                <button type="submit">Search</button>
            </form>
        </section>
        
        <section class="dashboard" id="itemsDashboard">
            <!-- Items will be dynamically inserted here -->
        </section>
    </div>

    <script>
        // Sample data - in a real app this would come from a database
        const lostItems = [
            {
                id: 1,
                name: "Student ID Card",
                description: "Strathmore university ID card with photo",
                location: "Library",
                date: "2025-05-15",
                image: "images/Student ID Card.png"
            },
            {
                id: 2,
                name: "Wireless Headphones",
                description: "Black Sony wireless headphones in case",
                location: "Cafeteria",
                date: "2025-05-18",
                image: "images/Wireless Headphones.jpg"
            },
            {
                id: 3,
                name: "Notebook",
                description: "Pink spiral notebook with physics notes",
                location: "LT3",
                date: "2025-05-20",
                image: "images/notebook.jpg"
            },
            {
                id: 4,
                name: "Water Bottle",
                description: "Stainless steel water bottle with university logo",
                location: "Sports Complex",
                date: "2025-05-22",
                image: "images/water bottle.jpg"
            },
            {
                id: 5,
                name: "Calculator",
                description: "TI-84 graphing calculator",
                location: "STMB F2-01",
                date: "2023-05-25",
                image: "images/calculator.jpg"
            },
            {
                id: 6,
                name: "Umbrella",
                description: "Black compact umbrella",
                location: "Bus",
                date: "2023-05-28",
                image: "images/umbrella.jpg"
            }
        ];

        // Display all items initially
        displayItems(lostItems);

        // Search form submission
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get search values
            const nameQuery = document.getElementById('itemName').value.toLowerCase();
            const descQuery = document.getElementById('itemDescription').value.toLowerCase();
            const locQuery = document.getElementById('lostLocation').value.toLowerCase();
            const dateQuery = document.getElementById('lostDate').value;
            
            // Filter items based on search criteria
            const filteredItems = lostItems.filter(item => {
                const matchesName = item.name.toLowerCase().includes(nameQuery);
                const matchesDesc = item.description.toLowerCase().includes(descQuery);
                const matchesLoc = item.location.toLowerCase().includes(locQuery);
                const matchesDate = dateQuery ? item.date === dateQuery : true;
                
                return matchesName && matchesDesc && matchesLoc && matchesDate;
            });
            
            // Display filtered results
            displayItems(filteredItems);
        });

        // Function to display items in the dashboard
        function displayItems(items) {
            const dashboard = document.getElementById('itemsDashboard');
            dashboard.innerHTML = '';
            
            if (items.length === 0) {
                dashboard.innerHTML = '<div class="no-results">No items found matching your search criteria.</div>';
                return;
            }
            
            items.forEach(item => {
                const itemCard = document.createElement('div');
                itemCard.className = 'item-card';
                itemCard.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="item-image">
                    <div class="item-details">
                        <div class="item-name">${item.name}</div>
                        <div class="item-description">${item.description}</div>
                        <div class="item-meta">
                            <span>Lost at: ${item.location}</span>
                            <span>Date: ${formatDate(item.date)}</span>
                        </div>
                    </div>
                `;
                dashboard.appendChild(itemCard);
            });
        }

        // Helper function to format date
        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString(undefined, options);
        }
    </script>
</body>
</html>