const API_URL = 'http://localhost/medical/backend/api/insurance.php';

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