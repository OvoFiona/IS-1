<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Found Item - Security Guard Portal</title>
    <link rel="stylesheet" href="CSS/upload.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
</head>
<body>
    <div class="container">
        <h1>Upload Found Item</h1>
        <form id="foundItemForm">
            <div class="form-group">
                <label for="itemName" class="required">itemName</label>
                <input type="text" id="itemName" name="itemName" required>
            </div>
            
            <div class="form-group">
                <label for="Category" class="required">Category</label>
                <select id="cCategory" name="Category" required>
                    <option value="">Select a category</option>
                    <option value="electronics">Electronics</option>
                    <option value="documents">Documents</option>
                    <option value="clothing">Clothing</option>
                    <option value="accessories">Accessories</option>
                    <option value="valuables">Valuables</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="LocationFound" class="required">LocationFound</label>
                <input type="text" id="LocationFound" name="LocationFound" required>
            </div>
            
            <div class="form-group">
                <label for="DateFound" class="required">DateFound</label>
                <input type="datetime-local" id="DateFound" name="DateFound" required>
            </div>
            
            <div class="form-group">
                <label for="Description">Description</label>
                <textarea id="Description" name="Description"></textarea>
            </div>
            
            <div class="form-group">
                <label for="itemImage">itemImage</label>
                <input type="file" id="itemImage" name="itemImage" accept="image/*">
            </div>
            
            <div class="form-group">
                <label for="foundBy">Email</label>
                <input type="email" id="Email" name="Email">
            </div>
            
            <div class="form-group">
                <label for="storageLocation">StorageLocation</label>
                <input type="text" id="StorageLocation" name="StorageLocation">
            </div>
            
            <button type="submit">Submit Found Item</button>
        </form>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('imageUpload').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Form submission
         document.getElementById('foundItemForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Show loading state
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('spinner').style.display = 'inline-block';
            document.getElementById('submitText').textContent = 'Processing...';
            
            // Hide previous alerts
            document.getElementById('successAlert').style.display = 'none';
            document.getElementById('errorAlert').style.display = 'none';
            
            try {
                const formData = new FormData(this);
                
                const response = await fetch('api/submit_item.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    // Show success message
                    document.getElementById('successAlert').textContent = 
                        'Item successfully reported! Redirecting to search...';
                    document.getElementById('successAlert').style.display = 'block';
                    
                    // Reset form
                    this.reset();
                    document.getElementById('imagePreview').style.display = 'none';
                    
                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = 'search.php?newItem=' + encodeURIComponent(result.itemId);
                    }, 2000);
                } else {
                    throw new Error(result.message || 'Failed to submit item');
                }
            } catch (error) {
                console.error('Submission error:', error);
                document.getElementById('errorAlert').textContent = error.message;
                document.getElementById('errorAlert').style.display = 'block';
            } finally {
                // Reset button state
                document.getElementById('submitBtn').disabled = false;
                document.getElementById('spinner').style.display = 'none';
                document.getElementById('submitText').textContent = 'Submit Found Item';
            }
        });
        document.getElementById('foundItemForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Get form values
            const formData = new FormData();
            formData.append('itemName', document.getElementById('itemName').value);
            formData.append('category', document.getElementById('category').value);
            formData.append('locationFound', document.getElementById('locationFound').value);
            formData.append('dateFound', document.getElementById('dateFound').value);
            formData.append('timeFound', document.getElementById('timeFound').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('foundBy', document.getElementById('foundBy').value);
            formData.append('storageLocation', document.getElementById('storageLocation').value);
            
            // Append image if selected
            const imageInput = document.getElementById('imageUpload');
            if (imageInput.files[0]) {
                formData.append('image', imageInput.files[0]);
            }

            try {
                const response = await fetch('/api/found-items', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    alert('Item successfully reported!');
                    window.location.href = 'search.html'; // Redirect to search page
                } else {
                    const error = await response.json();
                    alert(`Error: ${error.message}`);
                }
            } catch (err) {
                console.error('Error:', err);
                alert('Failed to submit form. Please try again.');
            }

            


        });

    </script>
</body>
</html>