const API_URL = 'http://localhost/medical/backend/api/pharmacies.php';

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