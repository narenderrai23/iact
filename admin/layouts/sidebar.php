<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index.php" class="logo logo-dark text-center">
            <span class="logo-sm">
                <img src="../assets/image/logo-lg.png" alt="LOGO" height="22">
            </span>
            <span class="logo-lg">
                <img src="../assets/image/logo-lg.png" alt="LOGO" class="w-50">
            </span>
        </a>

        <a href="index.php" class="logo logo-light text-center">
            <span class="logo-lg">
                <img src="../assets/image/logo-lg.png" alt="LOGO" class="w-50">
            </span>
            <span class="logo-sm">
                <img src="../assets/image/favicon.png" alt="LOGO" height="22">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="index.php">
                        <i class="bx bx-tachometer icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                <li class="menu-title" data-key="t-applications">Applications</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx bx-user icon nav-icon"></i>
                        <span class="menu-item" data-key="t-student">Student</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="add-students.php" data-key="add-students">Add Student</a></li>
                        <li><a href="manage-students.php" data-key="edit-students">Manage Student</a></li>
                        <li><a href="filter-students.php" data-key="students-excel">Excel Student</a></li>
                        <!-- <li><a href="expired-students.php" data-key="students-excel">Duration Expired</a></li> -->
                        <li><a href="student.php" data-key="students-excel">Old Student</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-school icon nav-icon"></i>
                        <span class="menu-item" data-key="t-branch">Branch</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="add-branch.php" data-key="add-branch">Add Branch</a></li>
                        <li><a href="manage-branch.php" data-key="edit-branch">Manage Branch</a></li>
                        <!-- <li><a href="expired-branch.php" data-key="branch">Expired Branch</a></li> -->
                        <li><a href="filter-branch.php" data-key="branch-excel">Branch Excel</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bxs-city icon nav-icon"></i>
                        <span class="menu-item" data-key="t-branch">City</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="add-city.php" data-key="add-city">Add City</a></li>
                        <li><a href="manage-cities.php" data-key="edit-city">Manage City</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-book-open icon nav-icon"></i>
                        <span class="menu-item" data-key="t-course">Course</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="manage-courses.php" data-key="manage-courses">Manage Course</a></li>
                        <li><a href="course-category.php" data-key="add-course-category">Course Category</a></li>
                        <li><a href="add-courses.php" data-key="add-courses">Add courses</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-user-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="t-course">Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="contacts-profile.php" data-key="manage-courses">Contacts Profile</a></li>
                        <li><a href="importer.php" data-key="importer">Importer</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->