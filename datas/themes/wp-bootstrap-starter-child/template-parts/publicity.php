<?php
$is_pub = (function_exists("eqpubGetPublicity")) ? eqpubGetPublicity() : false;
if ( $is_pub && array_keys( $is_pub, true )) { ?>

	<div id="primary-1" class="content-area col-sm-12 mb-3">
		<article class="eq-pub-desktop">
			<a href="<?php echo $is_pub['link']; ?>" target="_blank" rel="nofollow">
				<?php echo $is_pub['desktop']; ?>
			</a>
		</article>
	</div>
	
<?php }