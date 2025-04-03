document.getElementById('patientForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    let formData = new FormData(this);

    // You can add AJAX functionality here to save the form data to the backend
    let patientData = {};
    formData.forEach((value, key) => {
        patientData[key] = value;
    });

    // Simulate adding a new row to the table (you would replace this with actual server interaction)
    let table = document.getElementById('patientsTable').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow();
    newRow.innerHTML = `
        <td>${patientData.first_name}</td>
        <td>${patientData.last_name}</td>
        <td>${patientData.date_of_birth}</td>
        <td>${patientData.gender}</td>
        <td>${patientData.email}</td>
        <td>${patientData.phone_number}</td>
        <td>
            <button class="edit" onclick="editPatient(this)">Edit</button>
            <button class="delete" onclick="deletePatient(this)">Delete</button>
        </td>
    `;

    // Clear the form
    document.getElementById('patientForm').reset();
});

// Function to delete a patient
function deletePatient(button) {
    let row = button.closest('tr');
    row.remove(); // Remove the row from the table
}

// Function to edit a patient's data
function editPatient(button) {
    let row = button.closest('tr');
    let cells = row.getElementsByTagName('td');

    // Populate the form with the data to edit
    document.getElementById('first_name').value = cells[0].innerText;
    document.getElementById('last_name').value = cells[1].innerText;
    document.getElementById('date_of_birth').value = cells[2].innerText;
    document.getElementById('gender').value = cells[3].innerText;
    document.getElementById('email').value = cells[4].innerText;
    document.getElementById('phone_number').value = cells[5].innerText;

    // Modify the form to update instead of add
    document.getElementById('patientForm').addEventListener('submit', function updatePatient(event) {
        event.preventDefault();

        // Simulate updating the row (Replace with actual server-side update)
        cells[0].innerText = document.getElementById('first_name').value;
        cells[1].innerText = document.getElementById('last_name').value;
        cells[2].innerText = document.getElementById('date_of_birth').value;
        cells[3].innerText = document.getElementById('gender').value;
        cells[4].innerText = document.getElementById('email').value;
        cells[5].innerText = document.getElementById('phone_number').value;

        // Reset the form
        document.getElementById('patientForm').reset();

        // Remove the event listener so it doesn't trigger multiple times
        this.removeEventListener('submit', updatePatient);
    });
}
