<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admin.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="wrapper">

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <i class="fas fa-vote-yea"></i> V-Wise
    </div>

    <div class="admin-profile">
      <i class="fas fa-user-shield"></i> Admin
    </div>

    <div class="nav-section">Navigation</div>
    <nav class="sidebar-nav">
      <ul>
        <li class="active"><a href="#" data-target="dashboard-content">Dashboard</a></li>
        <li><a href="#" data-target="voters-content">Voter Management</a></li>
        <li><a href="#" data-target="voting-status-content">Voting Status</a></li>
        <li><a href="#" data-target="manage-candidates-content">Manage Candidates</a></li>
        <li><a href="#" data-target="manage-parties-content">Manage Parties</a></li>
      </ul>
    </nav>

<a href="logout.php" class="logout-btn" id="logoutBtn">Logout</a>

  </aside>
<!-- Dashboard Section -->
<section id="dashboard-content" class="content-section">
  <section class="content-header">
    <div class="breadcrumb"><i class="fas fa-home"></i> Home > Dashboard</div>
  </section>
  <p>Welcome to the admin dashboard.</p>
</section>
  <!-- Navbar -->
<header class="navbar">
  <h2 class="navbar-title">Dashboard</h2>
  <div class="user-info">
    <img src="Assets/user.png" class="user-avatar" alt="Admin Avatar">
    Admin User
  </div>
</header>


  <!-- Main Content -->
  <main class="main-content">




    <!-- Voter Management Section -->
    <section id="voters-content" class="content-section hidden">
      <section class="content-header">
        <h2>Voter Management</h2>
      </section>

      <!-- Voter Form -->
      <div class="voter-form-section">
        <h3>Voter Account Management</h3>
        <form class="voter-form" id="voterForm">
          <div class="form-columns">

            <!-- Left Column -->
            <div class="form-column">
              <div class="form-group">
                <label for="studentId">Student ID</label>
                <input type="text" id="studentId" name="studentId">
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name">
              </div>
              <div class="form-group password-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <button type="button" id="togglePassword">Show</button>
              </div>
            </div>

            <!-- Right Column -->
            <div class="form-column">
              <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender">
                  <option>Select Gender</option>
                  <option>Male</option>
                  <option>Female</option>
                </select>
              </div>
              <div class="form-group">
                <label for="department">Department</label>
                <select id="department" name="department">
                  <option>No Departments</option>
                </select>
              </div>
              <div class="form-group">
                <label for="yearLevel">Year Level</label>
                <select id="yearLevel" name="yearLevel">
                  <option>No Year Levels</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Form Buttons -->
          <div class="form-buttons">
            <button type="button" id="addStudentBtn">Add Student</button>
            <button type="button" id="clearFieldsBtn">Clear Fields</button>
            <a href="templates/student_template.xlsx" class="action-btn" download>Download Template</a>
            <a href="export.php" class="action-btn">Export Students</a>
            <label class="action-btn upload-label">
              Upload Excel
              <input type="file" id="uploadExcel" name="excelFile" accept=".xlsx">
            </label>
          </div>
        </form>
      </div>

      <!-- Voter Table -->
      <div class="voter-tree-section">
        <h3>Registered Students</h3>
        <table id="studentTable">
          <thead>
            <tr>
              <th>Student ID</th>
              <th>Name</th>
              <th>Gender</th>
              <th>Department</th>
              <th>Year Level</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Rows will be dynamically populated -->
          </tbody>
        </table>
      </div>
    </section>

  <!-- Voting Status Section -->
<section id="voting-status-content" class="content-section hidden">
  <section class="content-header">
    <h2>Voting Status</h2>
  </section>
  <p>Display real-time voting progress or status here.</p>
</section>

<!-- Manage Candidates Section -->
<section id="manage-candidates-content" class="content-section hidden">
  <section class="content-header">
    <h2>Manage Candidates</h2>
  </section>
  <p>Add/edit/delete candidates here.</p>
</section>

<!-- Manage Parties Section -->
<section id="manage-parties-content" class="content-section hidden">
  <section class="content-header">
    <h2>Manage Parties</h2>
  </section>
  <p>Add/edit/delete political parties here.</p>
</section>

<!-- Add Department and Year Level Modals -->
<section id= "manage-departments-content" class="content-section hidden">
  <section class="content-header">
    <h2>Manage Departments and Year Levels</h2>
  </section>
</section>
  </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="admin.js"></script>

</body>
</html>
