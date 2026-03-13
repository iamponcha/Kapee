<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'RWMB_Selectomatic_Field' ) && class_exists( 'RWMB_Field' ) )
{
	class RWMB_Selectomatic_Field extends RWMB_Select_Field {
		public static function walk( $field, $options, $db_fields, $meta ) {
			$attributes = self::call( 'get_attributes', $field, $meta );
			$walker     = new RWMB_Walker_Selectomatic( $db_fields, $field, $meta );
			$output     = sprintf(
				'<select %s>',
				self::render_attributes( $attributes )
			);
			if ( false === $field['multiple'] ) {
				$output .= $field['placeholder'] ? '<option value="">' . esc_html( $field['placeholder'] ) . '</option>' : '';
			}
			$output .= $walker->walk( $options, $field['flatten'] ? - 1 : 0 );
			$output .= '</select>';
			$output .= self::get_select_all_html( $field );
			return $output;
		}
	}

	class RWMB_Walker_Selectomatic extends RWMB_Walker_Select {

		public function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
			$label  = $this->db_fields['label'];
			$id     = $this->db_fields['id'];
			$meta   = $this->meta;

			if($depth){
				$output .= sprintf(
					'<option value="%s" %s>%s</option>',
					esc_attr( $object->$id ),
					selected( in_array( $object->$id, $meta ), true, false ),
					esc_html( RWMB_Field::filter( 'choice_label', $object->$label, $this->field, $object )
					)
				);
			}
			else{
				$output .= sprintf(
					'<optgroup label="%s">',
					esc_html( RWMB_Field::filter( 'choice_label', $object->$label, $this->field, $object )
					)
				);
			}
		}

		public function rwmb_end_html_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
			if(!$depth){
				$output .= '</optgroup>';
			}
		}
	}
}
