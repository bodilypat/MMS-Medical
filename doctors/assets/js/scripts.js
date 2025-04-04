document.getElementById('doctorForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting traditionally

    let formData = new FormData(this);

    // You can replace this with an AJAX call to a backend API (for saving to a database)
    let doctorData = {};
    formData.forEach((value, key) => {
        doctorData[key] = value;
    });

    // Simulate adding a new row to the table (you would replace this with actual server interaction)
    let table = document.getElementById('doctorsTable').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow();
    newRow.innerHTML = `
        <td>${doctorData.first_name}</td>
        <td>${doctorData.last_name}</td>
        <td>${doctorData.specialization}</td>
        <td>${doctorData.email}</td>
        <td>${doctorData.phone_number}</td>
        <td>${doctorData.department}</td>
        <td>
            <button class="edit" onclick="editDoctor(this)">Edit</button>
            <button class="delete" onclick="deleteDoctor(this)">Delete</button>
        </td>
    `;

    // Clear the form
    document.getElementById('doctorForm').reset();
});

// Function to delete a doctor
function deleteDoctor(button) {
    let row = button.closest('tr');
    row.remove(); // Remove the row from the table
}

// Function to edit a doctor's details
function editDoctor(button) {
    let row = button.closest('tr');
    let cells = row.getElementsByTagName('td');

    // Populate the form with the data to edit
    document.getElementById('first_name').value = cells[0].innerText;
    document.getElementById('last_name').value = cells[1].innerText;
    document.getElementById('specialization').value = cells[2].innerText;
    document.getElementById('email').value = cells[3].innerText;
    document.getElementById('phone_number').value = cells[4].innerText;
    document.getElementById('department').value = cells[5].innerText;

    // Modify the form to update instead of add
    document.getElementById('doctorForm').addEventListener('submit', function updateDoctor(event) {
        event.preventDefault();

        // Simulate updating the row (Replace with actual server-side update)
        cells[0].innerText = document.getElementById('first_name').value;
        cells[1].innerText = document.getElementById('last_name').value;
        cells[2].innerText = document.getElementById('specialization').value;
        cells[3].innerText = document.getElementById('email').value;
        cells[4].innerText = document.getElementById('phone_number').value;
        cells[5].innerText = document.getElementById('department').value;

        // Reset the form
        document.getElementById('doctorForm').reset();

        // Remove the event listener so it doesn't trigger multiple times
        this.removeEventListener('submit', updateDoctor);
    });
}
