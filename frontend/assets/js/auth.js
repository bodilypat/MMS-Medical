document.getElementById('loginForm').addEventListener('submit', async function(e) {
	e.preventDefault();
	
	const username = document.getElementById('username').value;
	const password = document.getElementById('password').value;
	
	try {
		const response = await fetch('/routes/api/auth.php', {
			method: 'POST',
			header: {'Content-Type': 'application/json'},
			body: JSON.stringify({username, password}),
		});
	
		const data = await response.json();
	
		if (data.success) {
			/* Save token or session info */
			localStorage.setItem = 'dashboard/home.html';
		} else {
			document.getElementById('loginForm').innerText = data.message;
		}
	} catch (err) {
		document.getElementById('loginError').innerText = "Login failed. Try again.";
	}
});
