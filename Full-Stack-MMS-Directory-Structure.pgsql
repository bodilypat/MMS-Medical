Full-Stack-MMS-Directory-Structure/
│
├── Frontend/  
│   │                      	 	
│   ├── public/ 
│   ├── pages/
│   │   ├── auth/
│   │   │   ├── login.html 
│   │   │   └── register.html
│   │   │   
│   │   ├── dashboard/
│   │   │   ├── admin.html                 #Key Pages Used
│   │   │   ├── doctor.html
│   │   │   └── patient.html
│   │   │  
│   │   ├── patients/
│   │   │   ├── patient-list.html
│   │   │   ├── patient-profile.html
│   │   │   └── patient-edit.html
│   │   │  
│   │   ├── doctors/
│   │   │   ├── doctor-list.html
│   │   │   ├── doctor-profile.html
│   │   │   └── doctor-schedule.html
│   │   │  
│   │   ├── appointments/
│   │   │   ├── appointment-list.html
│   │   │   └── appointment-form.html
│   │   │  
│   │   ├── records/
│   │   │   ├── medical-records.html
│   │   │   └── record-detail.html
│   │   │  
│   │   ├── prescriptions/
│   │   │   └── prescription-list.html
│   │   │  
│   │   ├── lab-tests/
│   │   │   └── lab-tests.html
│   │   │  
│   │   ├── billing/
│   │   │   ├── payments.html
│   │   │   └── invoice-detail.html
│   │   │  
│   │   ├── insurance/
│   │   │   └── pharmacy-directory.html
│   │   │  
│   │   └── profile/
│   │       ├── profile.html  
│   │       └── settings.html                          	 
│   │                     
│   ├── assets/ 
│   │   ├── css/
│   │   │   ├── main.css
│   │   │   └── modules/
│   │   │   	├── auth.css
│   │   │   	├── dashboard.css
│   │   │   	├── forms.css
│   │   │       ├── tables.css
│   │   │       └── modal.css    
│   │   ├── js/
│   │   │   ├── main.js
│   │   │   ├── auth.js
│   │   │   ├── api.js
│   │   │   └── modules/
│   │   │       ├── patient.js
│   │   │   	├── doctors.js
│   │   │  	    ├── appointments.js
│   │   │   	├── records.js
│   │   │   	├── priscriptions.js
│   │   │   	├── lab_tests.js
│   │   │   	├── pharmacy.js 
│   │   │   	├── insurance.js 
│   │   │       └── payments.js.css   
│   │   │  
│   │   ├── images/ 
│   │   └── fonts/
│   │       ├── navbar.html
│   │       ├── sidebar.html
│   │       ├── patient-card.html
│   │       └── appointment-form.html
│   │ 
│   ├── components/ 
│   │   ├── header.html
│   │   ├── footer.html
│   │   ├── sidebar.html
│   │   ├── navbar.html
│   │   └── modal.html
│   ├── data/
│   │   ├── patients.json
│   │   ├── doctors.json
│   │   └── appointments.json
│   │   
│   ├── uploads/
│   ├── .gitignore
│	└── package.json
│	                   
├── backend/ 
│   │
│   ├── api/                                          # API endpoint for AJAX/front-end calls
│   │   ├── auth/
│   │   │   ├── login.php   
│   │   │   ├── register.php  
│   │   │   └── reset-password.php         
│   │   │
│   │   ├── patients/                   			 
│   │   │   ├── get-all.php  
│   │   │   ├── create.php    
│   │   │   └── profile.php                           	
│   │   │
│   │   ├── doctors/                          
│   │   │   ├── get-all.php  
│   │   │   └── profile.php   
│   │   │       
│   │   ├── Appointments/                          
│   │   │   ├── create.php  
│   │   │   └── get-by-date.php 
│   │   │
│   │   ├── medical-records/                          
│   │   │   ├── upload.php  
│   │   │   └── get.php 
│   │   │                     
│   │   ├── controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── PatientController.php      
│   │   │   ├── DoctorController.php  
│   │   │   ├── AppointmentController.php
│   │   │   ├── RecordController.php
│   │   │   ├── PrescriptionController.php
│   │   │   ├── LabController.php
│   │   │   ├── BillingController.php
│   │   │   ├── InsuranceController.php
│   │   │   └── PaymentController.php 
│   │   │    
│   │   ├── models/     
│   │   │   ├── User.php
│   │   │   ├── Patient.php
│   │   │   ├── Doctors.php
│   │   │   ├── Appointment.php
│   │   │   ├── Records.php
│   │   │   ├── prescription.php
│   │   │   ├── Labs.php
│   │   │   ├── Billing.php
│   │   │   ├── Insurance.php
│   │   │   └── Payment.php
│   │   │    
│	└── helpers/                               
│	    ├── Auth.php
│	    ├── Validator.php
│	    ├── Response.php
│	 	└── logger.php                     
│	
├── config/
│	├── config.php                              
│	└── database.php                            
│                           
├── uploads/
├── logs/
├── vendor/
├── composer.json
├── .env
│	
└── README.md  