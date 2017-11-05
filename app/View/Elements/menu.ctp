
<div class="navbar-content">
	<!-- start: SIDEBAR -->
	<div class="main-navigation navbar-collapse collapse">
		<!-- start: MAIN MENU TOGGLER BUTTON -->
		<div class="navigation-toggler">
			<i class="clip-chevron-left"></i>
			<i class="clip-chevron-right"></i>
		</div>
		<!-- end: MAIN MENU TOGGLER BUTTON -->
		<!-- start: MAIN NAVIGATION MENU -->

		<?php if ($perf_id == 1) : ?>
			<ul class="main-navigation-menu">
				<li>
					<a href="javascript:void(0)"><i class="clip-user-2"></i>
						<span class="title"><?php echo __('Ficha'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^personas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Personas').'</span>', array('controller' => 'personas', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Familias').'</span>', array('controller' => 'familias', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-location"></i>
						<span class="title"><?php echo __('Actividades'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Actividades').'</span>', array('controller' => 'actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^personas_actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Inscripciones').'</span>', array('controller' => 'personas_actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^sesiones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Sesiones').'</span>', array('controller' => 'sesiones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-pencil"></i>
						<span class="title"><?php echo __('Evaluaciones'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^evaluaciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Evaluaciones').'</span>', array('controller' => 'evaluaciones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^planes_trabajos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Plan de Acompañamiento').'</span>', array('controller' => 'planes_trabajos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-grid-6"></i>
						<span class="title"><?php echo __('Reportes'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^reportes\/coberturas_personas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Cobertura de Personas').'</span>', array('controller' => 'reportes', 'action' => 'coberturas_personas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/actividades/", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Actividades').'</span>', array('controller' => 'reportes', 'action' => 'actividades'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/coberturas_personas_areas_tipos_actividad\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Coberturas por Area, Tipo de Actividad').'</span>', array('controller' => 'reportes', 'action' => 'coberturas_personas_areas_tipos_actividad'), array('escape' => false)); ?>
						</li>			
						<li<?php echo preg_match("/^reportes\/actividades_individuales_masivas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Reporte actividades individuales/masivas').'</span>', array('controller' => 'reportes', 'action' => 'actividades_individuales_masivas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/actividades_masivas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Reporte actividades masivas').'</span>', array('controller' => 'reportes', 'action' => 'actividades_masivas'), array('escape' => false)); ?>
						</li>
						<!--
						<li<?php echo preg_match("/^reportes\/prestaciones_generales\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Reporte de Prestaciones').'</span>', array('controller' => 'reportes', 'action' => 'prestaciones_generales'), array('escape' => false)); ?>
						</li>
						-->
						<li<?php echo preg_match("/^reportes\/prestaciones_areas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Prestaciones por Areas').'</span>', array('controller' => 'reportes', 'action' => 'prestaciones_areas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/prestaciones_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Detalles Prestaciones por Usuario').'</span>', array('controller' => 'reportes', 'action' => 'prestaciones_II'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/participantes_I\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Detalle Actividades por Participante').'</span>', array('controller' => 'reportes', 'action' => 'participantes_I'), array('escape' => false)); ?>
						</li>
						<!--
						<li<?php echo preg_match("/^reportes\/participantes_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Participantes II').'</span>', array('controller' => 'reportes', 'action' => 'participantes_II'), array('escape' => false)); ?>
						</li>
						-->
						<li<?php echo preg_match("/^reportes\/sesiones_ejecutadas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Sesiones Ejecutadas').'</span>', array('controller' => 'reportes', 'action' => 'sesiones_ejecutadas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/consulta_hh\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Consulta HH').'</span>', array('controller' => 'reportes', 'action' => 'consulta_hh'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/redes_I\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Redes I').'</span>', array('controller' => 'reportes', 'action' => 'redes_I'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/redes_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Redes II').'</span>', array('controller' => 'reportes', 'action' => 'redes_II'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/instituciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Instituciones').'</span>', array('controller' => 'reportes', 'action' => 'instituciones'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/cantidad_fichas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Cantidad de Fichas').'</span>', array('controller' => 'reportes', 'action' => 'cantidad_fichas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/tipos_familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Familia').'</span>', array('controller' => 'reportes', 'action' => 'tipos_familias'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/relacion_familia\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Otros tipos de Familia').'</span>', array('controller' => 'reportes', 'action' => 'relacion_familia'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/relacion_ficha\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Relación Ficha/Grupo Objetivo').'</span>', array('controller' => 'reportes', 'action' => 'relacion_ficha'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_diagnostica\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Evaluación Diagnóstica').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_diagnostica'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_final\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Evaluación Final').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_final'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/factores_riesgos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Factores Riesgos').'</span>', array('controller' => 'reportes', 'action' => 'factores_riesgos'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Evaluación Factores Protectores').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_factores_protectores'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/fuentes_financiamientos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Fuentes de Financiamiento').'</span>', array('controller' => 'reportes', 'action' => 'fuentes_financiamientos'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/acumulado\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultado Acumulado').'</span>', array('controller' => 'reportes', 'action' => 'acumulado'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/consolidado\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultado Consolidado').'</span>', array('controller' => 'reportes', 'action' => 'consolidado'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/planes_trabajos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Planes de Trabajos').'</span>', array('controller' => 'reportes', 'action' => 'planes_trabajos'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/actividades_fuentes_financiamientos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Actividades por Fuente de Financiamiento').'</span>', array('controller' => 'reportes', 'action' => 'actividades_fuentes_financiamientos'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0)"><i class="clip-bars"></i>
						<span class="title"><?php echo __('Gráficos'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/tipos_familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Familia').'</span>', array('controller' => 'graficos', 'action' => 'tipos_familias'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/familias_allegadas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Familias Allegadas').'</span>', array('controller' => 'graficos', 'action' => 'familias_allegadas'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores Protectores').'</span>', array('controller' => 'graficos', 'action' => 'factores_protectores'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/factores_riesgos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores de Riesgo').'</span>', array('controller' => 'graficos', 'action' => 'factores_riesgos'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/cantidad_hombres_mujeres\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Cantidad de Hombes y Mujeres').'</span>', array('controller' => 'graficos', 'action' => 'cantidad_hombres_mujeres'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0)"><i class="clip-cog-2"></i>
						<span class="title"><?php echo __('Mantenedores'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^centros_familiares\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Centros Familiares').'</span>', array('controller' => 'centros_familiares', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^usuarios\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Usuarios').'</span>', array('controller' => 'usuarios', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^perfiles_usuarios\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Perfiles de Usuarios').'</span>', array('controller' => 'perfiles_usuarios', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^programas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Programas').'</span>', array('controller' => 'programas', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^areas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Areas').'</span>', array('controller' => 'areas', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^redes\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Redes').'</span>', array('controller' => 'redes', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^parentescos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Parentescos').'</span>', array('controller' => 'parentescos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^tipos_familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Familia').'</span>', array('controller' => 'tipos_familias', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<!--
						<li<?php echo preg_match("/^condiciones_vulnerabilidades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Condiciones Vulnerabilidades').'</span>', array('controller' => 'condiciones_vulnerabilidades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						-->
						<li<?php echo preg_match("/^nacionalidades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Nacionalidades').'</span>', array('controller' => 'nacionalidades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^pueblos_originarios\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Pueblos Originarios').'</span>', array('controller' => 'pueblos_originarios', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^tipos_actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos Actividades').'</span>', array('controller' => 'tipos_actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^instituciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Instituciones').'</span>', array('controller' => 'instituciones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^tipos_instituciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Instituciones').'</span>', array('controller' => 'tipos_instituciones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^grupos_objetivos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Grupos Objetivos').'</span>', array('controller' => 'grupos_objetivos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^niveles\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Niveles').'</span>', array('controller' => 'niveles', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores Protectores').'</span>', array('controller' => 'factores_protectores', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^indicadores_factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Preguntas').'</span>', array('controller' => 'indicadores_factores_protectores', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^factores_riesgos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores de Riesgo').'</span>', array('controller' => 'factores_riesgos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^situaciones_habitacionales\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Situaciones Habitacionales').'</span>', array('controller' => 'situaciones_habitacionales', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^conceptos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Conceptos').'</span>', array('controller' => 'conceptos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^fuentes_financiamientos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Fuentes de Financiamiento').'</span>', array('controller' => 'fuentes_financiamientos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>
			</ul>

		<?php elseif ($perf_id == 3): ?>
			<ul class="main-navigation-menu">
				<li>
					<a href="javascript:void(0)"><i class="clip-user-2"></i>
						<span class="title"><?php echo __('Ficha'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^personas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Personas').'</span>', array('controller' => 'personas', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Familias').'</span>', array('controller' => 'familias', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-location"></i>
						<span class="title"><?php echo __('Actividades'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Actividades').'</span>', array('controller' => 'actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^personas_actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Inscripciones').'</span>', array('controller' => 'personas_actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^sesiones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Sesiones').'</span>', array('controller' => 'sesiones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-pencil"></i>
						<span class="title"><?php echo __('Evaluaciones'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^evaluaciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Evaluaciones').'</span>', array('controller' => 'evaluaciones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^planes_trabajos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Plan de Acompañamiento').'</span>', array('controller' => 'planes_trabajos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-grid-6"></i>
						<span class="title"><?php echo __('Reportes'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^reportes\/coberturas_personas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Cobertura de Personas').'</span>', array('controller' => 'reportes', 'action' => 'coberturas_personas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/actividades/", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Actividades').'</span>', array('controller' => 'reportes', 'action' => 'actividades'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/coberturas_personas_areas_tipos_actividad\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Coberturas por Area, Tipo de Actividad').'</span>', array('controller' => 'reportes', 'action' => 'coberturas_personas_areas_tipos_actividad'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/actividades_individuales_masivas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Reporte actividades individuales/masivas').'</span>', array('controller' => 'reportes', 'action' => 'actividades_individuales_masivas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/prestaciones_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Detalle Prestaciones por Usuario').'</span>', array('controller' => 'reportes', 'action' => 'prestaciones_II'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/participantes_I\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Detalle Actividades por Participante').'</span>', array('controller' => 'reportes', 'action' => 'participantes_I'), array('escape' => false)); ?>
						</li>
						<!--
						<li<?php echo preg_match("/^reportes\/participantes_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Participantes II').'</span>', array('controller' => 'reportes', 'action' => 'participantes_II'), array('escape' => false)); ?>
						</li>
						-->
						<li<?php echo preg_match("/^reportes\/sesiones_ejecutadas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Sesiones Ejecutadas').'</span>', array('controller' => 'reportes', 'action' => 'sesiones_ejecutadas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/consulta_hh\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Consulta HH').'</span>', array('controller' => 'reportes', 'action' => 'consulta_hh'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/redes_I\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Redes I').'</span>', array('controller' => 'reportes', 'action' => 'redes_I'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/redes_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Redes II').'</span>', array('controller' => 'reportes', 'action' => 'redes_II'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/instituciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Instituciones').'</span>', array('controller' => 'reportes', 'action' => 'instituciones'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/cantidad_fichas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Cantidad de Fichas').'</span>', array('controller' => 'reportes', 'action' => 'cantidad_fichas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/tipos_familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Familia').'</span>', array('controller' => 'reportes', 'action' => 'tipos_familias'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/relacion_familia\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Otros tipos de Familia').'</span>', array('controller' => 'reportes', 'action' => 'relacion_familia'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/relacion_ficha\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Relación Ficha/Grupo Objetivo').'</span>', array('controller' => 'reportes', 'action' => 'relacion_ficha'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_diagnostica\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Evaluación Diagnóstica').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_diagnostica'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_final\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Evaluación Final').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_final'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/factores_riesgos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Factores Riesgos').'</span>', array('controller' => 'reportes', 'action' => 'factores_riesgos'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Evaluación Factores Protectores').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_factores_protectores'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/fuentes_financiamientos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Fuentes de Financiamiento').'</span>', array('controller' => 'reportes', 'action' => 'fuentes_financiamientos'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/acumulado\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultado Acumulado').'</span>', array('controller' => 'reportes', 'action' => 'acumulado'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-cog-2"></i>
						<span class="title"><?php echo __('Mantenedores'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^instituciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Instituciones').'</span>', array('controller' => 'instituciones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

			</ul>

		<?php elseif ($perf_id == 7): ?>
			<ul class="main-navigation-menu">
				<li>
					<a href="javascript:void(0)"><i class="clip-location"></i>
						<span class="title"><?php echo __('Actividades'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Actividades').'</span>', array('controller' => 'actividades', 'action' => 'comunicaciones'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>
			</ul>

		<?php elseif ($perf_id == 8) : ?>
			<ul class="main-navigation-menu">
				<li>
					<a href="javascript:void(0)"><i class="clip-user-2"></i>
						<span class="title"><?php echo __('Ficha'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^personas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Personas').'</span>', array('controller' => 'personas', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Familias').'</span>', array('controller' => 'familias', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-location"></i>
						<span class="title"><?php echo __('Actividades'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Actividades').'</span>', array('controller' => 'actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^personas_actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Inscripciones').'</span>', array('controller' => 'personas_actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^sesiones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Sesiones').'</span>', array('controller' => 'sesiones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-pencil"></i>
						<span class="title"><?php echo __('Evaluaciones'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^evaluaciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Evaluaciones').'</span>', array('controller' => 'evaluaciones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^planes_trabajos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Plan de Acompañamiento').'</span>', array('controller' => 'planes_trabajos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-grid-6"></i>
						<span class="title"><?php echo __('Reportes'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^reportes\/coberturas_personas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Cobertura de Personas').'</span>', array('controller' => 'reportes', 'action' => 'coberturas_personas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/actividades/", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Actividades').'</span>', array('controller' => 'reportes', 'action' => 'actividades'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/coberturas_personas_areas_tipos_actividad\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Coberturas por Area, Tipo de Actividad').'</span>', array('controller' => 'reportes', 'action' => 'coberturas_personas_areas_tipos_actividad'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/actividades_individuales_masivas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Reporte actividades individuales/masivas').'</span>', array('controller' => 'reportes', 'action' => 'actividades_individuales_masivas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/prestaciones_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Detalle Prestaciones por Usuario').'</span>', array('controller' => 'reportes', 'action' => 'prestaciones_II'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/participantes_I\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Detalle Actividades por Participante').'</span>', array('controller' => 'reportes', 'action' => 'participantes_I'), array('escape' => false)); ?>
						</li>
						<!--
						<li<?php echo preg_match("/^reportes\/participantes_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Participantes II').'</span>', array('controller' => 'reportes', 'action' => 'participantes_II'), array('escape' => false)); ?>
						</li>
						-->
						<li<?php echo preg_match("/^reportes\/sesiones_ejecutadas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Sesiones Ejecutadas').'</span>', array('controller' => 'reportes', 'action' => 'sesiones_ejecutadas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/consulta_hh\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Consulta HH').'</span>', array('controller' => 'reportes', 'action' => 'consulta_hh'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/redes_I\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Redes I').'</span>', array('controller' => 'reportes', 'action' => 'redes_I'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/redes_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Redes II').'</span>', array('controller' => 'reportes', 'action' => 'redes_II'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/instituciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Instituciones').'</span>', array('controller' => 'reportes', 'action' => 'instituciones'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/cantidad_fichas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Cantidad de Fichas').'</span>', array('controller' => 'reportes', 'action' => 'cantidad_fichas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/tipos_familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Familia').'</span>', array('controller' => 'reportes', 'action' => 'tipos_familias'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/relacion_familia\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Otros tipos de Familia').'</span>', array('controller' => 'reportes', 'action' => 'relacion_familia'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/relacion_ficha\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Relación Ficha/Grupo Objetivo').'</span>', array('controller' => 'reportes', 'action' => 'relacion_ficha'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_diagnostica\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Evaluación Diagnóstica').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_diagnostica'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_final\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Evaluación Final').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_final'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/factores_riesgos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Factores Riesgos').'</span>', array('controller' => 'reportes', 'action' => 'factores_riesgos'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Evaluación Factores Protectores').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_factores_protectores'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/fuentes_financiamientos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Fuentes de Financiamiento').'</span>', array('controller' => 'reportes', 'action' => 'fuentes_financiamientos'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/acumulado\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultado Acumulado').'</span>', array('controller' => 'reportes', 'action' => 'acumulado'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0)"><i class="clip-bars"></i>
						<span class="title"><?php echo __('Gráficos'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/tipos_familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Familia').'</span>', array('controller' => 'graficos', 'action' => 'tipos_familias'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/familias_allegadas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Familias Allegadas').'</span>', array('controller' => 'graficos', 'action' => 'familias_allegadas'), array('escape' => false)); ?>
						</li>
					</ul>
					<!--
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores Protectores').'</span>', array('controller' => 'graficos', 'action' => 'factores_protectores'), array('escape' => false)); ?>
						</li>
					</ul>
					-->
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/factores_riesgos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores de Riesgo').'</span>', array('controller' => 'graficos', 'action' => 'factores_riesgos'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/cantidad_hombres_mujeres\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Cantidad de Hombes y Mujeres').'</span>', array('controller' => 'graficos', 'action' => 'cantidad_hombres_mujeres'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0)"><i class="clip-cog-2"></i>
						<span class="title"><?php echo __('Mantenedores'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^centros_familiares\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Centros Familiares').'</span>', array('controller' => 'centros_familiares', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^usuarios\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Usuarios').'</span>', array('controller' => 'usuarios', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^perfiles_usuarios\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Perfiles de Usuarios').'</span>', array('controller' => 'perfiles_usuarios', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^programas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Programas').'</span>', array('controller' => 'programas', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^areas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Areas').'</span>', array('controller' => 'areas', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^redes\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Redes').'</span>', array('controller' => 'redes', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^parentescos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Parentescos').'</span>', array('controller' => 'parentescos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^tipos_familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Familia').'</span>', array('controller' => 'tipos_familias', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<!--
						<li<?php echo preg_match("/^condiciones_vulnerabilidades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Condiciones Vulnerabilidades').'</span>', array('controller' => 'condiciones_vulnerabilidades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						-->
						<li<?php echo preg_match("/^nacionalidades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Nacionalidades').'</span>', array('controller' => 'nacionalidades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^pueblos_originarios\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Pueblos Originarios').'</span>', array('controller' => 'pueblos_originarios', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^tipos_actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos Actividades').'</span>', array('controller' => 'tipos_actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^instituciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Instituciones').'</span>', array('controller' => 'instituciones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^tipos_instituciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Instituciones').'</span>', array('controller' => 'tipos_instituciones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^grupos_objetivos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Grupos Objetivos').'</span>', array('controller' => 'grupos_objetivos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^niveles\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Niveles').'</span>', array('controller' => 'niveles', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores Protectores').'</span>', array('controller' => 'factores_protectores', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^indicadores_factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Preguntas').'</span>', array('controller' => 'indicadores_factores_protectores', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^factores_riesgos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores de Riesgo').'</span>', array('controller' => 'factores_riesgos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^situaciones_habitacionales\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Situaciones Habitacionales').'</span>', array('controller' => 'situaciones_habitacionales', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^conceptos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Conceptos').'</span>', array('controller' => 'conceptos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^fuentes_financiamientos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Fuentes de Financiamiento').'</span>', array('controller' => 'fuentes_financiamientos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>
			</ul>

		<?php elseif ($perf_id == 9) : ?>
			<ul class="main-navigation-menu">
				<li>
					<a href="javascript:void(0)"><i class="clip-user-2"></i>
						<span class="title"><?php echo __('Ficha'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^personas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Personas').'</span>', array('controller' => 'personas', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Familias').'</span>', array('controller' => 'familias', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-location"></i>
						<span class="title"><?php echo __('Actividades'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Actividades').'</span>', array('controller' => 'actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^personas_actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Inscripciones').'</span>', array('controller' => 'personas_actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^sesiones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Sesiones').'</span>', array('controller' => 'sesiones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-pencil"></i>
						<span class="title"><?php echo __('Evaluaciones'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^evaluaciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Evaluaciones').'</span>', array('controller' => 'evaluaciones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^planes_trabajos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Plan de Acompañamiento').'</span>', array('controller' => 'planes_trabajos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-grid-6"></i>
						<span class="title"><?php echo __('Reportes'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^reportes\/coberturas_personas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Cobertura de Personas').'</span>', array('controller' => 'reportes', 'action' => 'coberturas_personas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/actividades/", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Actividades').'</span>', array('controller' => 'reportes', 'action' => 'actividades'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/coberturas_personas_areas_tipos_actividad\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Coberturas por Area, Tipo de Actividad').'</span>', array('controller' => 'reportes', 'action' => 'coberturas_personas_areas_tipos_actividad'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/actividades_individuales_masivas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Reporte actividades individuales/masivas').'</span>', array('controller' => 'reportes', 'action' => 'actividades_individuales_masivas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/prestaciones_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Detalle Prestaciones por Usuario').'</span>', array('controller' => 'reportes', 'action' => 'prestaciones_II'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/participantes_I\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Detalle Actividades por Participante').'</span>', array('controller' => 'reportes', 'action' => 'participantes_I'), array('escape' => false)); ?>
						</li>
						<!--
						<li<?php echo preg_match("/^reportes\/participantes_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Participantes II').'</span>', array('controller' => 'reportes', 'action' => 'participantes_II'), array('escape' => false)); ?>
						</li>
						-->
						<li<?php echo preg_match("/^reportes\/sesiones_ejecutadas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Sesiones Ejecutadas').'</span>', array('controller' => 'reportes', 'action' => 'sesiones_ejecutadas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/consulta_hh\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Consulta HH').'</span>', array('controller' => 'reportes', 'action' => 'consulta_hh'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/redes_I\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Redes I').'</span>', array('controller' => 'reportes', 'action' => 'redes_I'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/redes_II\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Redes II').'</span>', array('controller' => 'reportes', 'action' => 'redes_II'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/instituciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Instituciones').'</span>', array('controller' => 'reportes', 'action' => 'instituciones'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/cantidad_fichas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Cantidad de Fichas').'</span>', array('controller' => 'reportes', 'action' => 'cantidad_fichas'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/tipos_familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Familia').'</span>', array('controller' => 'reportes', 'action' => 'tipos_familias'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/relacion_familia\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Otros tipos de Familia').'</span>', array('controller' => 'reportes', 'action' => 'relacion_familia'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/relacion_ficha\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Relación Ficha/Grupo Objetivo').'</span>', array('controller' => 'reportes', 'action' => 'relacion_ficha'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_diagnostica\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Evaluación Diagnóstica').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_diagnostica'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_final\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Evaluación Final').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_final'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/factores_riesgos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultados Factores Riesgos').'</span>', array('controller' => 'reportes', 'action' => 'factores_riesgos'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/evaluacion_factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Evaluación Factores Protectores').'</span>', array('controller' => 'reportes', 'action' => 'evaluacion_factores_protectores'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/fuentes_financiamientos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Fuentes de Financiamiento').'</span>', array('controller' => 'reportes', 'action' => 'fuentes_financiamientos'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^reportes\/acumulado\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Resultado Acumulado').'</span>', array('controller' => 'reportes', 'action' => 'acumulado'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0)"><i class="clip-bars"></i>
						<span class="title"><?php echo __('Gráficos'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/tipos_familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Familia').'</span>', array('controller' => 'graficos', 'action' => 'tipos_familias'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/familias_allegadas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Familias Allegadas').'</span>', array('controller' => 'graficos', 'action' => 'familias_allegadas'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores Protectores').'</span>', array('controller' => 'graficos', 'action' => 'factores_protectores'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/factores_riesgos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores de Riesgo').'</span>', array('controller' => 'graficos', 'action' => 'factores_riesgos'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^graficos\/cantidad_hombres_mujeres\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Cantidad de Hombes y Mujeres').'</span>', array('controller' => 'graficos', 'action' => 'cantidad_hombres_mujeres'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0)"><i class="clip-cog-2"></i>
						<span class="title"><?php echo __('Mantenedores'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^centros_familiares\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Centros Familiares').'</span>', array('controller' => 'centros_familiares', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^programas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Programas').'</span>', array('controller' => 'programas', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^areas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Areas').'</span>', array('controller' => 'areas', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^redes\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Redes').'</span>', array('controller' => 'redes', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^parentescos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Parentescos').'</span>', array('controller' => 'parentescos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^tipos_familias\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Familia').'</span>', array('controller' => 'tipos_familias', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<!--
						<li<?php echo preg_match("/^condiciones_vulnerabilidades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Condiciones Vulnerabilidades').'</span>', array('controller' => 'condiciones_vulnerabilidades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						-->
						<li<?php echo preg_match("/^nacionalidades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Nacionalidades').'</span>', array('controller' => 'nacionalidades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^pueblos_originarios\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Pueblos Originarios').'</span>', array('controller' => 'pueblos_originarios', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^tipos_actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos Actividades').'</span>', array('controller' => 'tipos_actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^instituciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Instituciones').'</span>', array('controller' => 'instituciones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^tipos_instituciones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Tipos de Instituciones').'</span>', array('controller' => 'tipos_instituciones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^grupos_objetivos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Grupos Objetivos').'</span>', array('controller' => 'grupos_objetivos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^niveles\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Niveles').'</span>', array('controller' => 'niveles', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores Protectores').'</span>', array('controller' => 'factores_protectores', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^indicadores_factores_protectores\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Preguntas').'</span>', array('controller' => 'indicadores_factores_protectores', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^factores_riesgos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Factores de Riesgo').'</span>', array('controller' => 'factores_riesgos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^situaciones_habitacionales\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Situaciones Habitacionales').'</span>', array('controller' => 'situaciones_habitacionales', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^conceptos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Conceptos').'</span>', array('controller' => 'conceptos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
						<li<?php echo preg_match("/^fuentes_financiamientos\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Fuentes de Financiamiento').'</span>', array('controller' => 'fuentes_financiamientos', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>
			</ul>

		<?php elseif ($perf_id == 10) : ?>
			<ul class="main-navigation-menu">
				<li>
					<a href="javascript:void(0)"><i class="clip-user-2"></i>
						<span class="title"><?php echo __('Ficha'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^personas\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Personas').'</span>', array('controller' => 'personas', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:void(0)"><i class="clip-location"></i>
						<span class="title"><?php echo __('Actividades'); ?></span><i class="icon-arrow"></i>
						<span class="selected"></span>
					</a>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^personas_actividades\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Inscripciones').'</span>', array('controller' => 'personas_actividades', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
					<ul class="sub-menu">
						<li<?php echo preg_match("/^sesiones\//", $url)? " class=\"active open\"": null; ?>>
							<?php echo $this->Html->link('<span class="title">'.__('Sesiones').'</span>', array('controller' => 'sesiones', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					</ul>
				</li
			</ul>

		<?php endif; ?>
		<!-- end: MAIN NAVIGATION MENU -->
	</div>
	<!-- end: SIDEBAR -->
</div>

<script>
// para abrir menu
$('.active.open').parent().parent().addClass('active open')
</script>