from flask import Flask, render_template, request, redirect, url_for
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)

# Set up the database URI (for SQLite in this case)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///doctors.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

# Create the Doctor model
class Doctor(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    first_name = db.Column(db.String(100), nullable=False)
    last_name = db.Column(db.String(100), nullable=False)
    specialization = db.Column(db.String(100), nullable=False)
    email = db.Column(db.String(100), nullable=False, unique=True)
    phone_number = db.Column(db.String(20), nullable=False)
    department = db.Column(db.String(100))
    birthdate = db.Column(db.String(20))
    address = db.Column(db.String(200))
    status = db.Column(db.String(50))
    notes = db.Column(db.Text)

# Initialize the database
@app.before_first_request
def create_tables():
    db.create_all()

# Route to display the form and handle POST requests
@app.route('/create_doctor', methods=['GET', 'POST'])
def create_doctor():
    if request.method == 'POST':
        # Collect form data
        first_name = request.form['first_name']
        last_name = request.form['last_name']
        specialization = request.form['specialization']
        email = request.form['email']
        phone_number = request.form['phone_number']
        department = request.form['department']
        birthdate = request.form['birthdate']
        address = request.form['address']
        status = request.form['status']
        notes = request.form['notes']

        # Insert into the database
        new_doctor = Doctor(
            first_name=first_name,
            last_name=last_name,
            specialization=specialization,
            email=email,
            phone_number=phone_number,
            department=department,
            birthdate=birthdate,
            address=address,
            status=status,
            notes=notes
        )

        db.session.add(new_doctor)
        db.session.commit()

        return redirect(url_for('doctor_list'))

    return render_template('create_doctor.html')

@app.route('/doctor_list')
def doctor_list():
    doctors = Doctor.query.all()
    return render_template('doctor_list.html', doctors=doctors)

if __name__ == '__main__':
    app.run(debug=True)