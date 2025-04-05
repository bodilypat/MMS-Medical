const API_URL = 'http://localhost/medical/backend/api/payments.php';

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