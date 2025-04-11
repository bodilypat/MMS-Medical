const API_URL = '/api/doctors.php'; // Change URL based on your backend

// Fetch all doctor records
async function fetchDoctors() {
    try {
        const response = await fetch(API_URL);
        const doctors = await response.json();
        console.log('All Doctors:', doctors);
        displayDoctors(doctors); // Function to display doctors in a table
    } catch (error) {
        console.error('Error fetching doctor records:', error);
    }
}

// Create a new doctor record
async function createDoctor(data) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Create Doctor Response:', result);
        if (result.success) {
            alert('Doctor record created successfully');
            fetchDoctors(); // Reload doctors after creation
        } else {
            alert('Error creating doctor record');
        }
    } catch (error) {
        console.error('Error creating doctor record:', error);
    }
}

// Update an existing doctor record
async function updateDoctor(id, data) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Update Doctor Response:', result);
        if (result.success) {
            alert('Doctor record updated successfully');
            fetchDoctors(); // Reload doctors after update
        } else {
            alert('Error updating doctor record');
        }
    } catch (error) {
        console.error('Error updating doctor record:', error);
    }
}

// Delete a doctor record
async function deleteDoctor(id) {
    const confirmDelete = confirm('Are you sure you want to delete this doctor record?');
    if (confirmDelete) {
        try {
            const response = await fetch(`${API_URL}?id=${id}`, {
                method: 'DELETE',
            });

            const result = await response.json();
            console.log('Delete Doctor Response:', result);
            if (result.success) {
                alert('Doctor record deleted successfully');
                fetchDoctors(); // Reload doctors after deletion
            } else {
                alert('Error deleting doctor record');
            }
        } catch (error) {
            console.error('Error deleting doctor record:', error);
        }
    }
}

// Display doctor records in a table format
function displayDoctors(doctors) {
    const tableBody = document.querySelector('#doctor-table tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    doctors.forEach(doctor => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${doctor.doctor_id}</td>
            <td>${doctor.first_name}</td>
            <td>${doctor.last_name}</td>
            <td>${doctor.specialization}</td>
            <td>${doctor.email}</td>
            <td>${doctor.phone_number}</td>
            <td>${doctor.department}</td>
            <td>${doctor.birthdate}</td>
            <td>${doctor.status}</td>
            <td>
                <button onclick="editDoctor(${doctor.doctor_id})">Edit</button>
                <button onclick="deleteDoctor(${doctor.doctor_id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Edit a doctor record (this function will pre-fill a form with existing doctor details)
async function editDoctor(id) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`);
        const doctor = await response.json();
        if (doctor) {
            // Pre-fill the form with the doctor details (assuming you have a form with id `edit-doctor-form`)
            document.querySelector('#edit-doctor-id').value = doctor.doctor_id;
            document.querySelector('#edit-first-name').value = doctor.first_name;
            document.querySelector('#edit-last-name').value = doctor.last_name;
            document.querySelector('#edit-specialization').value = doctor.specialization;
            document.querySelector('#edit-email').value = doctor.email;
            document.querySelector('#edit-phone-number').value = doctor.phone_number;
            document.querySelector('#edit-department').value = doctor.department;
            document.querySelector('#edit-birthdate').value = doctor.birthdate;
            document.querySelector('#edit-status').value = doctor.status;
            document.querySelector('#edit-notes').value = doctor.notes;
        } else {
            alert('Doctor record not found');
        }
    } catch (error) {
        console.error('Error editing doctor record:', error);
    }
}

// Form submission for updating a doctor record
document.querySelector('#edit-doctor-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;

    const doctorData = {
        first_name: form.querySelector('#edit-first-name').value,
        last_name: form.querySelector('#edit-last-name').value,
        specialization: form.querySelector('#edit-specialization').value,
        email: form.querySelector('#edit-email').value,
        phone_number: form.querySelector('#edit-phone-number').value,
        department: form.querySelector('#edit-department').value,
        birthdate: form.querySelector('#edit-birthdate').value,
        status: form.querySelector('#edit-status').value,
        notes: form.querySelector('#edit-notes').value,
    };

    const doctorId = form.querySelector('#edit-doctor-id').value;

    updateDoctor(doctorId, doctorData); // Update the doctor record
});

// Fetch and display all doctor records on page load
document.addEventListener('DOMContentLoaded', fetchDoctors);
const API_URL = '/api/patients.php'; // Adjust URL to your backend

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
const API_URL = '/api/appointments.php';  // Replace with your actual API URL

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

const API_URL = '/api/lab_tests.php';

// Fetch all lab tests for a given patient (or all if no patient filter is applied)
async function fetchLabTests(patientId = null) {
    try {
        const url = patientId ? `${API_URL}?patient_id=${patientId}` : API_URL;
        const response = await fetch(url);
        const labTests = await response.json();
        console.log('All Lab Tests:', labTests);
        displayLabTests(labTests); // Function to display the lab tests on the page
    } catch (error) {
        console.error('Error fetching lab tests:', error);
    }
}

// Create a new lab test
async function createLabTest(data) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Create Lab Test Response:', result);
        if (result.success) {
            alert('Lab test created successfully');
            fetchLabTests();  // Reload the lab tests after creation
        } else {
            alert('Error creating lab test');
        }
    } catch (error) {
        console.error('Error creating lab test:', error);
    }
}

// Update an existing lab test
async function updateLabTest(id, data) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Update Lab Test Response:', result);
        if (result.success) {
            alert('Lab test updated successfully');
            fetchLabTests();  // Reload the lab tests after update
        } else {
            alert('Error updating lab test');
        }
    } catch (error) {
        console.error('Error updating lab test:', error);
    }
}

// Delete a lab test
async function deleteLabTest(id) {
    const confirmDelete = confirm('Are you sure you want to delete this lab test?');
    if (confirmDelete) {
        try {
            const response = await fetch(`${API_URL}?id=${id}`, {
                method: 'DELETE',
            });

            const result = await response.json();
            console.log('Delete Lab Test Response:', result);
            if (result.success) {
                alert('Lab test deleted successfully');
                fetchLabTests();  // Reload the lab tests after deletion
            } else {
                alert('Error deleting lab test');
            }
        } catch (error) {
            console.error('Error deleting lab test:', error);
        }
    }
}

// Display lab tests in a table
function displayLabTests(labTests) {
    const tableBody = document.querySelector('#lab-tests-table tbody');
    tableBody.innerHTML = '';  // Clear existing rows

    labTests.forEach(labTest => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${labTest.test_id}</td>
            <td>${labTest.patient_id}</td>
            <td>${labTest.appointment_id}</td>
            <td>${labTest.test_name}</td>
            <td>${labTest.test_date}</td>
            <td>${labTest.results || 'Not Available'}</td>
            <td>${labTest.test_status}</td>
            <td>${labTest.created_at}</td>
            <td>${labTest.updated_at}</td>
            <td>
                <button onclick="editLabTest(${labTest.test_id})">Edit</button>
                <button onclick="deleteLabTest(${labTest.test_id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Edit a lab test (this function will pre-fill a form with the existing lab test details)
async function editLabTest(id) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`);
        const labTest = await response.json();
        if (labTest) {
            // Pre-fill the form with the lab test details (Assuming you have a form with id `edit-lab-test-form`)
            document.querySelector('#edit-test-id').value = labTest.test_id;
            document.querySelector('#edit-patient-id').value = labTest.patient_id;
            document.querySelector('#edit-appointment-id').value = labTest.appointment_id;
            document.querySelector('#edit-test-name').value = labTest.test_name;
            document.querySelector('#edit-test-date').value = labTest.test_date;
            document.querySelector('#edit-results').value = labTest.results || '';
            document.querySelector('#edit-test-status').value = labTest.test_status;
        } else {
            alert('Lab test not found');
        }
    } catch (error) {
        console.error('Error editing lab test:', error);
    }
}

// Form submission for updating a lab test
document.querySelector('#edit-lab-test-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;

    const labTestData = {
        patient_id: form.querySelector('#edit-patient-id').value,
        appointment_id: form.querySelector('#edit-appointment-id').value,
        test_name: form.querySelector('#edit-test-name').value,
        test_date: form.querySelector('#edit-test-date').value,
        results: form.querySelector('#edit-results').value,
        test_status: form.querySelector('#edit-test-status').value,
    };

    const testId = form.querySelector('#edit-test-id').value;

    updateLabTest(testId, labTestData);  // Update the lab test
});

// Fetch and display all lab tests on page load
document.addEventListener('DOMContentLoaded', fetchLabTests);

const API_URL = '/api/medical_records.php';

// Fetch all medical records
async function fetchMedicalRecords() {
    try {
        const response = await fetch(API_URL);
        const records = await response.json();
        console.log('All Records:', records);
        displayMedicalRecords(records);  // A function to display records on the page
    } catch (error) {
        console.error('Error fetching medical records:', error);
    }
}

// Create a new medical record
async function createMedicalRecord(data) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Create Record Response:', result);
        if (result.success) {
            alert('Medical record created successfully');
            fetchMedicalRecords();  // Reload the records after creation
        } else {
            alert('Error creating record');
        }
    } catch (error) {
        console.error('Error creating medical record:', error);
    }
}

// Update an existing medical record
async function updateMedicalRecord(id, data) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Update Record Response:', result);
        if (result.success) {
            alert('Medical record updated successfully');
            fetchMedicalRecords();  // Reload the records after update
        } else {
            alert('Error updating record');
        }
    } catch (error) {
        console.error('Error updating medical record:', error);
    }
}

// Delete a medical record
async function deleteMedicalRecord(id) {
    const confirmDelete = confirm('Are you sure you want to delete this record?');
    if (confirmDelete) {
        try {
            const response = await fetch(`${API_URL}?id=${id}`, {
                method: 'DELETE',
            });

            const result = await response.json();
            console.log('Delete Record Response:', result);
            if (result.success) {
                alert('Medical record deleted successfully');
                fetchMedicalRecords();  // Reload the records after deletion
            } else {
                alert('Error deleting record');
            }
        } catch (error) {
            console.error('Error deleting medical record:', error);
        }
    }
}

// Display medical records in the table (you can call this function after fetching data)
function displayMedicalRecords(records) {
    const tableBody = document.querySelector('#medical-records-table tbody');
    tableBody.innerHTML = '';  // Clear existing rows

    records.forEach(record => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${record.record_id}</td>
            <td>${record.patient_id}</td>
            <td>${record.appointment_id}</td>
            <td>${record.diagnosis}</td>
            <td>${record.treatment_plan}</td>
            <td>${record.note}</td>
            <td>${record.status}</td>
            <td>${record.created_at}</td>
            <td>${record.updated_at}</td>
            <td>
                <button onclick="editMedicalRecord(${record.record_id})">Edit</button>
                <button onclick="deleteMedicalRecord(${record.record_id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Edit a medical record (this function will pre-fill a form with the existing record details)
async function editMedicalRecord(id) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`);
        const record = await response.json();
        if (record) {
            // Pre-fill the form with the record details (Assuming you have a form with id `edit-record-form`)
            document.querySelector('#edit-record-id').value = record.record_id;
            document.querySelector('#edit-patient-id').value = record.patient_id;
            document.querySelector('#edit-appointment-id').value = record.appointment_id;
            document.querySelector('#edit-diagnosis').value = record.diagnosis;
            document.querySelector('#edit-treatment-plan').value = record.treatment_plan;
            document.querySelector('#edit-note').value = record.note;
            document.querySelector('#edit-status').value = record.status;
            document.querySelector('#edit-created-at').value = record.created_at;
            document.querySelector('#edit-updated-at').value = record.updated_at;
        } else {
            alert('Record not found');
        }
    } catch (error) {
        console.error('Error editing medical record:', error);
    }
}

// Form submission for updating medical record
document.querySelector('#edit-record-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;

    const recordData = {
        patient_id: form.querySelector('#edit-patient-id').value,
        appointment_id: form.querySelector('#edit-appointment-id').value,
        diagnosis: form.querySelector('#edit-diagnosis').value,
        treatment_plan: form.querySelector('#edit-treatment-plan').value,
        note: form.querySelector('#edit-note').value,
        status: form.querySelector('#edit-status').value,
    };

    const recordId = form.querySelector('#edit-record-id').value;

    updateMedicalRecord(recordId, recordData);  // Update the record
});

// Fetch and display all records on page load
document.addEventListener('DOMContentLoaded', fetchMedicalRecords);

const API_URL = '/api/prescriptions.php';

// Fetch all prescriptions
async function fetchPrescriptions() {
    try {
        const response = await fetch(API_URL);
        const prescriptions = await response.json();
        console.log('All Prescriptions:', prescriptions);
        displayPrescriptions(prescriptions); // Function to display the prescriptions on the page
    } catch (error) {
        console.error('Error fetching prescriptions:', error);
    }
}

// Create a new prescription
async function createPrescription(data) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Create Prescription Response:', result);
        if (result.success) {
            alert('Prescription created successfully');
            fetchPrescriptions();  // Reload the prescriptions after creation
        } else {
            alert('Error creating prescription');
        }
    } catch (error) {
        console.error('Error creating prescription:', error);
    }
}

// Update an existing prescription
async function updatePrescription(id, data) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Update Prescription Response:', result);
        if (result.success) {
            alert('Prescription updated successfully');
            fetchPrescriptions();  // Reload the prescriptions after update
        } else {
            alert('Error updating prescription');
        }
    } catch (error) {
        console.error('Error updating prescription:', error);
    }
}

// Delete a prescription
async function deletePrescription(id) {
    const confirmDelete = confirm('Are you sure you want to delete this prescription?');
    if (confirmDelete) {
        try {
            const response = await fetch(`${API_URL}?id=${id}`, {
                method: 'DELETE',
            });

            const result = await response.json();
            console.log('Delete Prescription Response:', result);
            if (result.success) {
                alert('Prescription deleted successfully');
                fetchPrescriptions();  // Reload the prescriptions after deletion
            } else {
                alert('Error deleting prescription');
            }
        } catch (error) {
            console.error('Error deleting prescription:', error);
        }
    }
}

// Display prescriptions in a table
function displayPrescriptions(prescriptions) {
    const tableBody = document.querySelector('#prescriptions-table tbody');
    tableBody.innerHTML = '';  // Clear existing rows

    prescriptions.forEach(prescription => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${prescription.prescription_id}</td>
            <td>${prescription.record_id}</td>
            <td>${prescription.medication_name}</td>
            <td>${prescription.dosage}</td>
            <td>${prescription.frequency}</td>
            <td>${prescription.start_date}</td>
            <td>${prescription.end_date || 'Ongoing'}</td>
            <td>${prescription.status}</td>
            <td>${prescription.created_at}</td>
            <td>${prescription.updated_at}</td>
            <td>
                <button onclick="editPrescription(${prescription.prescription_id})">Edit</button>
                <button onclick="deletePrescription(${prescription.prescription_id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Edit a prescription (this function will pre-fill a form with the existing prescription details)
async function editPrescription(id) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`);
        const prescription = await response.json();
        if (prescription) {
            // Pre-fill the form with the prescription details (Assuming you have a form with id `edit-prescription-form`)
            document.querySelector('#edit-prescription-id').value = prescription.prescription_id;
            document.querySelector('#edit-record-id').value = prescription.record_id;
            document.querySelector('#edit-medication-name').value = prescription.medication_name;
            document.querySelector('#edit-dosage').value = prescription.dosage;
            document.querySelector('#edit-frequency').value = prescription.frequency;
            document.querySelector('#edit-start-date').value = prescription.start_date;
            document.querySelector('#edit-end-date').value = prescription.end_date || '';
            document.querySelector('#edit-instructions').value = prescription.instructions;
            document.querySelector('#edit-status').value = prescription.status;
        } else {
            alert('Prescription not found');
        }
    } catch (error) {
        console.error('Error editing prescription:', error);
    }
}

// Form submission for updating prescription
document.querySelector('#edit-prescription-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;

    const prescriptionData = {
        record_id: form.querySelector('#edit-record-id').value,
        medication_name: form.querySelector('#edit-medication-name').value,
        dosage: form.querySelector('#edit-dosage').value,
        frequency: form.querySelector('#edit-frequency').value,
        start_date: form.querySelector('#edit-start-date').value,
        end_date: form.querySelector('#edit-end-date').value,
        instructions: form.querySelector('#edit-instructions').value,
        status: form.querySelector('#edit-status').value,
    };

    const prescriptionId = form.querySelector('#edit-prescription-id').value;

    updatePrescription(prescriptionId, prescriptionData);  // Update the prescription
});

// Fetch and display all prescriptions on page load
document.addEventListener('DOMContentLoaded', fetchPrescriptions);

const API_URL = '/api/pharmacies.php';

// Fetch all pharmacies
async function fetchPharmacies() {
    try {
        const response = await fetch(API_URL);
        const pharmacies = await response.json();
        console.log('All Pharmacies:', pharmacies);
        displayPharmacies(pharmacies); // Function to display pharmacies in the table
    } catch (error) {
        console.error('Error fetching pharmacies:', error);
    }
}

// Create a new pharmacy
async function createPharmacy(data) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Create Pharmacy Response:', result);
        if (result.success) {
            alert('Pharmacy created successfully');
            fetchPharmacies(); // Reload pharmacies after creation
        } else {
            alert('Error creating pharmacy');
        }
    } catch (error) {
        console.error('Error creating pharmacy:', error);
    }
}

// Update an existing pharmacy
async function updatePharmacy(id, data) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Update Pharmacy Response:', result);
        if (result.success) {
            alert('Pharmacy updated successfully');
            fetchPharmacies(); // Reload pharmacies after update
        } else {
            alert('Error updating pharmacy');
        }
    } catch (error) {
        console.error('Error updating pharmacy:', error);
    }
}

// Delete a pharmacy
async function deletePharmacy(id) {
    const confirmDelete = confirm('Are you sure you want to delete this pharmacy?');
    if (confirmDelete) {
        try {
            const response = await fetch(`${API_URL}?id=${id}`, {
                method: 'DELETE',
            });

            const result = await response.json();
            console.log('Delete Pharmacy Response:', result);
            if (result.success) {
                alert('Pharmacy deleted successfully');
                fetchPharmacies(); // Reload pharmacies after deletion
            } else {
                alert('Error deleting pharmacy');
            }
        } catch (error) {
            console.error('Error deleting pharmacy:', error);
        }
    }
}

// Display pharmacies in a table format
function displayPharmacies(pharmacies) {
    const tableBody = document.querySelector('#pharmacies-table tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    pharmacies.forEach(pharmacy => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${pharmacy.pharmacy_id}</td>
            <td>${pharmacy.name}</td>
            <td>${pharmacy.address}</td>
            <td>${pharmacy.phone_number}</td>
            <td>${pharmacy.email}</td>
            <td>${pharmacy.created_at}</td>
            <td>${pharmacy.updated_at}</td>
            <td>
                <button onclick="editPharmacy(${pharmacy.pharmacy_id})">Edit</button>
                <button onclick="deletePharmacy(${pharmacy.pharmacy_id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Edit a pharmacy record (this function will pre-fill a form with existing pharmacy details)
async function editPharmacy(id) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`);
        const pharmacy = await response.json();
        if (pharmacy) {
            // Pre-fill the form with the pharmacy details (assuming you have a form with id `edit-pharmacy-form`)
            document.querySelector('#edit-pharmacy-id').value = pharmacy.pharmacy_id;
            document.querySelector('#edit-name').value = pharmacy.name;
            document.querySelector('#edit-address').value = pharmacy.address;
            document.querySelector('#edit-phone-number').value = pharmacy.phone_number;
            document.querySelector('#edit-email').value = pharmacy.email;
        } else {
            alert('Pharmacy not found');
        }
    } catch (error) {
        console.error('Error editing pharmacy:', error);
    }
}

// Form submission for updating a pharmacy record
document.querySelector('#edit-pharmacy-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;

    const pharmacyData = {
        name: form.querySelector('#edit-name').value,
        address: form.querySelector('#edit-address').value,
        phone_number: form.querySelector('#edit-phone-number').value,
        email: form.querySelector('#edit-email').value,
    };

    const pharmacyId = form.querySelector('#edit-pharmacy-id').value;

    updatePharmacy(pharmacyId, pharmacyData); // Update the pharmacy
});

// Fetch and display all pharmacies on page load
document.addEventListener('DOMContentLoaded', fetchPharmacies);

const API_URL = '/api/insurance.php';

// Fetch all insurance records
async function fetchInsurance() {
    try {
        const response = await fetch(API_URL);
        const insurance = await response.json();
        console.log('All Insurance Records:', insurance);
        displayInsurance(insurance); // Function to display insurance records in a table
    } catch (error) {
        console.error('Error fetching insurance records:', error);
    }
}

// Create a new insurance record
async function createInsurance(data) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Create Insurance Response:', result);
        if (result.success) {
            alert('Insurance record created successfully');
            fetchInsurance(); // Reload insurance records after creation
        } else {
            alert('Error creating insurance record');
        }
    } catch (error) {
        console.error('Error creating insurance record:', error);
    }
}

// Update an existing insurance record
async function updateInsurance(id, data) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Update Insurance Response:', result);
        if (result.success) {
            alert('Insurance record updated successfully');
            fetchInsurance(); // Reload insurance records after update
        } else {
            alert('Error updating insurance record');
        }
    } catch (error) {
        console.error('Error updating insurance record:', error);
    }
}

// Delete an insurance record
async function deleteInsurance(id) {
    const confirmDelete = confirm('Are you sure you want to delete this insurance record?');
    if (confirmDelete) {
        try {
            const response = await fetch(`${API_URL}?id=${id}`, {
                method: 'DELETE',
            });

            const result = await response.json();
            console.log('Delete Insurance Response:', result);
            if (result.success) {
                alert('Insurance record deleted successfully');
                fetchInsurance(); // Reload insurance records after deletion
            } else {
                alert('Error deleting insurance record');
            }
        } catch (error) {
            console.error('Error deleting insurance record:', error);
        }
    }
}

// Display insurance records in a table format
function displayInsurance(insurance) {
    const tableBody = document.querySelector('#insurance-table tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    insurance.forEach(item => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${item.insurance_id}</td>
            <td>${item.provider_name}</td>
            <td>${item.policy_number}</td>
            <td>${item.coverage_type}</td>
            <td>${item.converage_amount}</td>
            <td>${item.patient_id}</td>
            <td>${item.start_date}</td>
            <td>${item.end_date}</td>
            <td>
                <button onclick="editInsurance(${item.insurance_id})">Edit</button>
                <button onclick="deleteInsurance(${item.insurance_id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Edit an insurance record (this function will pre-fill a form with existing insurance details)
async function editInsurance(id) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`);
        const insurance = await response.json();
        if (insurance) {
            // Pre-fill the form with the insurance details (assuming you have a form with id `edit-insurance-form`)
            document.querySelector('#edit-insurance-id').value = insurance.insurance_id;
            document.querySelector('#edit-provider-name').value = insurance.provider_name;
            document.querySelector('#edit-policy-number').value = insurance.policy_number;
            document.querySelector('#edit-coverage-type').value = insurance.coverage_type;
            document.querySelector('#edit-coverage-amount').value = insurance.converage_amount;
            document.querySelector('#edit-patient-id').value = insurance.patient_id;
            document.querySelector('#edit-start-date').value = insurance.start_date;
            document.querySelector('#edit-end-date').value = insurance.end_date;
        } else {
            alert('Insurance record not found');
        }
    } catch (error) {
        console.error('Error editing insurance record:', error);
    }
}

// Form submission for updating an insurance record
document.querySelector('#edit-insurance-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;

    const insuranceData = {
        provider_name: form.querySelector('#edit-provider-name').value,
        policy_number: form.querySelector('#edit-policy-number').value,
        coverage_type: form.querySelector('#edit-coverage-type').value,
        converage_amount: form.querySelector('#edit-coverage-amount').value,
        patient_id: form.querySelector('#edit-patient-id').value,
        start_date: form.querySelector('#edit-start-date').value,
        end_date: form.querySelector('#edit-end-date').value,
    };

    const insuranceId = form.querySelector('#edit-insurance-id').value;

    updateInsurance(insuranceId, insuranceData); // Update the insurance record
});

// Fetch and display all insurance records on page load
document.addEventListener('DOMContentLoaded', fetchInsurance);

const API_URL = '/api/payments.php';

// Fetch all payments for a given patient
async function fetchPayments(patientId = null) {
    try {
        const url = patientId ? `${API_URL}?patient_id=${patientId}` : API_URL;
        const response = await fetch(url);
        const payments = await response.json();
        console.log('All Payments:', payments);
        displayPayments(payments); // Function to display payments in the table
    } catch (error) {
        console.error('Error fetching payments:', error);
    }
}

// Create a new payment record
async function createPayment(data) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Create Payment Response:', result);
        if (result.success) {
            alert('Payment record created successfully');
            fetchPayments(); // Reload payments after creation
        } else {
            alert('Error creating payment record');
        }
    } catch (error) {
        console.error('Error creating payment:', error);
    }
}

// Update an existing payment record
async function updatePayment(id, data) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log('Update Payment Response:', result);
        if (result.success) {
            alert('Payment record updated successfully');
            fetchPayments(); // Reload payments after update
        } else {
            alert('Error updating payment record');
        }
    } catch (error) {
        console.error('Error updating payment:', error);
    }
}

// Delete a payment record
async function deletePayment(id) {
    const confirmDelete = confirm('Are you sure you want to delete this payment record?');
    if (confirmDelete) {
        try {
            const response = await fetch(`${API_URL}?id=${id}`, {
                method: 'DELETE',
            });

            const result = await response.json();
            console.log('Delete Payment Response:', result);
            if (result.success) {
                alert('Payment record deleted successfully');
                fetchPayments(); // Reload payments after deletion
            } else {
                alert('Error deleting payment record');
            }
        } catch (error) {
            console.error('Error deleting payment:', error);
        }
    }
}

// Display payments in a table format
function displayPayments(payments) {
    const tableBody = document.querySelector('#payments-table tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    payments.forEach(payment => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${payment.billing_id}</td>
            <td>${payment.patient_id}</td>
            <td>${payment.appointment_id}</td>
            <td>${payment.total_amount}</td>
            <td>${payment.amount_paid}</td>
            <td>${payment.balance_due}</td>
            <td>${payment.payment_status}</td>
            <td>${payment.payment_date}</td>
            <td>${payment.insurance_claimed_amount || 'N/A'}</td>
            <td>${payment.insurance_status || 'N/A'}</td>
            <td>${payment.created_at}</td>
            <td>${payment.updated_at}</td>
            <td>
                <button onclick="editPayment(${payment.billing_id})">Edit</button>
                <button onclick="deletePayment(${payment.billing_id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Edit a payment record (this function will pre-fill a form with existing payment details)
async function editPayment(id) {
    try {
        const response = await fetch(`${API_URL}?id=${id}`);
        const payment = await response.json();
        if (payment) {
            // Pre-fill the form with the payment details (assuming you have a form with id `edit-payment-form`)
            document.querySelector('#edit-billing-id').value = payment.billing_id;
            document.querySelector('#edit-patient-id').value = payment.patient_id;
            document.querySelector('#edit-appointment-id').value = payment.appointment_id;
            document.querySelector('#edit-total-amount').value = payment.total_amount;
            document.querySelector('#edit-amount-paid').value = payment.amount_paid;
            document.querySelector('#edit-balance-due').value = payment.balance_due;
            document.querySelector('#edit-payment-status').value = payment.payment_status;
            document.querySelector('#edit-insurance-claimed-amount').value = payment.insurance_claimed_amount || '';
            document.querySelector('#edit-insurance-status').value = payment.insurance_status || '';
        } else {
            alert('Payment not found');
        }
    } catch (error) {
        console.error('Error editing payment:', error);
    }
}

// Form submission for updating a payment record
document.querySelector('#edit-payment-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;

    const paymentData = {
        patient_id: form.querySelector('#edit-patient-id').value,
        appointment_id: form.querySelector('#edit-appointment-id').value,
        total_amount: form.querySelector('#edit-total-amount').value,
        amount_paid: form.querySelector('#edit-amount-paid').value,
        balance_due: form.querySelector('#edit-balance-due').value,
        payment_status: form.querySelector('#edit-payment-status').value,
        insurance_claimed_amount: form.querySelector('#edit-insurance-claimed-amount').value,
        insurance_status: form.querySelector('#edit-insurance-status').value,
    };

    const billingId = form.querySelector('#edit-billing-id').value;

    updatePayment(billingId, paymentData); // Update the payment
});

// Fetch and display all payments on page load
document.addEventListener('DOMContentLoaded', fetchPayments);