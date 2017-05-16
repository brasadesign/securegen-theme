<div class="col-sm-3 download-info">
	<?php if ( $dlm_download->has_version_number() ) {
		printf( __( 'Version %s', 'download-monitor' ), $dlm_download->get_the_version_number() );
	} ?>
</div>
<div class="col-sm-3 download-info">
	<span class="md5sum">
	<?php $dlm_download->the_title(); 
	?> -  
	<?php echo date_i18n( get_option( 'date_format' ), strtotime( $dlm_download->get_the_file_date() )); 
	?>
	</span>
</div>
<div class="col-sm-3 download-info">
<span class="md5sum"><?php $dlm_download->the_short_description(); ?></span>
</div>
	<a class="col-sm-3 download-button" href="<?php $dlm_download->the_download_link(); ?>" rel="nofollow"><i class="fa fa-download" aria-hidden="true"></i> Download
	</a>
<br />