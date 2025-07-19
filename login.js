// Function to toggle password visibility
function togglePassword() {
  const passwordInput = document.getElementById('password');
  const eyeIconContainer = document.getElementById('eyeIcon'); // This is the SVG container

  // Define SVG paths for clarity
  const eyeOpenSVG = `
    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="20" fill="none" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" />
      <circle cx="12" cy="12" r="3" />
    </svg>
  `;

  const eyeClosedSVG = `
    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="20" fill="none" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M17.94 17.94A10.95 10.95 0 0 1 12 20c-7 0-11-8-11-8a21.08 21.08 0 0 1 5.05-6.61M1 1l22 22" />
      <path d="M9.53 9.53a3 3 0 0 0 4.24 4.24" />
    </svg>
  `;

  // Toggle the input type and update the icon
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    eyeIconContainer.innerHTML = eyeClosedSVG; // Show the "eye-off" icon
  } else {
    passwordInput.type = 'password';
    eyeIconContainer.innerHTML = eyeOpenSVG; // Show the "eye-on" icon
  }
}