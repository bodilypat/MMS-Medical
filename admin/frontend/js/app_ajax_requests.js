// Define the API URL for appointment-related requests
const API_URL = 'http://localhost/medical/backend/api/appointments.php';  // Replace with your actual API URL

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