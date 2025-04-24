const API_URL = 'api/common/patients.php'; // Adjust URL to your backend

// Fetch all patient records
async function fetchPatients() {
    try {
        const response = await fetch(API_URL);
        const patients = await response.json();
        console.log('All Patients:', patients);
        displayPatients(patients); // Function to display patients in a table
    } catch (error) {
        console.error('Error fetching patient records:', error);
    }
}

// Create a new patient record
async function createPatient(data) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Create Patient Response:', result);
        if (result.success) {
            alert('Patient record created successfully');
            fetchPatients(); // Reload patients after creation
        } else {
            alert('Error creating patient record');
        }
    } catch (error) {
        console.error('Error creating patient record:', error);
    }
}

// Update an existing patient record
async function updatePatient(id, data) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Update Patient Response:', result);
        if (result.success) {
            alert('Patient record updated successfully');
            fetchPatients(); // Reload patients after update
        } else {
            alert('Error updating patient record');
        }
    } catch (error) {
        console.error('Error updating patient record:', error);
    }
}

// Delete a patient record
async function deletePatient(id) {
    const confirmDelete = confirm('Are you sure you want to delete this patient record?');
    if (confirmDelete) {
        try {
            const response = await fetch(`${API_URL}?id=${id}`, {
                method: 'DELETE',
            });

            const result = await response.json();
            console.log('Delete Patient Response:', result);
            if (result.success) {
                alert('Patient record deleted successfully');
                fetchPatients(); // Reload patients after deletion
            } else {
                alert('Error deleting patient record');
            }
        } catch (error) {
            console.error('Error deleting patient record:', error);
        }
    }
}

// Display patient records in a table format
function displayPatients(patients) {
    const tableBody = document.querySelector('#patient-table tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    patients.forEach(patient => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${patient.patient_id}</td>
            <td>${patient.first_name}</td>
            <td>${patient.last_name}</td>
            <td>${patient.date_of_birth}</td>
            <td>${patient.gender}</td>
            <td>${patient.email}</td>
            <td>${patient.phone_number}</td>
            <td>${patient.address}</td>
            <td>${patient.insurance_provider}</td>
            <td>${patient.insurance_policy_number}</td>
            <td>${patient.primary_care_physician}</td>
            <td>${patient.medical_history}</td>
            <td>${patient.allergies}</td>
            <td>${patient.status}</td>
            <td>
                <button onclick="editPatient(${patient.patient_id})">Edit</button>
                <button onclick="deletePatient(${patient.patient_id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Edit a patient record (this function will pre-fill a form with existing patient details)
async function editPatient(id) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`);
        const patient = await response.json();
        if (patient) {
            // Pre-fill the form with patient details (assuming you have a form with id `edit-patient-form`)
            document.querySelector('#edit-patient-id').value = patient.patient_id;
            document.querySelector('#edit-first-name').value = patient.first_name;
            document.querySelector('#edit-last-name').value = patient.last_name;
            document.querySelector('#edit-date-of-birth').value = patient.date_of_birth;
            document.querySelector('#edit-gender').value = patient.gender;
            document.querySelector('#edit-email').value = patient.email;
            document.querySelector('#edit-phone-number').value = patient.phone_number;
            document.querySelector('#edit-address').value = patient.address;
            document.querySelector('#edit-insurance-provider').value = patient.insurance_provider;
            document.querySelector('#edit-insurance-policy-number').value = patient.insurance_policy_number;
            document.querySelector('#edit-primary-care-physician').value = patient.primary_care_physician;
            document.querySelector('#edit-medical-history').value = patient.medical_history;
            document.querySelector('#edit-allergies').value = patient.allergies;
            document.querySelector('#edit-status').value = patient.status;
        } else {
            alert('Patient record not found');
        }
    } catch (error) {
        console.error('Error editing patient record:', error);
    }
}

// Form submission for updating a patient record
document.querySelector('#edit-patient-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;

    const patientData = {
        first_name: form.querySelector('#edit-first-name').value,
        last_name: form.querySelector('#edit-last-name').value,
        date_of_birth: form.querySelector('#edit-date-of-birth').value,
        gender: form.querySelector('#edit-gender').value,
        email: form.querySelector('#edit-email').value,
        phone_number: form.querySelector('#edit-phone-number').value,
        address: form.querySelector('#edit-address').value,
        insurance_provider: form.querySelector('#edit-insurance-provider').value,
        insurance_policy_number: form.querySelector('#edit-insurance-policy-number').value,
        primary_care_physician: form.querySelector('#edit-primary-care-physician').value,
        medical_history: form.querySelector('#edit-medical-history').value,
        allergies: form.querySelector('#edit-allergies').value,
        status: form.querySelector('#edit-status').value,
    };

    const patientId = form.querySelector('#edit-patient-id').value;

    updatePatient(patientId, patientData); // Update the patient record
});

// Fetch and display all patient records on page load
document.addEventListener('DOMContentLoaded', fetchPatients);

// Define the API URL for appointment-related requests
const API_URL = 'api/appointments.php';  // Replace with your actual API URL

/**
 * Fetch all appointments and display them in the table
 */
async function fetchAppointments() {
    try {
        const response = await fetch(API_URL);
        const appointments = await response.json();
        displayAppointments(appointments);
    } catch (error) {
        console.error('Error fetching appointments:', error);
    }
}

/**
 * Display appointments in the table
 * @param {Array} appointments - Array of appointment objects
 */
function displayAppointments(appointments) {
    const tbody = document.querySelector('#appointments-table tbody');
    tbody.innerHTML = ''; // Clear existing rows

    appointments.forEach(appointment => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${appointment.appointment_id}</td>
            <td>${appointment.patient_name}</td>
            <td>${appointment.doctor_name}</td>
            <td>${appointment.appointment_date}</td>
            <td>${appointment.reason_for_visit || 'N/A'}</td>
            <td>${appointment.status}</td>
            <td>
                <button class="edit-btn" data-id="${appointment.appointment_id}">Edit</button>
                <button class="delete-btn" data-id="${appointment.appointment_id}">Delete</button>
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
        button.addEventListener('click', () => editAppointment(button.dataset.id));
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => deleteAppointment(button.dataset.id));
    });
}

/**
 * Add a new appointment by submitting the form data via AJAX
 * @param {Event} event - The form submission event
 */
async function addAppointment(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    const form = event.target;
    const appointmentData = new FormData(form);

    const data = {
        patient_id: appointmentData.get('patient_id'),
        doctor_id: appointmentData.get('doctor_id'),
        appointment_date: appointmentData.get('appointment_date'),
        reason_for_visit: appointmentData.get('reason_for_visit'),
        status: appointmentData.get('status'),
        duration: appointmentData.get('duration'),
        appointment_type: appointmentData.get('appointment_type'),
        notes: appointmentData.get('notes')
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
            alert('Appointment added successfully');
            fetchAppointments(); // Refresh the appointment list
            form.reset(); // Reset the form
        } else {
            alert('Error adding appointment');
        }
    } catch (error) {
        console.error('Error adding appointment:', error);
    }
}

/**
 * Edit an existing appointment's details
 * @param {number} appointmentId - The appointment ID
 */
async function editAppointment(appointmentId) {
    try {
        const response = await fetch(`${API_URL}/${appointmentId}`);
        const data = await response.json();

        // Pre-fill the form with the appointment's current data
        const form = document.querySelector('#edit-appointment-form');
        form.patient_id.value = data.patient_id;
        form.doctor_id.value = data.doctor_id;
        form.appointment_date.value = data.appointment_date;
        form.reason_for_visit.value = data.reason_for_visit || '';
        form.status.value = data.status;
        form.duration.value = data.duration || '';
        form.appointment_type.value = data.appointment_type || '';
        form.notes.value = data.notes || '';

        // Attach the appointment ID to the form for later use
        form.dataset.appointmentId = appointmentId;
    } catch (error) {
        console.error('Error fetching appointment data:', error);
    }
}

/**
 * Update an appointment's details via AJAX
 * @param {Event} event - The form submission event
 */
async function updateAppointment(event) {
    event.preventDefault();

    const form = event.target;
    const appointmentId = form.dataset.appointmentId;

    const appointmentData = new FormData(form);
    const data = {
        patient_id: appointmentData.get('patient_id'),
        doctor_id: appointmentData.get('doctor_id'),
        appointment_date: appointmentData.get('appointment_date'),
        reason_for_visit: appointmentData.get('reason_for_visit'),
        status: appointmentData.get('status'),
        duration: appointmentData.get('duration'),
        appointment_type: appointmentData.get('appointment_type'),
        notes: appointmentData.get('notes')
    };

    try {
        const response = await fetch(`${API_URL}/${appointmentId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if (result.success) {
            alert('Appointment updated successfully');
            fetchAppointments(); // Refresh the appointment list
        } else {
            alert('Error updating appointment');
        }
    } catch (error) {
        console.error('Error updating appointment:', error);
    }
}

/**
 * Delete an appointment via AJAX
 * @param {number} appointmentId - The appointment ID
 */
async function deleteAppointment(appointmentId) {
    const confirmDelete = confirm('Are you sure you want to delete this appointment?');
    if (confirmDelete) {
        try {
            const response = await fetch(`${API_URL}/${appointmentId}`, {
                method: 'DELETE'
            });

            const result = await response.json();
            if (result.success) {
                alert('Appointment deleted successfully');
                fetchAppointments(); // Refresh the appointment list
            } else {
                alert('Error deleting appointment');
            }
        } catch (error) {
            console.error('Error deleting appointment:', error);
        }
    }
}

// Event listener for the add appointment form
document.querySelector('#add-appointment-form').addEventListener('submit', addAppointment);

// Event listener for the update appointment form (if applicable)
document.querySelector('#edit-appointment-form').addEventListener('submit', updateAppointment);

// Fetch and display appointments when the page loads
document.addEventListener('DOMContentLoaded', fetchAppointments);
