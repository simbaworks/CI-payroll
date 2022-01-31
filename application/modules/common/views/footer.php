                    </div><!-- /.container-fluid -->

                    <!-- Modal -->
                    <div class="modal fade" id="hrmsModal" style="display: none;" aria-hidden="true">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Large Modal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p>One fine body…</p>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer"><?php echo $footer_text;?>
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- Bootstrap 4 -->
        <script src="<?php echo $assets_path; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="<?php echo $js_path; ?>multiple-select.js"></script>
        <!-- SweetAlert2 -->
        <script src="<?php echo $assets_path; ?>plugins/sweetalert2/sweetalert2.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo $js_path; ?>adminlte.js"></script>
        <script src="<?php echo $js_path; ?>bootstrap-toggle.min.js"></script>
        <script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>

        <script type="text/javascript">
          var SITEURL = '<?php echo site_url(); ?>';
          var CONTROLLER = '<?php echo $controller; ?>';
          var METHOD = '<?php echo $method; ?>';

          var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          $('.datepicker').datepicker({
              autoclose: true,
              format: 'dd/mm/yyyy'
          });
          
            $('.multiple-select').multipleSelect('destroy');
            $('.multiple-select').multipleSelect({
                filter: true,
                dropWidth: 580
            });

        </script>
        <script src="<?php echo $js_path; ?>custom.js"></script>
    </body>
</html>
