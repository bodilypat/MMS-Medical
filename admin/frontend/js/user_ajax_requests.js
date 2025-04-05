const API_URL = 'http://localhost/medical/backend/api/users.php'; // Adjust URL to your backend

// Fetch all user records
async function fetchUsers() {
    try {
        const response = await fetch(API_URL);
        const users = await response.json();
        console.log('All Users:', users);
        displayUsers(users); // Function to display users in a table
    } catch (error) {
        console.error('Error fetching user records:', error);
    }
}

// Create a new user record
async function createUser(data) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Create User Response:', result);
        if (result.success) {
            alert('User record created successfully');
            fetchUsers(); // Reload users after creation
        } else {
            alert('Error creating user record');
        }
    } catch (error) {
        console.error('Error creating user record:', error);
    }
}

// Update an existing user record
async function updateUser(id, data) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Update User Response:', result);
        if (result.success) {
            alert('User record updated successfully');
            fetchUsers(); // Reload users after update
        } else {
            alert('Error updating user record');
        }
    } catch (error) {
        console.error('Error updating user record:', error);
    }
}

// Delete a user record
async function deleteUser(id) {
    const confirmDelete = confirm('Are you sure you want to delete this user record?');
    if (confirmDelete) {
        try {
            const response = await fetch(`${API_URL}?id=${id}`, {
                method: 'DELETE',
            });

            const result = await response.json();
            console.log('Delete User Response:', result);
            if (result.success) {
                alert('User record deleted successfully');
                fetchUsers(); // Reload users after deletion
            } else {
                alert('Error deleting user record');
            }
        } catch (error) {
            console.error('Error deleting user record:', error);
        }
    }
}

// Display user records in a table format
function displayUsers(users) {
    const tableBody = document.querySelector('#user-table tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    users.forEach(user => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${user.id}</td>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td>${user.role}</td>
            <td>${user.created_at}</td>
            <td>${user.updated_at}</td>
            <td>
                <button onclick="editUser(${user.id})">Edit</button>
                <button onclick="deleteUser(${user.id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Edit a user record (this function will pre-fill a form with existing user details)
async function editUser(id) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`);
        const user = await response.json();
        if (user) {
            // Pre-fill the form with user details (assuming you have a form with id `edit-user-form`)
            document.querySelector('#edit-user-id').value = user.id;
            document.querySelector('#edit-username').value = user.username;
            document.querySelector('#edit-email').value = user.email;
            document.querySelector('#edit-role').value = user.role;
        } else {
            alert('User record not found');
        }
    } catch (error) {
        console.error('Error editing user record:', error);
    }
}

// Form submission for updating a user record
document.querySelector('#edit-user-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;

    const userData = {
        username: form.querySelector('#edit-username').value,
        email: form.querySelector('#edit-email').value,
        password: form.querySelector('#edit-password').value,  // Optional: password field if needed
        role: form.querySelector('#edit-role').value,
    };

    const userId = form.querySelector('#edit-user-id').value;

    updateUser(userId, userData); // Update the user record
});

// Fetch and display all user records on page load
document.addEventListener('DOMContentLoaded', fetchUsers);