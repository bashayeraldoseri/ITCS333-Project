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


const passwordField = document.getElementById('verpassword');
const privacySettings = document.getElementById('privacySettings');
const verifyPasswordBtn = document.getElementById('verifyPasswordBtn');

verifyPasswordBtn.addEventListener('click', function() {
    const enteredPassword = passwordField.value.trim();
    console.log (passwordField);


    if (enteredPassword !== '') {
        // AJAX request to verify the password
        fetch('verify_password.php', {
            method: 'POST',
            body: JSON.stringify({ password: enteredPassword }),
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // If password matches, show privacy settings
                privacySettings.style.display = 'block';
            } else {
                console.log("Passwords don't match")
                // If password doesn't match, hide privacy settings
                privacySettings.style.display = 'none';
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            privacySettings.style.display = 'none';
        });
    } else {
        privacySettings.style.display = 'none';
    }
});
