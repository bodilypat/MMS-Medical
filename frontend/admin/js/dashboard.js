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
