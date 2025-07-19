<?php
session_start(); // Always start the session at the very beginning

// Initialize error message variable
$error_message = "";

// --- Handle POST Request (Login Attempt) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Include your database connection file
    require 'db.php'; // Ensure db.php has no output, just the connection code

    $username = trim($_POST['student_number']);
    $password = trim($_POST['password']);

    // Admin login
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['user'] = 'admin';
        $_SESSION['role'] = 'admin';
        header('Location: admin.php');
        exit;
    }

    // Student login
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $student = $result->fetch_assoc();

        // Verify password using password_verify
        if (password_verify($password, $student['password'])) {
            $_SESSION['user'] = $student['student_id'];
            $_SESSION['role'] = 'student';
            header('Location: student.html'); // Redirect to student dashboard
            exit;
        }
    }

    // If login failed (neither admin nor student matched, or password incorrect)
    // Redirect back to login.php with an error flag in the URL
    header('Location: login.php?login_error=1');
    exit;
}

// --- Handle GET Request (Page Load) ---
// This part executes when the page is accessed directly or via a redirect (GET request)

// If the page was redirected here after a failed login attempt
if (isset($_GET['login_error']) && $_GET['login_error'] == 1) {
    $error_message = "Incorrect Student Number or Password.";
}

// Ensure no other session errors are lingering (good practice)
if (isset($_SESSION['login_error'])) {
    unset($_SESSION['login_error']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>V-Wise Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="Assets/logo.png" type="image/png" />
  <script>
    function togglePassword() {
      const pwd = document.getElementById('password');
      const eye = document.getElementById('eyeIcon');
      // Define these SVGs in your JS or ensure they are accessible
      const eyeOpen = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>`;
      const eyeClosed = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.168-3.263M6.6 6.6A9.987 9.987 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.032 5.045M15 12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m6 0a3 3 0 01-6 0" /><path d="M3 3l18 18" /></svg>`;

      if (pwd.type === 'password') {
        pwd.type = 'text';
        eye.innerHTML = eyeOpen;
      } else {
        pwd.type = 'password';
        eye.innerHTML = eyeClosed;
      }
    }
  </script>
</head>
<body class="bg-teal-50 flex items-center justify-center min-h-screen font-sans">
  <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
    <div class="text-center mb-6">
      <img src="Assets/v-wise.png" alt="V-Wise Logo" class="mx-auto h-20 mb-3">
      <h2 class="text-2xl font-bold text-gray-700">Sign in to V-Wise</h2>
    </div>

    <?php if (!empty($error_message)): // Display error if $error_message is not empty ?>
      <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4 text-sm">
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>

    <form method="post" action="login.php" class="space-y-5">
      <div>
        <label for="student_number" class="block mb-1 font-medium text-gray-600">Student Number / Admin</label>
        <input type="text" name="student_number" id="student_number" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-400">
      </div>

      <div>
        <label for="password" class="block mb-1 font-medium text-gray-600">Password</label>
        <div class="relative">
          <input type="password" name="password" id="password" required
                         class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-400">
          <button type="button" onclick="togglePassword()" class="absolute right-3 top-2.5" id="eyeIcon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>
      </div>

      <button type="submit"
              class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 rounded-md transition duration-200">
        Sign in
      </button>
    </form>
  </div>
</body>
</html>