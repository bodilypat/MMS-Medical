// Define the API URL for doctor-related requests
const API_URL = 'http://localhost/medical/backend/api/doctors.php';  // Replace with your actual API URL

/**
 * Fetch all doctors and display them in the table
 */
async function fetchDoctors() {
    try {
        const response = await fetch(API_URL);
        const doctors = await response.json();
        displayDoctors(doctors);
    } catch (error) {
        console.error('Error fetching doctors:', error);
    }
}

/**
 * Display doctors in the table
 * @param {Array} doctors - Array of doctor objects
 */
function displayDoctors(doctors) {
    const tbody = document.querySelector('#doctors-table tbody');
    tbody.innerHTML = ''; // Clear existing rows

    doctors.forEach(doctor => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${doctor.doctor_id}</td>
            <td>${doctor.first_name} ${doctor.last_name}</td>
            <td>${doctor.specialization}</td>
            <td>${doctor.email}</td>
            <td>${doctor.phone_number}</td>
            <td>${doctor.department}</td>
            <td><span class="status ${doctor.status}">${doctor.status}</span></td>
            <td>
                <button class="edit-btn" data-id="${doctor.doctor_id}">Edit</button>
                <button class="delete-btn" data-id="${doctor.doctor_id}">Delete</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Add event listeners to dynamically generated buttons
    addRowEventListeners();
}

/**
 * Add event listeners for the Edit and Delete buttons in the table rows
 */
function addRowEventListeners() {
    const editButtons = document.querySelectorAll('.edit-btn');
    const deleteButtons = document.querySelectorAll('.delete-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', () => editDoctor(button.dataset.id));
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => deleteDoctor(button.dataset.id));
    });
}

/**
 * Add a new doctor by submitting the form data via AJAX
 * @param {Event} event - The form submission event
 */
async function addDoctor(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    const form = event.target;
    const doctorData = new FormData(form);

    const data = {
        first_name: doctorData.get('first_name'),
        last_name: doctorData.get('last_name'),
        specialization: doctorData.get('specialization'),
        email: doctorData.get('email'),
        phone_number: doctorData.get('phone_number'),
        department: doctorData.get('department'),
        birthdate: doctorData.get('birthdate'),
        address: doctorData.get('address'),
        status: doctorData.get('status'),
        notes: doctorData.get('notes')
    };

    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if (result.success) {
            alert('Doctor added successfully');
            fetchDoctors(); // Refresh the doctor list
            form.reset(); // Reset the form
        } else {
            alert('Error adding doctor');
        }
    } catch (error) {
        console.error('Error adding doctor:', error);
    }
}

/**
 * Edit an existing doctor's details
 * @param {number} doctorId - The doctor ID
 */
async function editDoctor(doctorId) {
    try {
        const response = await fetch(`${API_URL}/${doctorId}`);
        const data = await response.json();

        // Pre-fill the form with the doctor's current data
        const form = document.querySelector('#edit-doctor-form');
        form.first_name.value = data.first_name;
        form.last_name.value = data.last_name;
        form.specialization.value = data.specialization;
        form.email.value = data.email;
        form.phone_number.value = data.phone_number;
        form.department.value = data.department;
        form.birthdate.value = data.birthdate;
        form.address.value = data.address;
        form.status.value = data.status;
        form.notes.value = data.notes;

        // Attach the doctor ID to the form for later use
        form.dataset.doctorId = doctorId;
    } catch (error) {
        console.error('Error fetching doctor data:', error);
    }
}

/**
 * Update a doctor's details via AJAX
 * @param {Event} event - The form submission event
 */
async function updateDoctor(event) {
    event.preventDefault();

    const form = event.target;
    const doctorId = form.dataset.doctorId;

    const doctorData = new FormData(form);
    const data = {
        first_name: doctorData.get('first_name'),
        last_name: doctorData.get('last_name'),
        specialization: doctorData.get('specialization'),
        email: doctorData.get('email'),
        phone_number: doctorData.get('phone_number'),
        department: doctorData.get('department'),
        birthdate: doctorData.get('birthdate'),
        address: doctorData.get('address'),
        status: doctorData.get('status'),
        notes: doctorData.get('notes')
    };

    try {
        const response = await fetch(`${API_URL}/${doctorId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if (result.success) {
            alert('Doctor updated successfully');
            fetchDoctors(); // Refresh the doctor list
        } else {
            alert('Error updating doctor');
        }
    } catch (error) {
        console.error('Error updating doctor:', error);
    }
}

/**
 * Delete a doctor via AJAX
 * @param {number} doctorId - The doctor ID
 */
async function deleteDoctor(doctorId) {
    const confirmDelete = confirm('Are you sure you want to delete this doctor?');
    if (confirmDelete) {
        try {
            const response = await fetch(`${API_URL}/${doctorId}`, {
                method: 'DELETE'
            });

            const result = await response.json();
            if (result.success) {
                alert('Doctor deleted successfully');
                fetchDoctors(); // Refresh the doctor list
            } else {
                alert('Error deleting doctor');
            }
        } catch (error) {
            console.error('Error deleting doctor:', error);
        }
    }
}

// Event listener for the add doctor form
document.querySelector('#add-doctor-form').addEventListener('submit', addDoctor);

// Event listener for the update doctor form (if applicable)
document.querySelector('#edit-doctor-form').addEventListener('submit', updateDoctor);

// Fetch and display doctors when the page loads
document.addEventListener('DOMContentLoaded', fetchDoctors);
