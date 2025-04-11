const API_URL = 'api/doctors.php'; // Change URL based on your backend

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

const API_URL = 'api/medical_records.php';

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
