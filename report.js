        // Image upload functionality
        const imageUploadArea = document.getElementById('imageUploadArea');
        const fileInput = document.getElementById('itemImage');
        const imagePreview = document.getElementById('imagePreview');
        
        // Click to select file
        imageUploadArea.addEventListener('click', () => {
            fileInput.click();
        });
        
        // Drag and drop functionality
        imageUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            imageUploadArea.style.borderColor = 'var(--strath-blue)';
            imageUploadArea.style.backgroundColor = 'rgba(0, 51, 102, 0.1)';
        });
        
        imageUploadArea.addEventListener('dragleave', () => {
            imageUploadArea.style.borderColor = '#ddd';
            imageUploadArea.style.backgroundColor = 'transparent';
        });
        
        imageUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            imageUploadArea.style.borderColor = '#ddd';
            imageUploadArea.style.backgroundColor = 'transparent';
            
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                previewImage(e.dataTransfer.files[0]);
            }
        });
        
        // File selection handler
        fileInput.addEventListener('change', (e) => {
            if (fileInput.files.length) {
                previewImage(fileInput.files[0]);
            }
        });
        
        // Preview the selected image
        function previewImage(file) {
            const reader = new FileReader();
            
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            
            reader.readAsDataURL(file);
        }
        
        document.getElementById('lostItemForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get DOM elements
    const reportButton = document.getElementById('reportButton');
    const statusElement = document.getElementById('statusMessage');
    const messageText = document.getElementById('messageText');

    // Check if elements exist
    if (!reportButton || !statusElement || !messageText) {
        console.error('Required elements are missing!');
        return; // Exit if elements are not found
    }

    // Disable button during submission
    reportButton.disabled = true;
    reportButton.textContent = 'Reporting...';

    // Hide previous messages and reset classes
    statusElement.style.display = 'none';
    statusElement.className = 'status-message';

    // Simulate form submission (replace with actual fetch/AJAX call)
    setTimeout(() => {
        try {
            // Your form submission logic here (e.g., fetch API)
            // Simulating a successful API call
            // In a real application, you would send the form data to your server
            // and handle the response accordingly.
            // Example:
             const formData = new FormData(this);
             fetch('/api/studentreport.php', {
                 method: 'POST',
                 body: formData
             })
             .then(response => response.json())
             .then(data => {
                 if (data.success) {
                     statusElement.textContent = 'Your lost item has been reported successfully! Security has been notified.';
                     statusElement.classList.add('success'); // Add success styling
                     statusElement.style.display = 'block';
                 } else {
                     throw new Error(data.message || 'Failed to report lost item');
                }
             })
                statusElement.classList.add('success'); // Add success styling

            // For now, simulate success after 2 seconds
            statusElement.textContent = 'Your lost item has been reported successfully! Security has been notified.';
            statusElement.classList.add('success'); // Add success styling
            statusElement.style.display = 'block';

            // Re-enable button after submission
            reportButton.disabled = false;
            reportButton.textContent = 'Report Lost';
        } catch (error) {
            // Handle errors
            statusElement.textContent = 'Error: ' + error.message;
            statusElement.classList.add('error'); // Add error styling
            statusElement.style.display = 'block';

            // Re-enable button on error
            reportButton.disabled = false;
            reportButton.textContent = 'Try Again';
        }
    }, 2000); // Simulate network delay
            
            // Validate date
            const today = new Date();
            const lostDate = new Date(document.getElementById('lostDate').value);
            
            if (lostDate > today) {
                messageText.textContent = 'Error: Date cannot be in the future';
                statusElement.classList.add('error');
                statusElement.style.display = 'block';
                reportButton.disabled = false;
                reportButton.textContent = 'Report Lost Item';
                return;
            }
            
            // Simulate API call (replace with actual fetch to your backend)
            setTimeout(() => {
                // Show success message
                messageText.textContent = 'Your lost item has been reported successfully! Security has been notified.';
                statusElement.classList.add('success');
                statusElement.style.display = 'block';
                
                // Reset form
                this.reset();
                imagePreview.style.display = 'none';
                
                // Reset button
                reportButton.disabled = false;
                reportButton.textContent = 'Report Lost Item';
                
                // Hide message after 5 seconds
                setTimeout(() => {
                    statusElement.style.display = 'none';
                }, 5000);
            });
        });

