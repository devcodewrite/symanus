</div>

<!-- SIDE-BAR -->
<div class="sidebar sidebar-right sidebar-animate">
	<div class="p-4 border-bottom">
		<span class="fs-17">Profile Settings</span>
		<a href="#" class="sidebar-icon text-right float-right" data-toggle="sidebar-right" data-target=".sidebar-right"><i class="fe fe-x"></i></a>
	</div>
	<div class="card-body p-0">
		<div class="header-user text-center mt-4 pb-4">
			<span class="avatar avatar-xxl brround"><img src="<?= $this->auth->getAvatar(); ?>" alt="Profile-img" class="avatar avatar-xxl brround"></span>
			<div class="dropdown-item text-center font-weight-semibold user h3 mb-0 p-0 mt-3"><?= $this->auth->getUserFullName(); ?></div>
			<small><?= $this->auth->getUserType(); ?></small>
			<div class="card-body">

			</div>
		</div>
		<a class="dropdown-item  border-top" href="https://codewrite.org">
			<i class="dropdown-icon mdi mdi-account-outline "></i> Codewrite technology Ltd
		</a>
		<div class="card-body border-top">
			<div class="row">
				<div class="col-4 text-center">
					<a class="" href="<? site_url('notices'); ?>"><i class="dropdown-icon mdi  mdi-message-outline fs-30 m-0 leading-tight"></i></a>
					<div>Notices</div>
				</div>
				<div class="col-4 text-center">
					<a class="" href="<?= site_url('account/profile'); ?>"><i class="dropdown-icon mdi mdi-tune fs-30 m-0 leading-tight"></i></a>
					<div>Profile</div>
				</div>
				<div class="col-4 text-center">
					<a class="" href="<?= site_url('logout'); ?>"><i class="dropdown-icon mdi mdi-logout-variant fs-30 m-0 leading-tight"></i></a>
					<div>Sign out</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- SIDE-BAR CLOSED -->

<!-- FOOTER -->
<footer class="footer">
	<div class="container">
		<div class="row align-items-center flex-row-reverse">
			<div class="col-md-12 col-sm-12 text-center">
				Copyright © <?= date('Y'); ?> <a href="#">Symanus</a>. Designed by <a href="https://www.codewrite.org" target="_blank"> Codewrite Technology Ltd. </a> All rights reserved.
			</div>
		</div>
	</div>
</footer>
<!-- FOOTER END -->
</div>

<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

<!-- JQUERY JS -->
<script src="<?= base_url(); ?>assets/js/jquery-3.5.1.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="<?= base_url(); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Moment js-->
<script src="<?= base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- DATA TABLE JS-->
<script src="<?= base_url(); ?>assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatable/datatable.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatable/datatable-2.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatable/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<!-- SIDE-MENU JS-->
<script src="<?= base_url(); ?>assets/plugins/sidemenu/sidemenu.js"></script>

<!-- SELECT2 JS -->
<script src="<?= base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- SUMMERNOTE JS -->
<script src="<?= base_url(); ?>assets/plugins/summernote/summernote-bs4.js"></script>
<!-- FORMEDITOR JS -->
<script src="<?= base_url(); ?>assets/js/summernote.js"></script>

<script type="text/javascript" src="<?= base_url('assets/js/bootstrap-multiselect.js'); ?>"></script>
<!-- DATEPICKER JS -->
<script src="<?= base_url(); ?>assets/plugins/date-picker/jquery-ui.js"></script>
<script src="<?= base_url(); ?>assets/plugins/input-mask/jquery.maskedinput.js"></script>
<!-- SIDEBAR JS -->
<script src="<?= base_url(); ?>assets/plugins/sidebar/sidebar.js"></script>
<!-- SWEET ALERT JS -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#blah').attr('src', e.target.result).width(200).height(200);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>

<!-- CUSTOM JS -->
<script src="<?= base_url(); ?>assets/js/custom.js"></script>
<?php $this->load->view('scripts/select2_search') ?>
<?php 
	$this->load->view('scripts/datatable_ajax');
?>

<?php if ($this->auth->checkControllerAuthorization('settings')) { ?>
	<script src="<?= base_url(); ?>assets/js/bootstrap-editable.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/bootstrap-tagsinput.min.js"></script>
<?php
	$this->load->view('scripts/editable');
} ?>
</body>

</html>