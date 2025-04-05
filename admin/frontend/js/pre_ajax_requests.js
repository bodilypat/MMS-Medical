const API_URL = 'http://localhost/medical/backend/api/prescriptions.php';

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