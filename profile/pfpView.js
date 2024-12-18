function previewImage(event) {
    const fileInput = event.target;
    const preview = document.getElementById('imagePreview');

    // Check if a file is selected
    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        // Load the file into the preview
        reader.onload = function (e) {
            preview.src = e.target.result; // Set the <img> tag's src to the file data
        };

        reader.readAsDataURL(fileInput.files[0]);
    }
}