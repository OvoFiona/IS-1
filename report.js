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
        
        
        
    