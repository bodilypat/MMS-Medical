from flask import Flask, render_template, request, redirect
import sqlite3

app = Flask(__name__)

# Connect to the SQLite database
def get_db_connection():
    conn = sqlite3.connect('patients.db')
    conn.row_factory = sqlite3.Row
    return conn

# Create the table if it doesn't exist
def create_table():
    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS patients (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            first_name TEXT,
            last_name TEXT,
            date_of_birth TEXT,
            gender TEXT,
            email TEXT,
            phone_number TEXT,
            address TEXT,
            insurance_provider TEXT,
            insurance_policy_number TEXT,
            primary_care_physician TEXT,
            medical_history TEXT,
            allergies TEXT,
            status TEXT
        )
    ''')
    conn.commit()
    conn.close()

# Route to display the form and handle form submission
@app.route('/', methods=['GET', 'POST'])
def create_patient():
    if request.method == 'POST':
        first_name = request.form['first_name']
        last_name = request.form['last_name']
        date_of_birth = request.form['date_of_birth']
        gender = request.form['gender']
        email = request.form['email']
        phone_number = request.form['phone_number']
        address = request.form['address']
        insurance_provider = request.form['insurance_provider']
        insurance_policy_number = request.form['insurance_policy_number']
        primary_care_physician = request.form['primary_care_physician']
        medical_history = request.form['medical_history']
        allergies = request.form['allergies']
        status = request.form['status']

        # Insert data into database
        conn = get_db_connection()
        cursor = conn.cursor()
        cursor.execute('''
            INSERT INTO patients (first_name, last_name, date_of_birth, gender, email, phone_number, address,
                                  insurance_provider, insurance_policy_number, primary_care_physician, medical_history,
                                  allergies, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ''', (first_name, last_name, date_of_birth, gender, email, phone_number, address, insurance_provider,
              insurance_policy_number, primary_care_physician, medical_history, allergies, status))
        conn.commit()
        conn.close()
        
        return "New patient record created successfully"
    
    return render_template('create_patient.html')

if __name__ == '__main__':
    create_table()  # Create the table when the app starts
    app.run(debug=True)