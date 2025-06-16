Full-Stack-MMS-Directory-Structure(no framework)/
│
├── frontend/                         # Front-end static app       
│   ├── public                        # Static entry point for deployment  
│   │   └── index.html                # Entry login/landing page
│   ├── pages/                        # Pages routed via hash or history 
│   │   ├── dasdboard/                # Dashboard & layout-specific views    
│   │   │   ├── home.html                    
│   │   │   └── overview.html    
│   │   └── modules/  
│   │ 		├── patients/
│   │   	│   ├── list.html                    
│   │  		│   ├── add.html                     
│   │   	│   ├── view.html                    
│   │   	│   └── edit.html 
│   │   	├── doctors/
│   │   	│   ├── list.html                    
│   │   	│   ├── add.html                     
│   │   	│   ├── profile.html                    
│   │   	│   └── schedule.html  
│   │   	├── appointments/                
│   │   	│   ├── list.html                     
│   │   	│   ├── book.html                    
│   │   	│   └── calendor.html      
│   │   	├── prescriptions/
│   │   	│   ├── list.html                                 
│   │   	│   └── add.html 
│   │   	├── lab-tests/
│   │   	│   ├── list.html                                
│   │   	│   └── results.html     
│   │   	├── payments/
│   │   	│   ├── invoices.html                                   
│   │   	│   └── receipt.html          
│   │   	├── insurance/
│   │   	│   ├── polices.html                                      
│   │   	│   └── claim.html  
│   │   	├── pharmacies/
│   │   	│   ├── list.html                                    
│   │   	│   └── orders.html  
│   │   	└── reports/ 
│   │       	├── summary.html                   
│   │       	└── charts.html                
│   ├── components/							# Reusable UI parts
│   │   ├── layout/  
│   │   │   ├── navbar.html 
│   │   │   ├── sidebar.html 
│   │   │   └── footer.html            
│   │   └── modals/ 
│   │       └── confirm-delete.html
│   ├── assets/                              
│   │   ├── css/
│   │   │   ├── main.css                    # Global styles
│   │   │   ├── layout.css                  # Layout-specific styles 
│   │   │   └── module/                     # Module-specific styles 
│   │   │       ├── patients.css
│   │   │       ├── doctors.css
│   │   │       └── appointments.css
│   │   │ 
│   │   ├── js/
│   │   │   ├── main.js                      # Bootstrap/init script
│   │   │   ├── auth.js                      # Auth logic
│   │   │   ├── api.js                       # API service (XHR/fetch)
│   │   │   └── module/                      # Module-specific JS
│   │   │       ├── patients.js
│   │   │       ├── doctors.js
│   │   │       └── appointments.js
│   │   └── images/
│   │       └── Logo.png
│   │ 
│   │ 
│   ├── utils/                               # Utility scripts/helpers
│   │   ├── form-validation.js
│   │   └── date-utils.js 
│   ├── store/                               # (optional) Shared data/state (local/session/user)
│   │   └── session.js 
│   │ 
│   ├── README.md 
│   └── LICENSE                    
│
├── backend/
│   ├── public/                              
│   │   ├── index.php                        
│   │   ├── assets/                          
│   │   └── uploads/     
│   │                                        
│   ├── config/                              
│   │   ├── database.php
│   │   ├── constants.php
│   │   └── env.php
│   │ 
│   ├── routes/                              
│   │   ├── api/
│   │   │   ├── auth.php
│   │   │   ├── patients.php
│   │   │   ├── doctors.php
│   │   │   ├── appointments.php
│   │   │   └── reports.php
│   │   └── web.php
│   │
│   ├── app/                         
│   │   ├── controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── PatientController.php
│   │   │   ├── DoctorController.php
│   │   │   ├── Appointments.php
│   │   │   ├── PrescriptionController.php
│   │   │   ├── MedicalRecordController.php
│   │   │   ├── LabTestController.php
│   │   │   ├── BillingControllers.php
│   │   │   ├── InsuranceController.php
│   │   │   └── reportController.php
│   │   ├── Models/
│   │   │   ├── User.php
│   │   │   ├── Patient.php
│   │   │   ├── Doctor.php
│   │   │   ├── Appointment.php
│   │   │   ├── Prescription.php
│   │   │   ├── LabTest.php
│   │   │   ├── Billing.php
│   │   │   ├── Insurance.php
│   │   │   └── Payment.php
│   │	├── Services/                               
│   │	│   ├── AppointmentService.php
│   │	│   ├── ReportService.php
│   │	│   └── NotificationService.php
│   │	│ 
│   │   ├── middleware/      
│   │   │   ├── AuthMiddleware.php                     
│   │   │   └── RoleMiddleware.php
│   │   │ 
│   │   ├── Repositories/
│   │   │   ├── PatientRepository              
│   │   │   └── ReportService.php
│   │   │ 
│   │   ├── helpers/                              
│   │   │   ├── auth.php
│   │   │   ├── response.php
│   │   │   ├── validator.php
│   │   │   └── logger.php
│   │   │
│   │   └── Validators/ 
│   │       ├── PatientTest.php                        
│   │       └── AuthTest.php   
│   ├── storage/    
│   │   ├── database.php
│   │   │   └── error.log
│   │   ├── temp/
│   │   └── exports/   
│   ├── database/                              
│   │   ├── migrations/
│   │   ├── seeders/
│   │   └── backups/ 
│   └── test/  
│   	├── unit/
│       │   ├── PatientTest.php
│       │   └── AuthTest.php
│   	├── Integration/
│       │   └── AppointmentFlowTest.php
│       └── README.md    
│
├── .env                                      
├── .htaccess                                 
├── composer.json                             
└── README.md
