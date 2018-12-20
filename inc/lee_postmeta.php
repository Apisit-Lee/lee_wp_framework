<?php 
/**
 * 文章metabox
 * @see  https://developer.wordpress.org/reference/functions/add_meta_box/
 */
class lee_postmeta extends lee_framework_core
{
	
	protected $default_meta_conf = array(
		'callback' => 'render_metabox',
		'context'  => 'advanced',
		'priority' => 'default',
		'desc'     => ''
	);
	protected $default_meta	     = array();

	function __construct( $meta_conf, $meta )
	{
		if( is_admin() ) {
			$this->meta_conf = array_merge( $this->default_meta_conf, $meta_conf );
			$this->meta      = array_merge( $this->default_meta,      $meta      );

			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}
	}

	public function init_metabox() {
		add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
		add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
	}

	public function add_metabox() {
		add_meta_box(
			$this->meta_conf['id'],
			$this->meta_conf['title'],
			array( $this, $this->meta_conf['callback'] ),
			$this->meta_conf['screen'],
			$this->meta_conf['context'],
			$this->meta_conf['priority']
		);
	}

	public function render_metabox( $post ) {
		wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
		// metabox描述
		if( ! empty($this->meta_conf['desc']) ) {
			echo '<p>' . $this->meta_conf['desc'] . '</p>';
		}
		$this->form_table_header();
		$this->form_table_rows( $post->ID, $this->meta );
		$this->form_table_footer();
	}

	public function save_metabox( $post_id, $post ) {
		$nonce_name = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
		$nonce_action = 'custom_nonce_action';

		if( !wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}

		if( !current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		if( wp_is_post_revision( $post_id ) ) {
			return;
		}

		for ($i=0; $i < count($this->meta); $i++) { 
			$meta = $this->meta[$i];
			$data = $_POST[$meta['id']];
			update_post_meta( $post_id, $meta['id'], $data );
		}
	}
}