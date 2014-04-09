<?php 
$menu_row = $musuarios->traerMenu();
?>

<div class="navbar skin-3">
	<script type="text/javascript">
		try{ace.settings.check('navbar' , 'fixed')}catch(e){}
	</script>
	<div class="">
		<ul class="nav ace-nav pull-left">
			<li class="text-danger bolder">&nbsp;&nbsp;&nbsp;¡Hola <?php echo $_SESSION['casicoin_nom'] ?>!, Bienvenid@</li>
		</ul>
		<ul class="nav ace-nav pull-right">
			<?php foreach($menu_row as $mr) { ?>				
				<?php $submenu_row = $musuarios->traerSubmenu($mr->moide) ?>
				<?php if(count($submenu_row)==1) { ?>
					<li class="grey bolder">
						<a href="?var=<?php echo $submenu_row[0]->suvariab ?>">
							<i class="fa <?php echo $submenu_row[0]->suicono ?>"></i> <?php echo $submenu_row[0]->sudescri ?>
						</a>
					</li>
				<?php } else { ?>
						<li class="grey bolder">
							<a href="" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-wrench"></i> <?php echo $mr->modescri ?>
								<i class="icon-caret-down"></i>
							</a>
							<ul class="user-menu pull-right dropdown-menu dropdown-grey dropdown-caret dropdown-close">
								<?php foreach($submenu_row as $sr) { ?>
									<li>
										<a href="?var=<?php echo $sr->suvariab ?>">
											<i class="fa <?php echo $sr->suicono ?>"></i>
											<?php echo $sr->sudescri ?>
										</a>
									</li>
								<?php } ?>
								<li class="divider"></li>
								<li>
									<a href="salir">
										<i class="fa fa-sign-out"></i> 
										Cerrar Sesión
									</a>
								</li>
							</ul>
						</li>
				<?php } ?>
			<?php } ?>		
			<li class="grey bolder">
				<a href="salir">
					<i class="fa fa-sign-out"></i> Salir
				</a>
			</li>
		</ul>
	</div>
</div>
