Full-Stack-MMS-Directory-Structure(no framework)/
│
├── frontend/  
│   ├── index.html                           # Entry point (login or home)
│   ├── dashboard.html                       # Main dashboard after login   
│   │   └── index.html                   
│   ├── patients/                            # Patient module
│   │   ├── list.html
│   │   ├── add.html
│   │   ├── view.html
│   │   └── edit.html 
│   ├── doctors/                             # Doctor module
│   │   ├── list.html
│   │   ├── add.html
│   │   ├── profile.html
│   │   └── schedule.html 
│   ├── appointments/                        # Appointment module
│   │   ├── list.html
│   │   ├── book.html
│   │   └── calender.html 
│   ├── prescriptions/                       # Prescription module
│   │   ├── list.html
│   │   └── add.html 
│   ├── lab-tests/                           # Lab test module
│   │   ├── list.html
│   │   └── results.html 
│   ├── payments/                            # Payment & billing module
│   │   ├── invoices.html
│   │   └── receipt.html 
│   ├── insurance/                           # Insurance module
│   │   ├── polices.html
│   │   └── claim.html 
│   ├── pharmacies/                          # Pharmacy module
│   │   ├── list.html
│   │   └── orders.html 
│   ├── assets/                              # Static resource
│   │   ├── css/
│   │   │   ├── style.css                    # Global styles
│   │   │   ├── layout.css                   # Layout/grid system
│   │   │   └── module/                      # Per-module styles
│   │   │       ├── patients.css
│   │   │       └── doctors.css
│   │   ├── js/
│   │   │   ├── main.js                      # Entry point script
│   │   │   ├── auth.js                      # Login/logout logic
│   │   │   ├── api.js                       # Fetch and XHR utils
│   │   │   └── module/                      # Per-module logic
│   │   │       ├── patients.js
│   │   │       ├── doctors.js
│   │   │       └── appointments.css
│   │   └── images/
│   │       └── Logo.png
│   ├── components/                           # Reusable UI parts
│   │   ├── navbar.html
│   │   ├── sidebar.html
│   │   └── footer.html 
│   ├── utils/                                # Helpers (optional)
│   │   ├── form-validation.js
│   │   └── date-utils.js 
│   ├── README.md 
│   └── LICENSE                    
│
├── backend/
│   ├── public/                               # Publicly accesssible files (entry point)
│   │   ├── index.php                         # Entry script 
│   │   ├── assets/                           # Public assets (CSS,JS if needed here)
│   │   └── uploads/                          # file upload (medical records)
│   ├── config/                               # Configuration files
│   │   ├── database.php
│   │   └── constant.php
│   ├── routes/                               # Entry points (AJAX & REST)
│   │   ├── api/
│   │   │   ├── patients.php
│   │   │   ├── doctors.php
│   │   │   └── appointments.php
│   │   └── web.php
│   │
│   ├── controllers/                          # Logic for each entity/module
│   │   ├── AuthController.php
│   │   ├── PatientController.php
│   │   ├── DoctorController.php
│   │   ├── AppointmentController.php
│   │   ├── MedicalRecordController.php
│   │   ├── PrescriptionController.php
│   │   ├── LabTestController.php
│   │   ├── BillingController.php
│   │   ├── InsuranceController.php
│   │   └── PaymentController.php
│   ├── models/                               # DB interactive / orm-style PHP classes
│   │   ├── User.php
│   │   ├── Patient.php
│   │   ├── Doctor.php
│   │   ├── Appointment.php
│   │   ├── MedicalRecord.php
│   │   ├── Prescription.php
│   │   ├── LabTest.php
│   │   ├── Billing.php
│   │   ├── Insurance.php
│   │   └── Payment.php
│   ├── helpers/                              # Utility/helper functions
│   │   ├── auth.php
│   │   ├── response.php
│   │   └── validator.php
│   ├── middleware/                           # Access control, validation
│   │   └── authMiddleware.php
│   ├── logs/                                 # Log files
│   │   └── error.log
│   ├── sql/                                  # SQL scripts (schema and seed data)
│   │   ├── schema.sql
│   │   └── seed.sql.php
│   └── tests/                                # Basic test files or test data       
│		└── PatientTest.php              
│
├── .env                                      # Environment variable
├── .htaccess                                 # Apache rewrite rules (if applicable)
├── composer.json                             # PHP dependency manager (optional)
└── README.md
