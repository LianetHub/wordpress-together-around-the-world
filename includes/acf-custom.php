<?php

//add option page
if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title' 	=> 'Настройки темы',
		'menu_title'	=> 'Настройки темы',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}


function my_acf_admin_head()
{
?>
	<style type="text/css">
		h2.hndle.ui-sortable-handle {
			background: #B1DF1D;
			color: #262624 !important;
			-webkit-transition: all 0.25s;
			-o-transition: all 0.25s;
			transition: all 0.25s;
		}

		.acf-field.acf-accordion .acf-label.acf-accordion-title {
			background: #B1DF1D;
			color: #262624;
			transition: all 0.25s;
		}

		.acf-accordion .acf-accordion-title label {
			text-transform: uppercase;
			color: #000;
		}

		.acf-field p.description {
			color: #ffa500;
		}

		.acf-field-group {
			border: 1px solid #282D41 !important;
		}
	</style>
<?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head');

add_action('acf/input/admin_footer', function () {
?>
	<script type="text/javascript">
		(function($) {
			if (typeof acf === 'undefined') return;

			acf.addAction('ready', function() {
				var fieldFrom = acf.getField('field_69bafc3f55dca');
				var fieldTo = acf.getField('field_69bafdb655dcb');

				if (!fieldFrom || !fieldTo) return;

				var $inputFrom = fieldFrom.$el.find('.hasDatepicker');
				var $inputTo = fieldTo.$el.find('.hasDatepicker');

				function updateRestrictions() {
					var valFrom = fieldFrom.val();
					var valTo = fieldTo.val();

					if (valFrom && valFrom.length === 8) {
						var y = valFrom.substring(0, 4),
							m = valFrom.substring(4, 6) - 1,
							d = valFrom.substring(6, 8);
						$inputTo.datepicker('option', 'minDate', new Date(y, m, d));
					}

					if (valTo && valTo.length === 8) {
						var y = valTo.substring(0, 4),
							m = valTo.substring(4, 6) - 1,
							d = valTo.substring(6, 8);
						$inputFrom.datepicker('option', 'maxDate', new Date(y, m, d));
					}
				}

				updateRestrictions();

				fieldFrom.on('change', updateRestrictions);
				fieldTo.on('change', updateRestrictions);
			});
		})(jQuery);
	</script>
<?php
});

add_filter('acf/validate_value/key=field_69bafdb655dcb', function ($valid, $value, $field, $input) {
	if (!$valid || empty($value)) {
		return $valid;
	}

	$date_from = $_POST['acf']['field_69bafc3f55dca'] ?? '';

	if (!empty($date_from) && (int)$value < (int)$date_from) {
		$valid = 'Дата окончания не может быть раньше даты начала';
	}

	return $valid;
}, 10, 4);
