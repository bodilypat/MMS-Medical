Full-Stack-MMS-Laravel/
│
├── app/                                 # Core Laravel application logic
│   ├── Console/                         # Artisan commands
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── ResetPasswordController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── PatientController.php
│   │   │   ├── DoctorController.php
│   │   │   ├── AppointmentController.php
│   │   │   ├── RecordController.php
│   │   │   ├── PrescriptionController.php
│   │   │   ├── LabTestController.php
│   │   │   ├── BillingController.php
│   │   │   ├── InsuranceController.php
│   │   │   └── PaymentController.php
│   │   ├── Middleware/
│   │   └── Requests/                   # Form validation requests
│   ├── Models/
│   │   ├── User.php
│   │   ├── Patient.php
│   │   ├── Doctor.php
│   │   ├── Appointment.php
│   │   ├── Record.php
│   │   ├── Prescription.php
│   │   ├── LabTest.php
│   │   ├── Billing.php
│   │   ├── Insurance.php
│   │   └── Payment.php
│   └── Providers/
│
├── routes/
│   ├── web.php                         # Routes for browser views
│   ├── api.php                         # Routes for API (used by frontend or SPA)
│   └── channels.php
│
├── resources/
│   ├── views/                          # Blade templates (admin dashboard, login, etc.)
│   │   ├── layouts/
│   │   ├── auth/
│   │   ├── dashboard/
│   │   ├── patients/
│   │   ├── doctors/
│   │   ├── appointments/
│   │   ├── records/
│   │   ├── prescriptions/
│   │   ├── lab-tests/
│   │   ├── billing/
│   │   ├── insurance/
│   │   ├── profile/
│   │   └── components/
│   └── js/                             # Vue or custom JS modules if using Laravel Mix
│
├── public/
│   ├── assets/                         # Static frontend assets
│   │   ├── css/
│   │   │   ├── main.css
│   │   │   └── modules/
│   │   ├── js/
│   │   │   ├── main.js
│   │   │   ├── api.js
│   │   │   └── modules/
│   │   ├── images/
│   │   └── fonts/
│   ├── uploads/                        # Publicly accessible file uploads
│   └── index.php                       # Laravel entry point
│
├── database/
│   ├── factories/
│   ├── migrations/
│   ├── seeders/
│   └── schema.sql                      # Optional raw SQL export
│
├── storage/
│   ├── logs/
│   ├── framework/
│   └── app/
│
├── tests/
│   ├── Feature/
│   └── Unit/
│
├── .env                                # Environment variables
├── .gitignore
├── artisan                             # Laravel CLI tool
├── composer.json                       # PHP dependencies
├── webpack.mix.js                      # Laravel Mix asset bundler
├── README.md
└── package.json                        # JS frontend dependencies (if using npm/Vite)
