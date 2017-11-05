<li class="search-box">
	<form class="sidebar-search" method="GET">
		<?php if (isset($cefaIdFilter)): ?>
			<input type="hidden" class="form-control" name="cefaId" value="<?php echo $cefaIdFilter; ?>">
		<?php endif; ?>

		<div class="form-group">
			<input type="text" name="t" placeholder="<?php echo __('Buscar...'); ?>">
			<button class="submit">
				<i class="clip-search-3"></i>
			</button>
		</div>
	</form>
</li>