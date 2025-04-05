// Define the API URL for patient-related requests
const API_URL = 'http://localhost/medical/backend/api/patients.php'; // Update with your actual API URL

// Utility function to show alerts
function showAlert(message, type = 'success') {
    const alertBox = document.createElement('div');
    alertBox.classList.add('alert', `alert-${type}`);
    alertBox.textContent = message;
    document.body.appendChild(alertBox);
    
    // Automatically remove the alert after 3 seconds
    setTimeout(() => alertBox.remove(), 3000);
}

// Utility function for API requests (GET, POST, PUT, DELETE)
async function apiRequest(url, method, body = null) {
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: body ? JSON.stringify(body) : null
        });

        if (!response.ok) throw new Error('Network response was not ok');
        return await response.json();
    } catch (error) {
        console.error("API Error:", error);
        showAlert("Something went wrong. Please try again.", 'danger');
        throw error;
    }
}

/**
 * Fetch all patients and display them in the table
 */
async function fetchPatients() {
    try {
        const data = await apiRequest(API_URL, 'GET');
        displayPatients(data);
    } catch (error) {
        console.error('Error fetching patients:', error);
    }
}

/**
 * Display patients in the table
 * @param {Array} patients - Array of patient objects
 */
function displayPatients(patients) {
    const tbody = document.querySelector('#patients-table tbody');
    tbody.innerHTML = ''; // Clear existing rows

    patients.forEach(patient => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${patient.patient_id}</td>
            <td>${patient.first_name} ${patient.last_name}</td>
            <td>${patient.date_of_birth}</td>
            <td>${patient.gender}</td>
            <td>${patient.email}</td>
            <td>${patient.phone_number}</td>
            <td><span class="status ${patient.status}">${patient.status}</span></td>
            <td>
                <button class="edit-btn" data-id="${patient.patient_id}">Edit</button>
                <button class="delete-btn" data-id="${patient.patient_id}">Delete</button>
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
        button.addEventListener('click', () => editPatient(button.dataset.id));
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => deletePatient(button.dataset.id));
    });
}

/**
 * Add a new patient by submitting the form data via AJAX
 * @param {Event} event - The form submission event
 */
async function addPatient(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    const form = event.target;
    const patientData = new FormData(form);

    const data = {
        first_name: patientData.get('first_name'),
        last_name: patientData.get('last_name'),
        date_of_birth: patientData.get('dob'),
        gender: patientData.get('gender'),
        email: patientData.get('email'),
        phone_number: patientData.get('phone_number'),
        address: patientData.get('address'),
        insurance_provider: patientData.get('insurance_provider'),
        insurance_policy_number: patientData.get('insurance_policy_number'),
        primary_care_physician: patientData.get('primary_care_physician'),
        medical_history: patientData.get('medical_history'),
        allergies: patientData.get('allergies'),
        status: patientData.get('status'),
    };

    try {
        const response = await apiRequest(API_URL, 'POST', data);
        if (response.success) {
            showAlert('Patient added successfully');
            fetchPatients(); // Refresh the patient list
            form.reset(); // Reset the form
        } else {
            showAlert('Error adding patient', 'danger');
        }
    } catch (error) {
        console.error('Error adding patient:', error);
    }
}

/**
 * Edit an existing patient's details
 * @param {number} patientId - The patient ID
 */
async function editPatient(patientId) {
    try {
        const data = await apiRequest(`${API_URL}/${patientId}`, 'GET');
        // Pre-fill the form with the patient's current data (you can create a form for editing)
        const form = document.querySelector('#edit-patient-form');
        form.first_name.value = data.first_name;
        form.last_name.value = data.last_name;
        form.dob.value = data.date_of_birth;
        form.gender.value = data.gender;
        form.email.value = data.email;
        form.phone_number.value = data.phone_number;
        form.address.value = data.address;
        form.insurance_provider.value = data.insurance_provider;
        form.insurance_policy_number.value = data.insurance_policy_number;
        form.primary_care_physician.value = data.primary_care_physician;
        form.medical_history.value = data.medical_history;
        form.allergies.value = data.allergies;
        form.status.value = data.status;

        // Attach the patient ID to the form for later use
        form.dataset.patientId = patientId;
    } catch (error) {
        console.error('Error fetching patient data:', error);
    }
}

/**
 * Update a patient's details via AJAX
 * @param {Event} event - The form submission event
 */
async function updatePatient(event) {
    event.preventDefault();

    const form = event.target;
    const patientId = form.dataset.patientId;

    const patientData = new FormData(form);
    const data = {
        first_name: patientData.get('first_name'),
        last_name: patientData.get('last_name'),
        date_of_birth: patientData.get('dob'),
        gender: patientData.get('gender'),
        email: patientData.get('email'),
        phone_number: patientData.get('phone_number'),
        address: patientData.get('address'),
        insurance_provider: patientData.get('insurance_provider'),
        insurance_policy_number: patientData.get('insurance_policy_number'),
        primary_care_physician: patientData.get('primary_care_physician'),
        medical_history: patientData.get('medical_history'),
        allergies: patientData.get('allergies'),
        status: patientData.get('status'),
    };

    try {
        const response = await apiRequest(`${API_URL}/${patientId}`, 'PUT', data);
        if (response.success) {
            showAlert('Patient updated successfully');
            fetchPatients(); // Refresh the patient list
        } else {
            showAlert('Error updating patient', 'danger');
        }
    } catch (error) {
        console.error('Error updating patient:', error);
    }
}

/**
 * Delete a patient via AJAX
 * @param {number} patientId - The patient ID
 */
async function deletePatient(patientId) {
    const confirmDelete = confirm('Are you sure you want to delete this patient?');
    if (confirmDelete) {
        try {
            const response = await apiRequest(`${API_URL}/${patientId}`, 'DELETE');
            if (response.success) {
                showAlert('Patient deleted successfully');
                fetchPatients(); // Refresh the patient list
            } else {
                showAlert('Error deleting patient', 'danger');
            }
        } catch (error) {
            console.error('Error deleting patient:', error);
        }
    }
}

// Event listener for the add patient form
document.querySelector('#add-patient-form').addEventListener('submit', addPatient);

// Event listener for the update patient form (if applicable)
document.querySelector('#edit-patient-form').addEventListener('submit', updatePatient);

// Fetch and display patients when the page loads
document.addEventListener('DOMContentLoaded', fetchPatients);
