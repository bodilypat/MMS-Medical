Full-Stack-MMS-Directory-Structure/
│
├── Frontend/                      	 	
│   ├── index.html     
│   ├── login.html  
│   ├── register.html                     	 
│   │                     
│   ├── pages/ 
│   │   ├── dashboard.html
│   │   ├── patient.html
│   │   ├── doctors.html
│   │   ├── appointment.html
│   │   ├── medical_record.html
│   │   └── profile.html
│   │ 
│   ├── components/ 
│   │   ├── navbar.html
│   │   ├── sidebar.html
│   │   ├── patient-card.html
│   │   └── appointment-form.html
│   │                                                  
│   │
│   ├── assets/                                 
│   │   ├── css/
│   │   │   ├── style.css
│   │   │   ├── dashboard.css
│   │   │   └── form.css
│   │   │
│   │   ├── js/
│   │   │   ├── auth.js    
│   │   │   ├── main.js 
│   │   │   ├── appointments.js 
│   │   │   ├── patients.js                      
│   │   │   └── utils.js                    
│   │   │
│   │   └── images/  
│   │       ├── logo.png                          
│   │       └── icon
│   │                         
├── backend/ 
│   │
│   ├── api/                                          # API endpoint for AJAX/front-end calls
│   │   ├── auth/
│   │   │   ├── login.php   
│   │   │   ├── register.php  
│   │   │   └── resetPassword.php         
│	│   │
│   │   ├── Patients/                   			 
│   │   │   ├── get-all.php  
│   │   │   ├── create.php    
│   │   │   └── profile.php                           	
│   │   │
│   │   ├── Doctors/                          
│   │   │   ├── get-all.php  
│   │   │   └── profile.php   
│   │   │       
│   │   ├── Appointments/                          
│   │   │   ├── create.php  
│   │   │   └── get-by-date.php 
│   │   │
│   │   └── medical_records/  
│   │       ├── upload.php                          
│   │       └── get.php
│   │   
├── app/                                        # Core application logic
│	├── controllers/ 
│   │   ├── AuthController.php
│   │   ├── PatientController.php
│   │   ├── DoctorController.php
│	│	├── AppointmentControlle.php
│	│	└── RecordController.php 
│	│	
│	├── models/                                
│	│   ├── User.php
│	│   ├── Patient.php
│	│   ├── Doctor.php
│	│   ├── Appointment.php
│	│	└── MedicalRecord.php 
│	│	
│	└── helpers/                               
│	    ├── Auth.php
│	    ├── Validator.php
│	    ├── Response.php
│	 	└── Logger.php                         
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