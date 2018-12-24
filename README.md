# lee_wp_framework

It is a WordPress admin panel framework, aiming at post meta, taxonomy, options extentions. As a WPer, we always need to extend post metas, or customize some options while we develope wp themes. It could be annoying that we have to do so much repeat works. So that's the reason why I made this framework.

Before we start with this framework, I wanna say something about it. It is an open source project, and it is now a basic version with few functions. So if you are interested in getting it better and would willing to contribute to it, I am very glad to work with you. You could connect me @ email **apisit.lee2018@gmail.com**.

Well, let's get started! In this version v1.0 I only implemented `basic post meta extention`. There is only three steps to get the framework into use. 

- **Step 1**: upload the *root directory* to your theme root.
- **Step 2**: add command `require_once( 'your path to/lee_wp_framework/lee_framework_core.php' );` to your functions.php.
- **Step 3**: write your config file and upload it into `lee_wp_framework/conf/`, and your config file will be **auto included**.

Now, you can check out your admin panel( currently post edit page ), it will work if you write your config file correctly.

## Document

The **ONLY** thing you need to do is write your *config file* for customizing your admin panel. You could follow instructions below:

### 0. Config for config

In order to avoid option namespace error, we allow you to setup your prefix to all your options in this framework. You need to set it up in lee_wp_framework/config-common.php if you want to, and default prefix is `lee`. And you also could set it a black string if you don't want a prefix as below.

```php
# config-common.php
define( 'LEE_PREFIX', 'yourPrefixOrBlankString' );
```

### 1. Customize post meta

In your config file, you can customize post meta fields with class `lee_postmeta`. It contains two arguments: `meta_conf` & `meta`;

> **meta_conf**
> 
> An array which defines your metabox's id, title, description, and screen ( i.e. which post type to use it ).

```php
$meta_conf = array(
    'id'     => 'lee_custom_metabox',
    'title'  => 'My Custom meta',
    'desc'   => 'This is my custom meta.',
    'screen' => array( 'post', 'page' )
);
```

> **meta**
> 
> An array contains metas you need.

```php
$meta = array();
$meta[] = array(
	'id'    => 'author',
	'title' => 'Author',
	'desc'  => 'Input author's full name please.',
	'type'  => 'text',
	'std'   => ''
);
```

You just add metas into $meta. There are several form element types for you to use.

#### plane text

```php
$meta[] = array(
	'id'    => 'planeTextDemo',
	'title' => 'Plane Text Title',
	'desc'  => 'This is description.',
	'type'  => 'text', // important!
	'std'   => ''  // default value
);
```

#### number

```php
$meta[] = array(
	'id'    => 'numberDemo',
	'title' => 'Number Title',
	'desc'  => '',
	'type'  => 'number', // important!
	'std'   => ''
);
```
#### select

```php
$meta[] = array(
	'id'    => 'selectDemo',
	'title' => 'Select Demo Title',
	'desc'  => '',
	'type'  => 'select', // important!
	'std'   => 'b', // default option key
	'sub_type' => array( // sub_type array defines select options
		'a'    => 'A', // key-value paires
		'b'    => 'B'
	)
);
```

#### textarea

```php 
$meta[] = array(
	'id'    => 'textareaDemo',
	'title' => 'Textarea Demo Title',
	'desc'  => '',
	'type'  => 'textarea', // important!
	'std'   => 'Input something...'
);
```

#### checkbox

```php
$meta[] = array(
	'id'    => 'checkboxDemo',
	'desc'  => 'Multiple Checkbox',
	'title' => 'Checkbox Title',
	'type'  => 'checkbox',
	'std'   => array( 'c', 'e' ), // default selected options
	'inline' => true, // defines options' inline or block
	'sub_type' => array(
		'a'    => 'I am A',
		'b'    => 'I am B',
		'c'    => 'I am C',
		'd'    => 'I am D',
		'e'    => 'I am E'
	)
);
```

#### radio

```php
$meta[] = array(
	'id'    => 'radioDemo',
	'title' => 'Radio Title',
	'desc'  => '',
	'type'  => 'radio',// important
	'std'   => 'female',
	'inline' => false,
	'sub_type' => array(
		'male'    => 'Male',
		'female'    => 'Female'
	)
);
```
#### color picker

```php
$meta[] = array(
	'id' => 'colorDemo',
	'title' => 'Color Title',
	'desc' => '',
	'type' => 'color', // important！
	'std' => '#ffccff'
);
```

#### datetime

```php
$meta[] = array(
	'id' => 'timeDemo',
	'title' => 'Time Title',
	'desc' => '',
	'type' => 'datetime' // important
);
```

#### image

```php
$meta[] = array(
	'id' => 'imgDemo',
	'title' => 'Image Title',
	'desc' => '',
	'type' => 'image', // important!
	'button_text' => 'Choose a picture',
	'std' => ''
);
```

#### audio

```php
$meta[] = array(
	'id' => 'audioDemo',
	'title' => 'Audio Title',
	'desc' => '',
	'type' => 'audio', // important!
	'button_text' => 'Choose an audio',
	'std' => ''
);
```

#### video

```php
$meta[] = array(
	'id' => 'videoDemo',
	'title' => 'Video Title',
	'desc' => '',
	'type' => 'video', // important!
	'button_text' => 'Choose a video'
);
```
#### editor

```php
$meta[] = array(
	'id' => 'editorDemo',
	'title' => 'Editor Title',
	'desc' => '',
	'type' => 'editor', // important!
	'std' => ''
);
```






