   
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <script>
    $(document).ready(function() {
        //for add/edit pages
        $('#description,#pmjay_description_box').summernote({
            tabsize: 2,
            height: 100
        });

        //for view pages
        $("#description-show,#pmjay_description_box-show").summernote("disable");

        $('#sidebarToggle').on('click', function () {
            // Retrieve the current value from Local Storage and convert it to an integer
            var sidebarToggle = parseInt(localStorage.getItem('navbarToggle') ?? 0);

            // Toggle the value between 0 and 1
            sidebarToggle = (sidebarToggle === 0) ? 1 : 0;

            // Update the value in Local Storage
            localStorage.setItem('navbarToggle', sidebarToggle);
        });

    });
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="{{ asset('/js/demo/datatables-demo.js') }}"></script> -->

</body>

</html>