<?php include 'layouts/session.php'; ?>
<!doctype html>
<html lang="en">

<head>
    <title>IACT - Admin</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
</head>

<body data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include 'layouts/menu.php'; ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <?php
                    $maintitle = "IACT";
                    $title = 'Dashboard';
                    ?>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Manage Student</h4>
                                    <form id="excelForm" action="../php/helper/excel-export.php" method="post">
                                        <input type="number" name="limit" class="btn btn-sm border-info"
                                            placeholder="Select All Entries">
                                        <button type="submit" name="action" value="excelExport"
                                            class="btn btn-sm btn-info">Excel</button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Enrollment No</th>
                                                <th>Student Name</th>
                                                <th>Father's Name</th>
                                                <th>Course</th>
                                                <th>Admission Date</th>
                                                <th>Approve</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include 'layouts/footer.php'; ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right Sidebar -->
    <a id="right-bar-toggle"></a>

    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- gridjs js -->
    <script src="../assets/js/app.js"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../ajax/js/fetch.js"></script>
    <script src="../ajax/js/extra.js"></script>
    <!-- <script src="../ajax/datatable-student1.js"></script> -->
    <script>
        const action = function (d) {
            d.action = 'fetchStudentsOld';
        };
        // Call the function to initialize DataTable
        var table = initializeDataTable('#datatable', action);
        const deleteText = "You are about to delete the student."
        const successText = "Student Deleted! The student has been successfully deleted."
        deleteItem(table, "oldDeleteStudent", deleteText, successText);

        function initializeDataTable(tableId, action, spacial = null) {
            return $(tableId).DataTable({
                responsive: true,
                dom: "Bfrtip",
                processing: true,
                serverSide: true,
                searching: true,
                bJQueryUI: true,
                pageLength: 50,
                order: [0, "desc"],
                columnDefs: getColumnDefs(),
                buttons: getButtons(),
                ajax: {
                    url: "../php/controller/datatableController.php",
                    type: "POST",
                    data: action,
                    dataSrc: function (response) {
                        console.log(response);
                        return response.data;
                    },
                },
                columns: getColumns(spacial),
                drawCallback: setupDrawCallback,
            });
        }

        function getColumns(spacial) {
            return [
                { data: "id" },
                { render: renderEnrollmentColumn },
                { data: "student_name" },
                { data: "father_name" },
                { data: "course_code" },
                { render: renderDateAdmissionColumn },
                { render: renderApprovalColumn },
                { render: renderButtonGroupColumn },
            ];
        }

        function getColumnDefs() {
            return [
                { targets: [6, 7], orderable: false },
            ];
        }

        function renderButtonGroupColumn(data, type, row) {
            return `<div class="btn-group btn-group-sm">
            <a class="btn btn-sm btn-info" href="details-students.php?id=${row.id}">
                <i class="font-size-10 fas fa-eye"></i>
            </a>
          </div>`;
        }

        function setupDrawCallback(settings) {
            const classes = {
                complete: "btn-soft-success w-100 pe-3 text-start",
                running: "btn-soft-info w-100 pe-3 text-start",
                dropout: "btn-soft-danger w-100 pe-3 text-start",
            };

            initializeCustomSelect2(".select2", classes);

            $(".approve").click(function () {
                processApproval($(this));
            });

            $(".student_status").on("change", function () {
                const id = $(this).data("id");
                const value = $(this).val();
                const classes = {
                    complete: "text-success",
                    running: "text-info",
                    dropout: "text-danger",
                };
                console.log(id);

                var currentClasses = Object.values(classes).join(" ");
                if ($(this).hasClass(currentClasses)) {
                    $(this).removeClass(currentClasses);
                }
                var newClass = classes[value];
                if (newClass) {
                    $(this).addClass(newClass);
                    $(this).children().prop("disabled", false);
                    $(this).find(":selected").prop("disabled", true);
                }
                const data = {
                    id: id,
                    status: value,
                    action: "oldApproveStatusUpdate",
                };

                const success = function (response) {
                    console.log(response);
                    if (response.status === true) {
                        const classes = {
                            complete: " bg-success text-light",
                            running: " bg-info text-light",
                            dropout: " bg-danger text-light",
                        };
                        const currentClasses = classes[response.color] ?? "success";
                        alertify.set("notifier", "position", "top-right");
                        alertify.notify(response.message, currentClasses, 3);
                    }
                };
                const url = "../php/controller/studentController.php";
                performAjaxRequest(url, data, success);
            });
        }

        function processApproval($element) {
            const itemId = $element.data("id");
            const data = {
                itemId: itemId,
                action: "oldApproveStatusUpdate",
            };

            Swal.fire({
                title: "Processing: Please Approve Student",
                html: '<button class="btn btn-sm btn-success">This process is in progress.</button>',
                didOpen: function () {
                    Swal.showLoading();
                    timerInterval = setInterval(function () {
                        var content = Swal.getHtmlContainer();
                        if (content) {
                            var b = content.querySelector("b");
                            if (b) {
                                b.textContent = Swal.getTimerLeft();
                            }
                        }
                    }, 100);
                },
            });

            const success = function (response) {
                Swal.close();
                console.log(response);
                if (response.status === "success") {
                    $("#row" + itemId).text(response.enrollment);
                    const $icon = $element.find("i");
                    $element.removeClass("bg-danger").addClass("bg-success");
                    $icon.removeClass("bx-x").addClass("bx-badge-check");
                } else {
                    // alert(response.message);
                }
            };

            const url = "../php/controller/studentController.php";
            performAjaxRequest(url, data, success);
        }

    </script>

</body>

</html>