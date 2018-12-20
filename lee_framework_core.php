<?php 
/**
 * Frame Name: Lee Framework
 * Author: Apisit Lee
 * Author Url: https://apisitlee.com
 * Version: 1.0
 */

class lee_framework_core {
	private $postId;
	public function __construct() {
		include_once( __DIR__ . '/config-common.php' );
		$confs = $this->read_all_dir(__DIR__.'/conf');
		for ($i=0; $i < count($confs); $i++) { 
			include_once( $confs[$i] );
		}
	}
	function read_all_dir ( $dir )
    {
        $result = array();
        $handle = opendir($dir);
        if ( $handle )
        {
            while ( ( $file = readdir ( $handle ) ) !== false )
            {
                if ( $file != '.' && $file != '..')
                {
                    $cur_path = $dir . DIRECTORY_SEPARATOR . $file;
                    if ( is_dir ( $cur_path ) )
                    {
                        // $result['dir'][$cur_path] = $this->read_all_dir ( $cur_path );
                    }
                    else
                    {
                        $result[] = $cur_path;
                    }
                }
            }
            closedir($handle);
        }
        return $result;
    }
	/**
	 * 生成表单布局的头部html
	 * @return null 
	 */
	public function form_table_header() {
		echo '<table class="form-table">';
		echo '<tbody>';
	}
	/**
	 * 生成表单布局的脚步html
	 * @return null 
	 */
	public function form_table_footer( $includeScript=true ) {
		echo '</tbody>';
		echo '</table>';
		if( $includeScript ) {
			wp_enqueue_media();
		?>
		<script>
		jQuery(document).ready(function(){
			var upload_frame;
			var value_id;
			var type;
			var titleMap = {'image':'选择图片', 'audio':'选择音频', 'video':'选择视频'};
			jQuery('.lee_upload_button').each(function() {
				jQuery(this).on('click', clickCb);
			});
			function clickCb(event) {
				event.preventDefault();
				value_id = jQuery(this).attr('id');
				type = jQuery(this).attr('data-type');
				if( ！upload_frame ) {
					upload_frame = wp.media({
						title: titleMap[type],
						button: {
							text: '确定'
						},
						multiple: false
					});
					upload_frame.on('select', function() {
						attachment = upload_frame.state().get('selection').first().toJSON();
						jQuery('input[name="'+value_id+'"]').val(attachment.url);
						switch(type){
							case 'audio':
								jQuery('audio#audio-'+value_id).attr('src', attachment.url);
								break;
							case 'video':
								jQuery('video#video-'+value_id).attr('src', attachment.url);
								break;
							case 'image':
							default:
								jQuery('img#pic-'+value_id).attr('src', attachment.url);
								break;
						}
					});
				}
				upload_frame.open();
			}
		});
		</script>
		<?php 
		}
	}
	/**
	 * 生成表单行头
	 * @param mixed $meta 行数据
	 * @param  boolean $label 是否启用label标签
	 * @return null         
	 */
	public function row_header( $meta, $label=TRUE ) {
		if( $label ) {
			echo '<tr>';
			echo '<th scope="row"><label for="' . $meta['id'] . '">' . $meta['title'] . '</label></th>';
			echo '<td>';
		} else {
			echo '<tr>';
			echo '<th scope="row">' . $meta['title'] . '</th>';
			echo '<td>';
		}
	}
	/**
	 * 生成表单行脚
	 * @return null 
	 */
	public function row_footer() {
		echo '</td>';
		echo '</tr>';
	}
	/**
	 * 生成表单布局内的表单们
	 * @param string $post_id post ID
	 * @param  array $metas 表单配置
	 * @return null 
	 */
	public function form_table_rows( $post_id, $metas ) {
		$this->_postId = $post_id;
		for ($i=0; $i < count($metas); $i++) { 
			$meta = $metas[$i];
			if( !defined( 'LEE_PREFIX' ) ) {
				define( 'LEE_PREFIX', 'lee' );
			}
			if( !empty( LEE_PREFIX ) ) {
				$meta['id'] = LEE_PREFIX . "_" . $meta['id'];
			}
			$post_meta = get_post_meta( $post_id, $meta['id'], TRUE );
			if( !isset( $meta['std'] ) ) {
				$meta = array_merge( $meta, array( 'std' => '' ) );
			}
			if( ! empty( $post_meta ) ) {
				$meta['std'] = $post_meta;
			}
			if( isset( $meta['desc'] ) && ! empty( $meta['desc'] ) ) {
				$meta['desc'] = '<p class="description" id="' . $meta['id'] . '-description">' . $meta['desc'] . '</p>';
			} else {
				$meta['desc'] = '';
			}
			if( $meta['type']=='datetime' && ( !isset( $meta['std'] ) || empty( $meta['std'] ) ) ) {
				$meta = array_merge( $meta, array( 'std' => date('Y-m-d',time()) . 'T' . date('h:i', time()) ) );
			}
			if( in_array( $meta['type'], array( 'image', 'audio', 'video' ) ) && !isset( $meta['button_text'] ) ) {
				$mdta = array_merge( $meta, array( 'button_text' => '选择媒体' ) );
			}
			$this->form_table_row( $meta );
		}
	}
	public function form_table_row( $meta ) {
		$has_label = TRUE;
		if( in_array( $meta['type'], array( 'checkbox', 'radio', 'color', 'image', 'audio', 'video', 'editor', 'group' ) ) ) {
			$has_label = FALSE;
		}
		$this->row_header( $meta, $has_label );
		$this->{(string)$meta['type']}( $meta );
		$this->row_footer();
	}
	/**
	 * 普通文本
	 * @param  array $meta 行数据
	 * @return null       
	 */
	public function text( $meta ) {
		echo '<input name="' . $meta['id'] . '" type="text" id="' . $meta['id'] . '" aria-describedby="' . $meta['id'] . '-description" value="' . $meta['std'] . '" class="regular-text ltr">' . $meta['desc'];
	}
	public function number( $meta ) {
		echo '<input name="' . $meta['id'] . '" type="number" id="' . $meta['id'] . '" aria-describedby="' . $meta['id'] . '-description" value="' . (int)$meta['std'] . '" class="regular-text ltr">' . $meta['desc'];
	}
	public function select( $meta ) {
		echo '<select name="' . $meta['id'] . '" id="' . $meta['id'] . '">';
		foreach ($meta['sub_type'] as $key => $value) {
			if( $key == $meta['std'] ) {
				echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
			} else {
				echo '<option value="' . $key . '">' . $value . '</option>';
			}
		}
		echo '</select>';
	}
	public function textarea( $meta ) {
		echo '<textarea id="' . $meta['id'] . '" name="' . $meta['id'] . '" class="large-text" rows=5>' . $meta['std'] . '</textarea>';
	}
	public function checkbox( $meta ) {
		echo '<fieldset>';
		echo '<legend class="screen-reader-text"><span>' . $meta['title'] . '</span></legend>';
		if( !is_array($meta['std']) ) {
			$meta['std'] = array( $meta['std'] );
		}
		foreach ($meta['sub_type'] as $key => $value) {
			if(!$meta['inline']) {
				echo '<p>';
			}
			$checked = in_array($key, $meta['std']) ? $key : '0';
			echo '<label><input name="' . $meta['id'] . '[' . $key . ']" type="checkbox" value="' . $key . '" ' . checked( $key, $checked, false ) . '> ' . $value . '</label>';
			if( $meta['inline'] ) { 
				echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			if(!$meta['inline']) {
				echo '</p>';
			}
		}
		echo $meta['desc'];
		echo '</fieldset>';
	}
	public function radio( $meta ) {
		echo '<fieldset>';
		echo '<legend class="screen-reader-text"><span>' . $meta['title'] . '</span></legend>';
		foreach ($meta['sub_type'] as $key => $value) {
			if(!$meta['inline']) {
				echo '<p>';
			}
			echo '<label><input name="' . $meta['id'] . '" type="radio" value="' . $key . '" ' . checked( $key, $meta['std'], false ) . '> ' . $value . '</label>';
			if( $meta['inline'] ) {
				echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			if(!$meta['inline']) {
				echo '</p>';
			}
		}
		echo '</fieldset>';
	}
	public function color( $meta ) {
		echo '<style>input[type="color"]::-webkit-color-swatch-wrapper { padding: 0; }input[type="color"]::-webkit-color-swatch { border: 0; }</style>';
		echo '<input type="color" name="' . $meta['id'] . '" id="' . $meta['id'] . '" value="'  . $meta['std'] . '">';
		echo $meta['desc'];
	}
	public function datetime( $meta ) {
		echo '<input type="datetime-local" name="' . $meta['id'] . '" id="' . $meta['id'] . '" value="'  . $meta['std'] . '">';
	}
	public function image( $meta ) {
		echo '<input type="hidden" name="' . $meta['id'] . '" id="' . $meta['id'] . '" value="'  . $meta['std'] . '">';
		echo '<img src="' . $meta['std'] . '" id="pic-' . $meta['id'] . '" style="max-width: 300px;max-height: 300px;display: block;margin: 10px 0;"></object>';
		echo '<section class="wp-media-buttons">';
		echo '<button type="button" id="' . $meta['id'] . '" class="button add_media lee_upload_button" data-type="image"><span class="wp-media-buttons-icon"></span> ' . $meta['button_text'] . '</button>';
		echo '</section>';
	}
	public function audio( $meta ) {
		echo '<input type="hidden" name="' . $meta['id'] . '" id="' . $meta['id'] . '" value="'  . $meta['std'] . '">';
		echo '<audio controls id="audio-' . $meta['id'] . '" style="max-width: 300px;max-height: 300px;display: block;margin: 10px 0;">';
		echo '<source src="' . $meta['std'] . '" type="audio/mpeg">';
		echo '<source src="' . $meta['std'] . '" type="audio/ogg">';
		echo '<source src="' . $meta['std'] . '" type="audio/wav">';
		echo '</audio>';
		echo '<section class="wp-media-buttons">';
		echo '<button type="button" id="' . $meta['id'] . '" class="button add_media lee_upload_button" data-type="audio"><span class="wp-media-buttons-icon"></span> ' . $meta['button_text'] . '</button>';
		echo '</section>';
	}
	public function video( $meta ) {
		echo '<input type="hidden" name="' . $meta['id'] . '" id="' . $meta['id'] . '" value="'  . $meta['std'] . '">';
		echo '<video controls id="video-' . $meta['id'] . '" style="max-width: 300px;max-height: 300px;display: block;margin: 10px 0;">';
		echo '<source src="' . $meta['std'] . '" type="video/mp4">';
		echo '<source src="' . $meta['std'] . '" type="video/ogg">';
		echo '</video>';
		echo '<section class="wp-media-buttons">';
		echo '<button type="button" id="' . $meta['id'] . '" class="button add_media lee_upload_button" data-type="video"><span class="wp-media-buttons-icon"></span> ' . $meta['button_text'] . '</button>';
		echo '</section>';
	}
	public function editor( $meta ) {
		wp_editor( $meta['std'], $meta['id'] );
	}
}


require __DIR__ .'/inc/lee_options.php';
require __DIR__ .'/inc/lee_termmeta.php';
require __DIR__ .'/inc/lee_postmeta.php';
require __DIR__ .'/inc/lee_quick_edit.php';


$lee_framework_core = new lee_framework_core();