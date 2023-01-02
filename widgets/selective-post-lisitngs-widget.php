<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Selective Post Lisitngs Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @author sam
 * @since 1.0.0
 */
class Elementor_Selective_Post_Lisitngs_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @author Sam
	 az@gmail.com
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Elementor-selective-post-lisitngs-widget';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @author Sam
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Selective Post Lisitngs', 'elementor-selective-post-lisitngs-widget' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @author Sam
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-list';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @author Sam
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return '';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @author Sam
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 *
	 * @author Sam
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'select', 'post', 'list' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @author Sam
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'elementor-selective-post-lisitngs-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$options = [];
		$posts = get_posts(['posts_per_page' => -1]);
		if (!empty($posts)) {
			foreach ($posts as $post) {
				$options[$post->ID] = $post->post_title;
			}
		}

		$this->add_control(
			'selective_posts',
			[
				'label' => esc_html__( 'Select Posts', 'elementor-selective-post-lisitngs-widget' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $options,
				// 'default' => [ 'title', 'description' ],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @author Sam
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		ob_start();
		$settings = $this->get_settings_for_display();
		$posts_ids = $settings['selective_posts'];

		if (!empty($posts_ids) ) {
			$posts = get_posts(['post__in' => $posts_ids]);
			if (!empty($posts) ) { ?>
				<div class="latest-recent-article">
					<?php foreach ($posts as $post) {
						$postId = $post->ID;
						$postTitle = $post->post_title;
						$postLink = esc_url(get_permalink($postId));
						$postImage = wp_get_attachment_url(get_post_thumbnail_id($postId));
						$postCategories = get_the_category($id);
						$posCats = [];
		                foreach ($postCategories as $category ) {
		                	$posCats[] = '<a href="'. esc_url( get_category_link( $category->term_id ) ) .'">' . esc_html( $category->name ) . '</a>';
		                }
		                $posCatsList = implode(", ", $posCats);
		                $postAuthor = get_the_author_meta( 'display_name', $post->post_author);
						$postDate = get_the_time('M j Y', $postId);
						?>
						<div class="recent-post-item">
			            	<div class="post-block d-flex">
			                	<div class="image-block">
			                    	<div class="inner-image">
			                    		<a href="<?php echo $postLink; ?>" style="background-image:url('<?php echo $postImage; ?>')" ></a>
			                    	</div>
			                  	</div>
							            <div class="post-content d-flex align-items-center align-content-center">
			                        <h3 class="mb-0"><a href="<?php echo $postLink; ?>" class=""><?php echo $postTitle; ?></a></h3>
							            </div>
			                </div>
			            </div>
					<?php } ?>
				</div>
			<?php }
		}
		echo ob_get_clean();
	}

}
