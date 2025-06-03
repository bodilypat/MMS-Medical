Full-Stack-MMS-Directory-Structure/
│
├── frontend/  
│   ├── public/                          # Public root, assets served from here
│   ├── pages/                           # HTML views grouped by domain
│   │   ├── auth/
│   │   │   ├── login.html
│   │   │   └── register.html
│   │   ├── dashboard/
│   │   │   ├── admin.html
│   │   │   ├── doctor.html
│   │   │   └── patient.html
│   │   ├── patients/
│   │   │   ├── list.html
│   │   │   ├── profile.html
│   │   │   └── edit.html
│   │   ├── doctors/
│   │   │   ├── list.html
│   │   │   ├── profile.html
│   │   │   └── schedule.html
│   │   ├── appointments/
│   │   │   ├── list.html
│   │   │   └── form.html
│   │   ├── records/
│   │   │   ├── list.html
│   │   │   └── detail.html
│   │   ├── prescriptions/
│   │   │   └── list.html
│   │   ├── lab-tests/
│   │   │   └── index.html
│   │   ├── billing/
│   │   │   ├── payments.html
│   │   │   └── invoice.html
│   │   ├── insurance/
│   │   │   └── pharmacy.html
│   │   └── profile/
│   │       ├── profile.html
│   │       └── settings.html
│   │
│   ├── assets/                         
│   │   ├── css/
│   │   │   ├── main.css
│   │   │   └── modules/
│   │   │       ├── auth.css
│   │   │       ├── dashboard.css
│   │   │       ├── forms.css
│   │   │       ├── tables.css
│   │   │       └── modal.css
│   │   ├── js/
│   │   │   ├── main.js
│   │   │   ├── api.js
│   │   │   ├── auth.js
│   │   │   └── modules/
│   │   │       ├── patients.js
│   │   │       ├── doctors.js
│   │   │       ├── appointments.js
│   │   │       ├── records.js
│   │   │       ├── prescriptions.js
│   │   │       ├── lab-tests.js
│   │   │       ├── pharmacy.js
│   │   │       ├── insurance.js
│   │   │       └── payments.js
│   │   ├── images/
│   │   └── fonts/
│   │
│   ├── components/                     # Reusable HTML includes
│   │   ├── header.html
│   │   ├── footer.html
│   │   ├── sidebar.html
│   │   ├── navbar.html
│   │   └── modal.html
│   │
│   ├── data/
│   │   ├── patients.json
│   │   ├── doctors.json
│   │   └── appointments.json
│   │
│   ├── uploads/                        # Local file uploads (images, documents)
│   ├── .gitignore
│   └── package.json                    # Optional, if you manage frontend dependencies
│
├── backend/
│   ├── api/                            # Entry points (AJAX & REST)
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   ├── register.php
│   │   │   └── reset-password.php
│   │   ├── patients/
│   │   │   ├── get-all.php
│   │   │   ├── create.php
│   │   │   └── profile.php
│   │   ├── doctors/
│   │   │   ├── get-all.php
│   │   │   └── profile.php
│   │   ├── appointments/
│   │   │   ├── create.php
│   │   │   └── get-by-date.php
│   │   ├── medical-records/
│   │   │   ├── upload.php
│   │   │   └── get.php
│   │   └── prescriptions/
│   │       ├── create.php
│   │       └── get.php
│
│   ├── controllers/                    # Logic layer
│   │   ├── AuthController.php
│   │   ├── PatientController.php
│   │   ├── DoctorController.php
│   │   ├── AppointmentController.php
│   │   ├── RecordController.php
│   │   ├── PrescriptionController.php
│   │   ├── LabController.php
│   │   ├── BillingController.php
│   │   ├── InsuranceController.php
│   │   └── PaymentController.php
│
│   ├── models/                         # Data layer
│   │   ├── User.php
│   │   ├── Patient.php
│   │   ├── Doctor.php
│   │   ├── Appointment.php
│   │   ├── Record.php
│   │   ├── Prescription.php
│   │   ├── Lab.php
│   │   ├── Billing.php
│   │   ├── Insurance.php
│   │   └── Payment.php
│
│   └── helpers/                        # Utility classes
│       ├── Auth.php
│       ├── Validator.php
│       ├── Response.php
│       └── Logger.php
│
├── config/
│   ├── config.php                      # Global configuration (timezone, app name, etc.)
│   └── database.php                    # DB connection settings
│
├── uploads/                            # Backend file uploads (PDFs, medical scans, etc.)
├── logs/                               # Error and access logs
├── vendor/                             # Composer dependencies (if any)
├── composer.json                       # Backend dependencies
├── .env                                # Environment variables (DB credentials, API keys)
└── README.md
