/* Handle Login Form submission */
document.addEventListener('DOMContentLoaded', () => {
	const loginForm = document.getElementById('loginForm');
	
	if (loginForm) {
		loginForm.addEventListener('submit', async (e) => {
			e.preventDefault();
			
			const username = document.getElementById('username').value.trim();
			const password = document.getElementById('password').value;
			
			if (!username || !password) {
				showError('Please enter both username and password.');
				return;
			}
			try {
				const response = await fetch('/routes/api/auth.php', {
					method: 'POST',
					headers: {'Content-Type': 'application/json' },
					body: JSON.stringify({ username, password })
				});
				
				const data = await response.json();
				
				if (data.success) {
					/* Save token (or session id) to localStorage */
					localStorage.setItem('token', data.token || '');
					window.location.href = 'dashboard/home.html.');
				} else {
					showError(data.message || 'Login failed.');
				}
			} catch (err) {
				console.error('Logic error: ', err);
				showError("Something went wrong. Please try again.");
			}
		});
	}
});

function logoutUser() {
	localStorage.removeItem('toke');
	/* LocalStorage.removeItem('user'); */
	window.location.href = 'index.html';
}

/* Utility function to show error */
function showError(msg) {
	const errorElem = document.getElementById('loginError');
	if (errorElem) {
		errorElem.innerText = msg;
		errorElem.style.display = 'block';
	}
}


