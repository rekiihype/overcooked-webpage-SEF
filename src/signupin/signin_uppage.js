// Add an event listener to the login form when it is submitted
document.getElementById('loginForm').addEventListener('submit', function (event) {
    // Prevent the form from submitting the traditional way (which refreshes the page)
    event.preventDefault();

    // Get the values entered in the email and password fields
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Check if both email and password fields are filled out
    if (email && password) {
        // Send the data to the server using the Fetch API
        fetch('login.php', {
            method: 'POST', // Use the POST method to send data
            headers: {
                'Content-Type': 'application/json' // Specify that we're sending JSON data
            },
            body: JSON.stringify({ email: email, password: password }) // Convert the data to JSON format
        })
            .then(response => response.json()) // Parse the server's response as JSON
            .then(data => {
                // Check if the login was successful based on the server's response
                if (data.success) {
                    // Redirect the user to the dashboard page
                    window.location.href = '../dashboard/dashboard.html';
                } else {
                    // Show an error message if the login failed
                    alert('Login failed: ' + data.message);
                }
            })
            .catch(error => {
                // Handle any errors that occur during the fetch process
                console.error('Error:', error);
            });
    } else {
        // Show an alert if either the email or password field is empty
        alert('Please fill in all fields');
    }
});

// Add an event listener to the signup form when it is submitted
document.getElementById('signupForm').addEventListener('submit', function (event) {
    // Prevent the form from submitting the traditional way (which refreshes the page)
    event.preventDefault();

    // Get the values entered in the username, email, and password fields
    const username = document.getElementById('username').value;
    const email = document.getElementById('signupEmail').value;
    const password = document.getElementById('signupPassword').value;
    const passwordreentry = document.getElementById('signupReenterPassword').value;

    // Check if all fields are filled out
    if (username && email && password && passwordreentry) {
        // Send the data to the server using the Fetch API
        fetch('signup.php', {
            method: 'POST', // Use the POST method to send data
            headers: {
                'Content-Type': 'application/json' // Specify that we're sending JSON data
            },
            body: JSON.stringify({ username: username, email: email, password: password, reentrypassword: passwordreentry }) // Convert the data to JSON format
        })
            .then(response => response.json()) // Parse the server's response as JSON
            .then(data => {
                // Check if the signup was successful based on the server's response
                if (data.success) {
                    // Redirect the user to the login page or dashboard
                    window.location.href = '../dashboard/dashboard.html';
                } else {
                    // Show an error message if the signup failed
                    alert('Signup failed: ' + data.message);
                }
            })
            .catch(error => {
                // Handle any errors that occur during the fetch process
                console.error('Error:', error);
            });
    } else {
        // Show an alert if any field is empty
        alert('Please fill in all fields');
    }
});

// Toggle between Login and Sign Up forms
document.addEventListener("DOMContentLoaded", function () {
    const showLoginButton = document.getElementById("showLogin");
    const showSignupButton = document.getElementById("showSignup");
    const loginForm = document.getElementById("loginForm");
    const signupForm = document.getElementById("signupForm");

    // Show Login Form and hide Sign Up Form
    showLoginButton.addEventListener("click", function (e) {
        e.preventDefault(); // Prevent default button behavior
        loginForm.classList.add("active"); // Show Login Form
        signupForm.classList.remove("active"); // Hide Sign Up Form
        showLoginButton.classList.add("active"); // Highlight Login Button
        showSignupButton.classList.remove("active"); // Unhighlight Sign Up Button
    });

    // Show Sign Up Form and hide Login Form
    showSignupButton.addEventListener("click", function (e) {
        e.preventDefault(); // Prevent default button behavior
        signupForm.classList.add("active"); // Show Sign Up Form
        loginForm.classList.remove("active"); // Hide Login Form
        showSignupButton.classList.add("active"); // Highlight Sign Up Button
        showLoginButton.classList.remove("active"); // Unhighlight Login Button
    });

    // Initialize the page with the Login Form visible
    loginForm.classList.add("active"); // Ensure Login Form is visible by default
    showLoginButton.classList.add("active"); // Ensure Login Button is highlighted by default
});

// Toggle Password Visibility for Login Form
document.addEventListener("DOMContentLoaded", function () {
    const toggleLoginPassword = document.getElementById("togglePassword");
    const loginPasswordField = document.getElementById("password");

    if (toggleLoginPassword && loginPasswordField) {
        toggleLoginPassword.addEventListener("click", function () {
            if (loginPasswordField.type === "password") {
                loginPasswordField.type = "text"; // Show password
                toggleLoginPassword.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Change button text/icon
            } else {
                loginPasswordField.type = "password"; // Hide password
                toggleLoginPassword.innerHTML = '<i class="fas fa-eye"></i>'; // Change button text/icon
            }
        });
    }

    // Toggle Password Visibility for Sign Up Form
    const toggleSignupPassword = document.getElementById("toggleSignupPassword");
    const signupPasswordField = document.getElementById("signupPassword");
    const toggleSignupReenterPassword = document.getElementById("toggleSignupReenterPassword");
    const signupReenterPasswordField = document.getElementById("signupReenterPassword");

    if (toggleSignupPassword && signupPasswordField) {
        toggleSignupPassword.addEventListener("click", function () {
            if (signupPasswordField.type === "password") {
                signupPasswordField.type = "text"; // Show password
                toggleSignupPassword.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Change button text/icon
            } else {
                signupPasswordField.type = "password"; // Hide password
                toggleSignupPassword.innerHTML = '<i class="fas fa-eye"></i>'; // Change button text/icon
            }
        });
    }

    if (toggleSignupReenterPassword && signupReenterPasswordField) {
        toggleSignupReenterPassword.addEventListener("click", function () {
            if (signupReenterPasswordField.type === "password") {
                signupReenterPasswordField.type = "text"; // Show password
                toggleSignupReenterPassword.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Change button text/icon
            } else {
                signupReenterPasswordField.type = "password"; // Hide password
                toggleSignupReenterPassword.innerHTML = '<i class="fas fa-eye"></i>'; // Change button text/icon
            }
        });
    }
});

// Validation for testing purposes
document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('#loginForm form');
    const emailInput = document.querySelector('#email');
    const passwordInput = document.querySelector('#password');

    loginForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting the traditional way

        const email = emailInput.value;
        const password = passwordInput.value;

        // Simple validation (TEST DATA)
        if (email === "registered@icloud.com" && password === "abc123") {
            // Redirect to the dashboard page
            window.location.href = '../dashboard/dashboard.html';
        } else {
            alert('Invalid email or password. Please try again.');
        }
    });
});