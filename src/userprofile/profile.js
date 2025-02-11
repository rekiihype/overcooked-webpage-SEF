const editButton = document.getElementById('edit-button');
const profileForm = document.getElementById('profile-form');
const profileContainer = document.querySelector('.profile-container');
const imageUpload = document.getElementById('image-upload');
const passwordInput = document.getElementById('password');
const togglePassword = document.getElementById('togglePassword');

togglePassword.addEventListener('click', function () {
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;
    this.classList.toggle('visible');
});

editButton.addEventListener('click', function () {
    const isEditing = profileContainer.classList.toggle('editing');

    const formGroups = profileForm.querySelectorAll('input, select');

    formGroups.forEach(element => {
        if (element.type !== "password") {
            element.readOnly = !isEditing;
        }
        element.disabled = !isEditing;
    });

    if (isEditing) {
        editButton.textContent = 'Save';
        editButton.classList.add('save');
    } else {
        if (saveProfile()) {
            formGroups.forEach(element => {
                element.readOnly = true;
                element.disabled = true;
            });
            editButton.textContent = 'Edit';
            editButton.classList.remove('save');
        } else {
            // If saveProfile() returns false, re-enable the form fields
            formGroups.forEach(element => {
                if (element.type !== "password") {
                    element.readOnly = false;
                }
                element.disabled = false;
            });
            profileContainer.classList.add('editing');
        }
    }
});

function saveProfile() {
    const formData = new FormData(profileForm);
    
    // Basic validation
    const requiredFields = profileForm.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('error'); // Add an error class to highlight the field
        } else {
            field.classList.remove('error');
        }
    });

    if (!isValid) {
        alert("Please fill out all required fields.");
        return false;
    }

    if (imageUpload.files[0]) {
        formData.append('profile-picture', imageUpload.files[0]);
    }

    fetch('update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Server error: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            throw new Error(data.error);
        }
        alert("Profile updated successfully!");
        profileContainer.classList.remove('editing');
    })
    .catch(error => {
        console.error('Error:', error);
        alert(`There was an error updating your profile: ${error.message}`);
    });

    return true;
}

const profilePic = document.getElementById('profile-picture');

imageUpload.addEventListener('change', function (event) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            profilePic.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

const countrySelect = document.getElementById('country');
const countries = ["Malaysia", "Singapore", "Indonesia", "Thailand", "Vietnam", "United States",
                    "Canada", "United Kingdom", "Germany", "France", "Norway", "Australia", "New Zealand"];

countries.forEach(country => {
    const option = document.createElement('option');
    option.value = country;
    option.text = country;
    countrySelect.appendChild(option);
});