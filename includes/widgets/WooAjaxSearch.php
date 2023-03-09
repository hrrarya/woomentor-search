<?php
if( !defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WooAjaxSearch extends Widget_Base {

	public function get_name() {
        return 'woocommerce-ajax-search';
    }

	public function get_title() {
        return esc_html__( 'WooCommerce Ajax Search', 'woomentor' );
    }

	public function get_icon() {
        return 'eicon-search';
    }

	// public function get_custom_help_url() {}

	// public function get_categories() {}

	public function get_keywords() {
		return [ 'search', 'woocommerce', 'product' ];
	}

	// public function get_script_depends() {}

	// public function get_style_depends() {}

	protected function register_controls() {
		$this->start_controls_section(
			'configuration',
			[
				'label' => esc_html__( 'Configuration', 'woomentor' ),
			]
		);

		$this->add_control(
			'search_placeholder',
			[
				'label' => esc_html__( 'Search Placeholder', 'woomentor' ),
				'type' => Controls_Manager::TEXT,
				// 'dynamic' => [
				// 	'active' => true,
				// ],
				'default' => 'Search',
			]
		);
		$this->add_control(
			'search_limit',
			[
				'label' => esc_html__( 'Search Limit', 'woomentor' ),
				'type' => Controls_Manager::NUMBER,
				// 'dynamic' => [
				// 	'active' => true,
				// ],
				'default' => '10',
			]
		);
		$this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Order By', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' 	=> esc_html__( 'Date', 'woomentor' ),
                    'post_modified'	=> esc_html__( 'Modified Date', 'woomentor' ),
                    'post_title'   	=> esc_html__( 'Title', 'woomentor' ),
                    'post_name'     => esc_html__( 'Slug', 'woomentor' ),
                    'ID'       		=> esc_html__( 'ID', 'woomentor' ),
				],
			]
		);
		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'DESC', 'woomentor' ),
                    'ASC'  => esc_html__( 'ASC', 'woomentor' ),
				],
			]
		);
		$this->add_control(
			'thumbnail_size',
			[
				'label' => esc_html__( 'Thumbnail Size', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'thumbnail',
				'options' => [
					'thumbnail' => esc_html__('Thumbnail', 'woomentor'),
                    'medium' => esc_html__('Medium', 'woomentor'),
                    'medium_large' => esc_html__('Medium Large', 'woomentor'),
                    'full' => esc_html__('Full', 'woomentor'),
				],
			]
		);

		$this->add_control(
			'no_result',
			[
				'label' => esc_html__( 'No Result Text', 'woomentor' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'No results found.',
			]
		);

		$this->add_control(
			'include_categories',
			[
				'label' => esc_html__( 'Include Categories', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => $this->get_woo_product_categories()
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$placeholder = isset($settings['search_placeholder'])? $settings['search_placeholder'] : '';
		?>
<div class="woomentor_ajax_search_form_layoutone">
    <form action="#" method="post" class="woomentor_ajax_search_form">
        <div class="woomentor_ajax_search_form_searcharea">
            <input type="search" class="woomentor_ajax_search_form_input" placeholder="<?php echo $placeholder ?>" />
        </div>
    </form>
</div>
<?php
	}

	protected function _content_template() {
		?>
<div class="woomentor_ajax_search_form_layoutone">
    <form action="#" method="post" class="woomentor_ajax_search_form">
        <div class="woomentor_ajax_search_form_searcharea">
            <input type="search" class="woomentor_ajax_search_form_input"
                placeholder="{{{ settings.search_placeholder }}}" />
        </div>
    </form>
</div>
<?php
	}

	private function get_woo_product_categories() {
        $terms =  get_terms( array(
            'taxonomy' => 'product_cat',
            // 'include' => -1,
            'hide_empty' => false,
        ) );
		$category = [
			'all' => esc_html__( 'All Categories', 'woomentor' ),
		];
		foreach( $terms as $term ) {
			$category[$term->slug] = esc_html__($term->name, 'woomentor');
			$child_args = array(
				'taxonomy' => 'product_cat',
				'hide_empty' => false,
				'parent'   => $term->term_id
			);
			$child_product_cats = get_terms( $child_args );

			foreach( $child_product_cats as $child_cat ) {
				$category[$child_cat->slug] = esc_html__($child_cat->name, 'woomentor' );
			}
		}
		return $category;
    }

}