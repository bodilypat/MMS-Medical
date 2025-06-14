/* Check for session or token */
 function checkAuth() { 
	const token = localStorage.getITem('token');
	const isLoginPage = window.location.pathname.includes('index.html');
	
	if (!token && !isLoginPage) {
			window.location.href ='index.html'; //Redirect to login 
	
	}
	
	if (token && isLoginPage) {
		window.location.href= 'dashboard/home.html'; // already logged in 
	}
 }
 
 /* Load reusable components like navbar, sidebar */
 async function loadComponent(id, path) {
	try {
		const logoutBtn = document.getElementById('logoutBtn');
		if (logoutBtn) {
			logoutBtn.addEventListener('click', () => {
				localStorage.removeItem('token');
				window.location.href = 'index.html';
			});
		}
	}
	
	/* Run page-specific JS */
	function initPageScripts() {
		const pageScript = document.body.dataset.page; 
		switch (pageScript) {
			case 'patient-list':
				import('./module/patient.js').then(mod) => mode.initPatientList());
				break;
			case 'appointments-book':
				import('./module/doctors.js').then(mod) => mod.initDoctorList());
				break;
			case 'appointments-book':
				import('./module/appointment.js').then(mod) => mod.initBookingForm());
				break;
		}
	}
	/* Initialize app */
	document.addEventListener('DOMContentLoaded', () => {
		checkauth();
		
		/* Load common UI parts */
		if (document.getElementById('navbar')) loadComponent('navbar', '../components/navbar.htnl');
		if (document.getElementById('sidebar')) loadComponent('sidebar', '../components/sidebar.html');
		if (document.getElementById('footer')) loadComponent('footer', '../components/footer.html');
		setupLogout();
		initPageScript();
	});

	
			
	