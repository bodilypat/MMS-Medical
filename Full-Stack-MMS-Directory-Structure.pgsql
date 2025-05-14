Full-Stack-MMS-Directory-Structure/
│
├── Frontend/  
│   │                      	 	
│   ├── public/ 
│   │   │   
│   │   ├── css/
│   │   │   ├── main.css
│   │   │   ├── dashboard.css
│   │   │   └── form.css
│   │   │  
│   │   ├── js/
│   │   │   ├── main.js
│   │   │   ├── auth.js
│   │   │   ├── patients.js 
│   │   │   ├── appointments.js 
│   │   │   └── utils.js
│   │   │  
│   │   └── images/
│   │       ├── logo.png  
│   │       └── icons/                          	 
│   │                     
│   ├── views/ 
│   │   ├── auth/
│   │   │   ├── login.html
│   │   │   ├── register.html
│   │   │   └── reset-password.html
│   │   ├── dashboards/
│   │   │   ├── dashboard.html
│   │   │   ├── patient.html
│   │   │   ├── doctor.html
│   │   │   ├── appointment.html
│   │   │   ├── medical_record.html
│   │   │   └── profile.html
│   │   └── components/
│   │       ├── navbar.html
│   │       ├── sidebar.html
│   │       ├── patient-card.html
│   │       └── appointment-form.html
│   │ 
│	└── index.html
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
│   │   │   └── recordController.php 
│   │   │    
│   │   ├── models/     
│   │   │   ├── User.php
│   │   │   ├── Patient.php
│   │   │   ├── Doctors.php
│   │   │   ├── Appointment.php
│   │   │   └── Record.php
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