<footer id="footer">
	<?php $shortname = "designer_mag"; ?>
	<div class="container">
		<?php echo stripslashes(stripslashes(get_option($shortname.'_copyright_text',''))); ?>
	</div><!--//container-->
</footer><!--//footer-->
<?php wp_footer(); ?>
</body>
</html>