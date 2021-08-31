<?php

if( !class_exists( 'WP_List_Table' ) ) {
  require_once( ABSPATH . 'wp-admin/includes/screen.php' );
  require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Shortcode_List_Table_4536 extends WP_List_Table {

	function __construct( $args = [] ) {
	 	parent::__construct([
 			'singular' => 'shortcode',
 			// 'plural' => 'shortcode',
 			'screen' => isset( $args['screen'] ) ? $args['screen'] : null,
			'ajax' => false,
	 	]);
	}

  function column_cb( $item ) {
    return sprintf(
      '<input type="checkbox" name="%1$s[]" value="%2$s" />',
      $this->_args['singular'],
      $item['ID']
    );
  }

  function column_title( $item ) {
    $title = sprintf( '<a href="?page=%s&action=%s&ID=%d">' . $item['title'] . '</a>', $_REQUEST['page'], 'edit', $item['ID'] );
    $actions = [
      'edit' => sprintf(
        '<a href="?page=%s&action=%s&ID=%d&shortcode_nonce=%s">編集</a>',
        $_GET['page'],
        'edit',
        $item['ID'],
        wp_create_nonce( $item['ID'] )
      ),
      'delete' => sprintf(
        '<a href="?page=%s&action=%s&ID=%d&shortcode_nonce=%s" onClick="%s">削除</a>',
        $_GET['page'],
        'delete',
        $item['ID'],
        wp_create_nonce( $item['ID'] ),
        "if( confirm('このショートコードを削除してもいいですか？') ) {return true;} return false;" ),
    ];
    return sprintf( '%1$s %2$s', $title, $this->row_actions($actions) );
  }

  function column_tag( $item ) {
    return sprintf(
      '<input type="text" readonly onfocus="this.select();" value="[%s]" />',
      $item['tag']
    );
  }

  function column_author( $item ) {
    return get_the_author_meta( 'display_name', $item['author'] );
  }

  function column_date( $item ) {
    return date( 'Y年n月j日', strtotime( $item['date'] ) );
  }

  function get_columns() {
		return [
			'cb'		=> '<input type="checkbox" />',
			'title'		=> __( 'タイトル' ),
			'tag'	=> __( 'ショートコード' ),
			'author'		=> __( '作成者' ),
			'date'	=> __( '日付' ),
		];
	}

  function get_sortable_columns() {
    return [
      'title' => [ 'title', false ],
      'author'    => [ 'author', false ],
      'date'  => [ 'date', false ]
    ];
  }

  function get_bulk_actions() {
    return [ 'bulk_delete_4536' => '削除' ];
  }

  // function process_bulk_action() {
  //   if( $this->current_action() === 'bulk_delete_4536' ) {
  //     // wp_die('項目が削除されました。');
  //   }
  // }

  function prepare_items( $data = null ) {
    global $wpdb;
    $per_page = 10;
    $columns = $this->get_columns();
    $hidden = [];
    $sortable = $this->get_sortable_columns();
    $this->_column_headers = [ $columns, $hidden, $sortable ];
    $this->process_bulk_action();
    function usort_reorder( $a, $b ) {
      $orderby = ( !empty( $_REQUEST['orderby'] ) ) ? $_REQUEST['orderby'] : 'date';
      $order = ( !empty( $_REQUEST['order'] ) ) ? $_REQUEST['order'] : 'asc';
      $result = strcmp( $a[$orderby], $b[$orderby] );
      return ( $order === 'asc' ) ? $result : -$result;
    }
    usort( $data, 'usort_reorder' );
    $current_page = $this->get_pagenum();
    $total_items = count( $data );
    $data = array_slice( $data, ( ($current_page-1) * $per_page ), $per_page );
    $this->items = $data;
    $this->set_pagination_args([
      'total_items' => $total_items,
      'per_page' => $per_page,
      'total_pages' => ceil($total_items/$per_page)
    ]);
  }

	function no_items() {
  	_e( 'ショートコードが設定されていません' );
	}

	/**
	 * プライマリカラム名を返す
	 * @return string
	 */
	function get_primary_column_name() {
		return 'title';
	}

}

class Shortcode_Setting_4536 {

	static $instance;
	public $wp_list_table;

  public $txt_arr = [
    'common_text' => '共通',
    'mobile_text' => 'スマホ',
    'pc_text' => 'PC',
    'amp_text' => 'AMP',
  ];

	public function __construct() {
		add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 3 );
    add_action( 'admin_init', [$this, 'create_table'] );
		add_action( 'admin_menu', [$this, 'admin_menu'] );
    add_action( 'admin_init', [$this, 'delete'] );
    // delete_option( '4536_shortcode_last_id' );
    if( isset( $_POST['add_new_shortcode_setting_submit_4536'] ) ) {
      $this->nonce_check();
      insert_db_table_record( SHORTCODE_TABLE, $this->post_data() );
      global $wpdb;
      update_option( '4536_shortcode_last_id', ++$wpdb->insert_id );
      add_action( 'admin_notices', function() {
        echo '<div class="updated"><p>新しいショートコードを追加しました。</p></div>';
      });
    }
    if( isset( $_POST['update_shortcode_setting_submit_4536'] ) && ( isset( $_GET['ID'] ) && !is_null( $_GET['ID'] ) ) ) {
      $this->nonce_check();
      update_db_table_record( SHORTCODE_TABLE, $this->post_data( 'modified' ), ['ID' => $_GET['ID']], null, ['%d'] );
      add_action( 'admin_notices', function() {
        echo '<div class="updated"><p>変更を保存しました。</p></div>';
      });
    }
    if( isset( $_POST['action'] ) && $_POST['action'] === 'bulk_delete_4536' ) {
      if( !isset( $_POST['shortcode'] ) ) {
        add_action( 'admin_notices', function() {
          echo '<div class="error"><p>削除する項目にチェックを入れてください。</p></div>';
        });
      } else {
        if( wp_verify_nonce( $_POST['hidden_delete_nonce'], 'hidden_delete_nonce' ) !== 1 ) {
          $msg = '<p>不正なリクエストが送信されました。</p><p><a href="?page=shortcode">ショートコードメニューに戻る</a></p>';
          wp_die( $msg );
        };
        global $wpdb;
        $ids = implode( ',', array_map( 'absint', $_POST['shortcode'] ) );
        $count = $_POST['shortcode'];
        $wpdb->query( "DELETE FROM " . SHORTCODE_TABLE . " WHERE ID IN($ids)" );
        add_action( 'admin_notices', function() use( $count ) {
          echo '<div class="updated"><p>'. count( $count ) .'個の項目を削除しました。</p></div>';
        });
      }
    }
	}

	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	public function admin_menu() {
		$menu = add_submenu_page( '4536-setting', 'ショートコード', 'ショートコード', 'manage_options', 'shortcode', [$this, 'form'] );
		add_action( "load-$menu", [$this, 'screen_option'] );
	}

	public function screen_option() {
		add_screen_option( $option, $args );
		$this->wp_list_table = new Shortcode_List_Table_4536();
	}

  function create_table() {
    global $wpdb;
    $db_version = '1.0';
    $installed_ver = get_option( '4536_shortcode_db_version' );
    if(
      !is_null( $wpdb->get_row("SHOW TABLES FROM " . DB_NAME . " LIKE '" . SHORTCODE_TABLE . "'") ) &&
      ( $db_version === $installed_ver )
      ) return;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE " . SHORTCODE_TABLE . " (
      ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      author bigint(20) UNSIGNED DEFAULT '1' NOT NULL,
      title varchar(60) NOT NULL,
      tag varchar(60) NOT NULL,
      common_text text NULL,
      mobile_text text NULL,
      pc_text text NULL,
      amp_text text NULL,
      wrap bit(1) NOT NULL DEFAULT b'0',
      date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      modified datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      UNIQUE KEY id (ID)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    update_option( '4536_shortcode_db_version', $db_version );
  }

	public function form() {
    $link_to_new = '<a href="' . add_query_arg( 'action', 'new' ) . '" class="page-title-action">新規追加</a>';
    if( filter_input( INPUT_GET, 'action' ) && $_GET['action'] === 'new' || $_GET['action'] === 'edit' ) {
      if( isset( $_GET['ID'] ) && !is_null( $_GET['ID'] ) ) {
        $id = intval( $_GET['ID'] );
        $link_to_new = remove_query_arg( ['ID', 'shortcode_nonce'] );
        $link_to_new = '<a href="' . add_query_arg( 'action', 'new', $link_to_new ) . '" class="page-title-action">新規追加</a>';
        $h1 = 'ショートコードの編集';
        $data = get_db_table_record( SHORTCODE_TABLE, $id );
        $submit = get_submit_button( '変更を保存', 'primary large', 'update_shortcode_setting_submit_4536', $wrap, $other_attributes );
        $button_args = [
          'onClick' => "if( confirm('このショートコードを削除してもいいですか？') ) {return true;} return false;",
          'style' => 'color:#a00',
        ];
        $action = add_query_arg([ 'ID' => $id, 'action' => 'edit' ]);
        $delete_submit = get_submit_button( '削除', 'delete large', 'delete_shortcode_setting_submit_4536', $wrap, $button_args );
      } else {
        $id = get_option( '4536_shortcode_last_id', 1 );
        $link_to_new = '';
        $h1 = 'ショートコードの新規追加';
        $action = add_query_arg([ 'ID' => $id, 'action' => 'edit', 'shortcode_nonce' => wp_create_nonce( $id ) ]);
        $submit = get_submit_button( '保存', 'primary large', 'add_new_shortcode_setting_submit_4536', $wrap, $other_attributes );
      }
      $link_to_list = '<a href="' . menu_page_url( 'shortcode', false ) . '" class="page-title-action">一覧</a>';
      ob_start(); ?>
      <div id="poststuff">
        <div id="post-body" class="columns-2">
          <div id="post-body-content">
            <div id="titlediv">
              <div id="titlewrap">
                <input type="text" value="<?php if( isset( $data ) ) echo $data->title; ?>" name="shortcode_title" size="30" id="title" spellcheck="true" autocomplete="off" placeholder="タイトルを入力" />
              </div>
            </div>
            <div class="metabox-holder">
              <div class="postbox" >
                <h3 class="hndle">ショートコード名</h3>
                <div id="shortcode_section" class="inside">
                  <p class="description">
                    <label for="shortcode_tag">使いやすいように自由に名前を設定できます。未入力の場合はタイトルの文字が使われます。タイトルが未入力の場合は自動生成します。</label>
                    <input type="text" value="<?php if( isset( $data ) ) echo $data->tag; ?>" name="shortcode_tag" pattern="\S+" size="30" id="shortcode_tag" spellcheck="true" autocomplete="off" placeholder="ショートコード名" />
                  </p>
                  <p>
                    <label for="shortcode">このショートコードをコピーして、本文またはウィジェット内にペーストしてください。</label>
                    <input type="text" readonly onfocus="this.select();" value="[<?php if( isset( $data ) ) echo $data->tag; ?>]" size="30" id="shortcode" />
                  </p>
                  <p class="button" id="copy"><i class="far fa-copy"></i> コピーする</p>
                </div>
              </div>
            </div>
            <script>
              $(function() {
                $('#shortcode_tag').on('keyup change',function() {
                	$('#shortcode').val( '[' + $('#shortcode_tag').val() + ']' );
                })
              });
              function copy() {
                const copyText = document.querySelector("#shortcode");
                copyText.select();
                document.execCommand("copy");
              }
              document.querySelector("#copy").addEventListener("click", copy);
            </script>
            <div class="metabox-holder">
              <div class="postbox">
                <div class="tabs">
                  <?php
                  $no = 0;
                  foreach( $this->txt_arr as $key => $value ) {
                    $checked = ( $no === 0 ) ? ' checked' : '';
                    $no++;
                    ?>
                    <input id="<?php echo $key; ?>" type="radio" name="tab_item"<?php echo $checked; ?>>
                    <label class="tab_item" for="<?php echo $key; ?>"><?php echo $value; ?></label>
                  <?php }
                  foreach( $this->txt_arr as $key => $value ) { ?>
                    <fieldset class="tab_content" id="<?php echo $key; ?>_content">
                      <textarea name="<?php echo $key; ?>" rows="15" cols="100" class="code" style="width:100%"><?php if( isset( $data ) ) echo $data->$key; ?></textarea>
                    </fieldset>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <div id="postbox-container-1">
            <div class="postbox" >
              <h3 class="hndle">ヘルプ</h3>
              <div class="inside">
                <p><i class="fas fa-info-circle"></i><a href="https://4536.jp/shortcode" target="_blank">ショートコード設定について</a></p>
              </div>
            </div>
            <div class="postbox" >
              <h3 class="hndle">自動整形</h3>
              <div id="shortcode_section" class="inside">
                <p>
                  <?php if( isset( $data ) ) $wrap = $data->wrap; ?>
                  <label><input type="checkbox" value="1" name="shortcode_wrap" <?php checked( $wrap, 1 );?>/>自動整形する</label>
                </p>
                <p class="description">※通常の本文のように自動整形機能をオンにする場合はチェックを入れてください。全体をPタグで囲み、改行はbrタグに変換されます。</p>
              </div>
            </div>
            <div id="submitdiv" class="postbox">
              <h3 class="hndle">ステータス</h3>
              <div class="inside">
                <div id="submitpost" class="submitbox">
                  <div id="major-publishing-actions">
                    <div id="publishing-action">
                      <span class="spinner"></span>
                      <?php echo $submit; ?>
                    </div>
                    <div id="delete-action">
                      <?php echo $delete_submit; ?>
                    </div>
                    <div style="clear:both"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      $this->form_style();
      $form_inner = ob_get_clean();
		} else {
      $action = '';
      $h1 = 'ショートコード設定';
      global $wpdb;
      $data = $wpdb->get_results( "SELECT * FROM " . SHORTCODE_TABLE, ARRAY_A );
      ob_start();
      $this->wp_list_table->prepare_items( $data );
      $this->wp_list_table->display();
      $form_inner = ob_get_clean();
      $hidden_delete_nonce = wp_nonce_field( 'hidden_delete_nonce', 'hidden_delete_nonce', false, false );
    }
    ?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php echo $h1; ?></h1>
      <?php
      if( isset( $link_to_list ) ) echo $link_to_list;
      if( !empty( $link_to_new ) ) echo $link_to_new;
      ?>
			<hr class="wp-header-end">
			<form method="post" action="<?php echo $action; ?>">
				<?php
        if( isset( $hidden_delete_nonce ) ) echo $hidden_delete_nonce;
        echo $form_inner;
        ?>
			</form>
		</div>
	<?php }

  function post_data( $time = 'date' ) {
    $master_arr = [];
    $master_arr['title'] = ( isset( $_POST['shortcode_title'] ) && !empty( $_POST['shortcode_title'] ) ) ? esc_html( trim( stripslashes_deep( $_POST['shortcode_title'] ) ) ) : '(タイトルなし)' ;
    if( isset( $_POST['shortcode_tag'] ) ) {
      if( !empty( $_POST['shortcode_tag'] ) ) {
        $tag = $_POST['shortcode_tag'];
      } elseif( !empty( $_POST['shortcode_title'] ) ) {
        $tag = $_POST['shortcode_title'];
      } else {
        $id = ( !empty( $_GET['ID'] ) ) ? $_GET['ID'] : get_option( '4536_shortcode_last_id', 1 );
        $tag = '4536-shortcode-' . intval( $id );
      }
    }
    $tag = str_replace( [' ', '　'], '', $tag );
    $master_arr['tag'] = esc_html( trim( stripslashes_deep( $tag ) ) );
    foreach( $this->txt_arr as $key => $value ) {
      $master_arr[$key] = isset( $_POST[$key] ) && !empty( $_POST[$key] ) ? trim( stripslashes_deep( $_POST[$key] ) ) : NULL;
    }
    $master_arr['wrap'] = isset( $_POST['shortcode_wrap'] ) ? true : false;
    $master_arr['author'] = wp_get_current_user()->ID;
    switch( $time ) {
      case 'date':
        $master_arr['date'] = current_time( 'mysql' );
        break;
      case 'modified':
        $master_arr['modified'] = current_time( 'mysql' );
        break;
    }
    return $master_arr;
  }

  function delete() {
    if( ( filter_input( INPUT_GET, 'page' ) === 'shortcode' && filter_input( INPUT_GET, 'action' ) === 'delete' ) ||
    ( isset( $_POST['delete_shortcode_setting_submit_4536'] ) ) &&
    ( isset( $_GET['ID'] ) && !is_null( $_GET['ID'] ) )
    ) {
      $this->nonce_check();
      delete_db_table_record( SHORTCODE_TABLE, ['ID' => $_GET['ID']], ['%d'] );
      wp_safe_redirect( menu_page_url( 'shortcode', false ) );
      exit();
    }
  }

  function form_style() { ?>
    <style>
      #shortcode_section input[type="text"] {
        display: block;
      }
      .tabs {
        width: 100%;
      }
      .tab_item {
        box-sizing: border-box;
        width: calc(100%/4);
        line-height: 1.6;
        padding: .5em;
        border-bottom: 3px solid #00acff;
        border-right: 1px solid #00acff;
        background-color: #d9d9d9;
        font-size: 14px;
        text-align: center;
        color: #565656;
        display: block;
        float: left;
        text-align: center;
        font-weight: bold;
        transition: all 0.2s ease;
      }
      .tab_item:last-of-type {
        border-right: none;
      }
      .tab_item:hover {
        opacity: 0.75;
      }
      input[name="tab_item"] {
        display: none;
      }
      .tab_content {
        display: none;
        padding: 1.5em;
        clear: both;
        overflow: hidden;
      }
      #common_text:checked ~ #common_text_content,
      #mobile_text:checked ~ #mobile_text_content,
      #pc_text:checked ~ #pc_text_content,
      #amp_text:checked ~ #amp_text_content {
        display: block;
      }
      .tabs input:checked + .tab_item {
        background-color: #00acff;
        color: #fff;
      }
      .far,.fas {
        margin-right: 5px;
      }
    </style>
  <?php }

  function nonce_check() {
    if( wp_verify_nonce( $_GET['shortcode_nonce'], $_GET['ID'] ) !== 1 ) {
      $msg = '<p>不正なリクエストが送信されました。</p><p><a href="?page=shortcode">ショートコードメニューに戻る</a></p>';
      wp_die( $msg );
    };
  }

}
new Shortcode_Setting_4536();

//-------------------リファレンス----------------------------//
// https://elearn.jp/wpman/column/c20170823_01.html
// https://elearn.jp/wpman/column/c20170926_01.html
// https://www.sitepoint.com/using-wp_list_table-to-create-wordpress-admin-tables/
// https://wpdocs.osdn.jp/%E3%83%97%E3%83%A9%E3%82%B0%E3%82%A4%E3%83%B3%E3%81%A7%E3%83%87%E3%83%BC%E3%82%BF%E3%83%99%E3%83%BC%E3%82%B9%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB%E3%82%92%E4%BD%9C%E3%82%8B
// http://wpcj.net/1745 ※開発用プラグイン「Custom List Table Example」の中身を翻訳してくれているサイト。理解しやすい
//--------------------------------------------------------//
