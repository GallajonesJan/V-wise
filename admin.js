console.log("✅ admin.js loaded!");

document.addEventListener('DOMContentLoaded', function () {
    // Sidebar navigation
    const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
    const contentSections = document.querySelectorAll('.content-section');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');

            // Toggle active class
            sidebarLinks.forEach(navLink => navLink.parentElement.classList.remove('active'));
            this.parentElement.classList.add('active');

            // Toggle visibility of content sections
            contentSections.forEach(section => {
                section.classList.toggle('hidden', section.id !== targetId);
            });
        });
    });

    // Show dashboard on load
    const activeLink = document.querySelector('.sidebar-nav li.active a');
    if (activeLink) activeLink.click();

    // Show/hide password
    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    if (togglePasswordBtn && passwordField) {
        togglePasswordBtn.addEventListener('click', () => {
            const isPassword = passwordField.type === 'password';
            passwordField.type = isPassword ? 'text' : 'password';
            togglePasswordBtn.textContent = isPassword ? 'Hide' : 'Show';
        });
    }

    // Add Student placeholder
    const addStudentBtn = document.getElementById('addStudentBtn');
    if (addStudentBtn) {
        addStudentBtn.addEventListener('click', () => {
            Swal.fire({
                title: 'Add Student',
                text: 'Functionality not yet implemented.',
                icon: 'info',
                confirmButtonColor: '#0b7979'
            });
        });
    }

    // Clear form fields
    const clearFieldsBtn = document.getElementById('clearFieldsBtn');
    const voterForm = document.getElementById('voterForm');
    if (clearFieldsBtn && voterForm) {
        clearFieldsBtn.addEventListener('click', () => voterForm.reset());
    }

    // Handle Excel upload
    const uploadExcelInput = document.getElementById('uploadExcel');
    if (uploadExcelInput) {
        uploadExcelInput.addEventListener('change', () => {
            if (uploadExcelInput.files.length > 0) {
                Swal.fire({
                    title: 'Excel File Selected',
                    text: uploadExcelInput.files[0].name,
                    icon: 'success',
                    confirmButtonColor: '#0b7979'
                });
            }
        });
    }

    // Logout confirmation
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Confirm Logout',
                text: 'Are you sure you want to log out?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0b7979',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, log out'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        });
    }
});
    