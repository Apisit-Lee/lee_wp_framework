<?php

/**
 * post meta box
 * guji
 */
$meta_conf = array(
    'id'     => 'lee_custom_metabox',
    'title'  => '古籍信息',
    'desc'   => '填写古籍信息。',
    'screen' => array( 'guji' )
);
$meta = array();
$meta[] = array(
	'id'    => 'author',
	'title' => '作者',
	'desc'  => '若作者未知请填写“佚名”，若多个作者的合集则留空。',
	'type'  => 'text',
	'std'   => ''
);
$meta[] = array(
	'id'    => 'try_read_count',
	'title' => '试读数量',
	'desc'  => '',
	'type'  => 'number',
	'std'   => ''
);
$meta[] = array(
	'id'    => 'select_demo',
	'title' => '下拉框demo',
	'desc'  => '',
	'type'  => 'select',
	'std'   => 'b',
	'sub_type' => array(
		'a'    => 'A',
		'b'    => 'B'
	)
);
$meta[] = array(
	'id'    => 'textarea_demo',
	'title' => '文本域demo',
	'desc'  => '',
	'type'  => 'textarea',
	'std'   => '请输入内容...'
);
$meta[] = array(
	'id'    => 'checkbox_demo_1',
	'desc'  => '多项选择题呢',
	'title' => '复选项',
	'type'  => 'checkbox',
	'std'   => array( 'c', 'e' ),
	'inline' => true,
	'sub_type' => array(
		'a'    => '我是A',
		'b'    => '我是B',
		'c'    => '我是C',
		'd'    => '我是D',
		'e'    => '我是E'
	)
);
$meta[] = array(
	'id'    => 'checkbox_demo_2',
	'desc'  => '又一个多项选择题呢',
	'title' => '复选项2',
	'type'  => 'checkbox',
	'std'   => array( 'a', 'e' ),
	'inline' => false,
	'sub_type' => array(
		'a'    => '我是A',
		'b'    => '我是B',
		'c'    => '我是C',
		'd'    => '我是D',
		'e'    => '我是E'
	)
);
$meta[] = array(
	'id'    => 'radio_demo',
	'title' => '作者性别',
	'desc'  => '',
	'type'  => 'radio',
	'std'   => 'female',
	'inline' => false,
	'sub_type' => array(
		'male'    => '男',
		'female'    => '女'
	)
);
$meta[] = array(
	'id' => 'btn_color',
	'title' => '按钮颜色',
	'desc' => '',
	'type' => 'color',
	'std' => '#ffccff'
);
$meta[] = array(
	'id' => 'start_time',
	'title' => '起始时间',
	'desc' => '',
	'type' => 'datetime'
);
$meta[] = array(
	'id' => 'pimg',
	'title' => '特色图片',
	'desc' => '',
	'type' => 'image',
	'button_text' => '选择图片',
	'std' => ''
);
$meta[] = array(
	'id' => 'paudio',
	'title' => '特色音频',
	'desc' => '',
	'type' => 'audio',
	'button_text' => '选择音频',
	'std' => ''
);
$meta[] = array(
	'id' => 'pvideo',
	'title' => '特色视频',
	'desc' => '',
	'type' => 'video',
	'button_text' => '选择视频'
);
$meta[] = array(
	'id' => 'ad',
	'title' => '编辑广告',
	'desc' => '',
	'type' => 'editor',
	'std' => ''
);
$metabox = new lee_postmeta( $meta_conf, $meta );
