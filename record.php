<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Found Item</title>
   <link rel="stylesheet" href="CSS/record.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
   
</head>
<body>
    <h1>Record Found Item</h1>
    <form action="record" method="POST">
        <label for="item_name">Item Name:</label>
        <input type="text" id="item_name" name="item_name" required>
        
        <label for="location_found">Location Found:</label>
        <input type="text" id="location_found" name="location_found" required>
        
        <label for="date_found">Date Found:</label>
        <input type="datetime-local" id="date_found" name="date_found" required>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4"></textarea>

     
        <label for="contact_info">Student Information:</label>
        <input type="text" id="Student_info" name="Student_info" required placeholder="email">

        <label for="date_found">Date claimed:(Optional)</label>
        <input type="datetime-local" id="date_claimed" name="date_claimed" required>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="Unclaimed">Unclaimed</option>
            <option value="Claimed">Claimed</option>    
        </select>

        <button type="submit">Submit</button>
        
    </form>
    <p><a href="view.php">View All Items</a></p>

   <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const itemName = document.getElementById('item_name').value;
            const locationFound = document.getElementById('location_found').value;
            const dateFound = document.getElementById('date_found').value;
            const description = document.getElementById('description').value;
            const studentInfo = document.getElementById('Student_info').value;
            const dateClaimed = document.getElementById('date_claimed').value;
            const status = document.getElementById('status').value;

            if (!itemName || !locationFound || !dateFound || !studentInfo || !status) {
                alert("Please fill in all required fields.");
                return;
            }

            this.submit();
        });
        
    </script>
</form>
</body>
</html>