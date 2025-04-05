const API_URL = 'http://localhost/medical/backend/api/lab_tests.php';

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