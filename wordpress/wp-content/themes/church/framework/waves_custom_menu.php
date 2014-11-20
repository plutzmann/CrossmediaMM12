<?php
/**
 * ThemeWaves Custom Menu
 */
class waves_custom_menu extends Walker_Nav_Menu {
    var $isMega=false;
    var $column=false;
    var $columnCnt=0;
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $class = $attr = '';
        if($this->isMega&&$depth===1){
            $class.=' mega-menu-items';
        }elseif($this->isMega&&$depth===0){
            $class.=' waves-mega-menu '.$this->column;
            $attr .=' data-col="'.$this->column.'"';
        }
        $output .= "\n$indent<ul class=\"sub-menu".$class."\"".$attr.">\n";
    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
    }
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        /**
         * Filter the CSS class(es) applied to a menu item's <li>.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        if(isset($item->megamenu)&&$item->megamenu&&$depth===0){
            $this->isMega=true;
            if(!empty($item->column)&&$depth===0){
                $this->column='column-'.$item->column;
            }else{
                $this->column='column-2';
            }
        }
        if($this->isMega&&$depth===1){
            $class_names .=' '.$depth.'-'.$this->columnCnt;
            if($class_names&&$this->columnCnt===0){
                $class_names.=' row-start';
            }
            if(++$this->columnCnt >= intval(str_replace('column-', '', $this->column))){
                $this->columnCnt=0;
            }
        }
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's <li>.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        /**
         * Filter the HTML attributes applied to a menu item's <a>.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                        $attributes .= ' ' . $attr . '="' . $value . '"';
                }
        }
        $show = true;
        $item_output='';
        if($depth===1&&isset($item->hidetitle)&&$item->hidetitle){
            $show = false;
        }
        if($show){
            $item_output = $args->before;
            if($this->isMega&&$depth===1){
                $item_output .= '<div class="mega-menu-title">';
            }else{
                $item_output .= '<a'. $attributes .'>';
            }
                /** This filter is documented in wp-includes/post-template.php */
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            if($this->isMega&&$depth===1){
                $item_output .= '</div>';
            }else{
                $item_output .= '</a>';
            }
            $item_output .= $args->after;
        }
        /**
         * Filter a menu item's starting output.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if($depth===0){$this->isMega=false;$this->columnCnt=0;}
        $output .= "</li>\n";
    }
}

/**
 * Add Custom Fields to ThemeWaves Custom Menu
 */
add_filter('wp_setup_nav_menu_item','waves_custom_menu_add_custom_fields');
function waves_custom_menu_add_custom_fields( $menu_item ) {
    $menu_item->megamenu   = get_post_meta( $menu_item->ID, '_waves_megamenu',  true );
    $menu_item->column     = get_post_meta( $menu_item->ID, '_waves_column',    true );
    $menu_item->hidetitle  = get_post_meta( $menu_item->ID, '_waves_hidetitle', true );
    return $menu_item;
}

/**
 * ThemeWaves Custom Menu Edit
 */
add_filter( 'wp_edit_nav_menu_walker', 'custom_edit_nav_menu_walker' , 100);
function custom_edit_nav_menu_walker($name){return 'waves_custom_menu_edit';}
class waves_custom_menu_edit extends Walker_Nav_Menu {
    /**
     * Starts the list before the elements are added.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {}

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker_Nav_Menu::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   Not used.
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {}

    /**
     * Start the element output.
     *
     * @see Walker_Nav_Menu::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   Not used.
     * @param int    $id     Not used.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $_wp_nav_menu_max_depth;
        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

        ob_start();
        $item_id = esc_attr( $item->ID );
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );

        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = get_the_title( $original_object->ID );
        }

        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );

        $title = $item->title;

        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( __( '%s (Invalid)', 'themewaves' ), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( __('%s (Pending)', 'themewaves'), $item->title );
        }

        $title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

        $submenu_text = '';
        if ( 0 == $depth )
            $submenu_text = 'style="display: none;"'; ?>
        <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                    <span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo $submenu_text; ?>><?php _e( 'sub item', 'themewaves' ); ?></span></span>
                    <span class="item-controls">
                        <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-order hide-if-js">
                                    <a href="<?php
                                            echo wp_nonce_url(
                                                    add_query_arg(
                                                            array(
                                                                    'action' => 'move-up-menu-item',
                                                                    'menu-item' => $item_id,
                                                            ),
                                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                                    ),
                                                    'move-menu_item'
                                            );
                                    ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'themewaves'); ?>">&#8593;</abbr></a>
                                    |
                                    <a href="<?php
                                            echo wp_nonce_url(
                                                    add_query_arg(
                                                            array(
                                                                    'action' => 'move-down-menu-item',
                                                                    'menu-item' => $item_id,
                                                            ),
                                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                                    ),
                                                    'move-menu_item'
                                            );
                                    ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'themewaves'); ?>">&#8595;</abbr></a>
                        </span>
                        <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item', 'themewaves'); ?>" href="<?php echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ); ?>">
                            <?php _e( 'Edit Menu Item', 'themewaves' ); ?>
                        </a>
                    </span>
                </dt>
            </dl>
            <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>"><?php
                if( 'custom' == $item->type ) : ?>
                    <p class="field-url description description-wide">
                        <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                            <?php _e( 'URL', 'themewaves' ); ?><br />
                            <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                        </label>
                    </p><?php
                endif; ?>
                <p class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                        <?php _e( 'Navigation Label', 'themewaves' ); ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                        <?php _e( 'Title Attribute', 'themewaves' ); ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                    </label>
                </p>
                <p class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                        <?php _e( 'Open link in a new window/tab', 'themewaves' ); ?>
                    </label>
                </p>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                        <?php _e( 'CSS Classes (optional)', 'themewaves' ); ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                    </label>
                </p>
                <p class="field-xfn description description-thin">
                    <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                        <?php _e( 'Link Relationship (XFN)', 'themewaves' ); ?><br />
                        <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                    </label>
                </p>
                <p class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                        <?php _e( 'Description', 'themewaves' ); ?><br />
                        <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                        <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', 'themewaves'); ?></span>
                    </label>
                </p>
                <p class="field-move hide-if-no-js description description-wide">
                    <label>
                        <span><?php _e( 'Move', 'themewaves' ); ?></span>
                        <a href="#" class="menus-move-up"><?php _e( 'Up one', 'themewaves' ); ?></a>
                        <a href="#" class="menus-move-down"><?php _e( 'Down one', 'themewaves' ); ?></a>
                        <a href="#" class="menus-move-left"></a>
                        <a href="#" class="menus-move-right"></a>
                        <a href="#" class="menus-move-top"><?php _e( 'To the top', 'themewaves' ); ?></a>
                    </label>
                </p>
                <div class="waves-menu-options">
                    <h4><?php _e('Custom Options','themewaves'); ?></h4>
                    <p class="field-waves field-waves-hide-title description description-thin">
                        <label for="edit-menu-hide-title-<?php echo $item_id; ?>">
                            <input type="checkbox" id="edit-menu-hide-title-<?php echo $item_id; ?>" class="edit-menu-item-waves" name="menu-hide-title[<?php echo $item_id; ?>]" value="1" <?php echo checked( !empty( $item->hidetitle ), 1, false ); ?> />
                            <?php _e( 'Hide','themewaves' ); ?>
                        </label>
                    </p>
                    <p class="field-waves field-waves-is-mega description description-thin">
                        <label for="edit-menu-is-mega-<?php echo $item_id; ?>">
                            <input type="checkbox" id="edit-menu-is-mega-<?php echo $item_id; ?>" class="edit-menu-item-waves" name="menu-is-mega[<?php echo $item_id; ?>]" value="1" <?php echo checked( !empty( $item->megamenu ), 1, false ); ?> />
                            <?php _e( 'Is Mega Menu','themewaves' ); ?>
                        </label>
                    </p>
                    <p class="field-waves field-waves-column description description-thin">
                        <label for="edit-menu-column-<?php echo $item_id; ?>">
                            <?php _e( 'Column','themewaves' ); ?>
                            <?php if(empty($item->column)){$item->column='2';} ?>
                            <select id="edit-menu-column-<?php echo $item_id; ?>" class="edit-menu-item-waves" name="menu-column[<?php echo $item_id; ?>]">
                                <option value="2"<?php if($item->column==='2'){echo ' selected="selected"';} ?>><?php _e( '2 Columns','themewaves' ); ?></option>
                                <option value="3"<?php if($item->column==='3'){echo ' selected="selected"';} ?>><?php _e( '3 Columns','themewaves' ); ?></option>
                                <option value="4"<?php if($item->column==='4'){echo ' selected="selected"';} ?>><?php _e( '4 Columns','themewaves' ); ?></option>
                                <option value="5"<?php if($item->column==='5'){echo ' selected="selected"';} ?>><?php _e( '5 Columns','themewaves' ); ?></option>
                            </select>
                        </label>
                    </p>
                </div>
                <div class="menu-item-actions description-wide submitbox"><?php
                    if( 'custom' != $item->type && $original_title !== false ) : ?>
                        <p class="link-to-original"><?php printf( __('Original: %s', 'themewaves'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?></p><?php
                    endif; ?>
                        <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                        echo wp_nonce_url(
                                add_query_arg(
                                        array(
                                                'action' => 'delete-menu-item',
                                                'menu-item' => $item_id,
                                        ),
                                        admin_url( 'nav-menus.php' )
                                ),
                                'delete-menu_item_' . $item_id
                        ); ?>">
                            <?php _e( 'Remove', 'themewaves' ); ?>
                        </a>
                        <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) ); ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel', 'themewaves'); ?></a>
                </div>
                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul><?php
        $output .= ob_get_clean();
    }
}
add_action('admin_init', 'waves_custom_menu_admin_scripts');
function waves_custom_menu_admin_scripts(){
    if(basename( $_SERVER['PHP_SELF']) == "nav-menus.php" ){
        wp_enqueue_script('waves-custom-menu-admin-scripts', WAVES_DIR . 'js/admin-waves-custom-menu.js',array('jquery', 'jquery-ui-sortable'), false, true ); 
    }
}
add_action('admin_print_styles', 'waves_custom_menu_admin_styles');
function waves_custom_menu_admin_styles() {
    if(basename( $_SERVER['PHP_SELF']) == "nav-menus.php" ){
        wp_enqueue_style('waves-custom-menu-admin-styles', WAVES_DIR . 'css/admin-waves-custom-menu.css');
    }
}

/**
 * Save menu custom fields
 */
add_action( 'wp_update_nav_menu_item', 'waves_custom_menu_item', 100, 3);
function waves_custom_menu_item( $menu_id, $menu_item_db_id, $args ) {
    if (isset( $_REQUEST['menu-is-mega'][$menu_item_db_id])) {
        update_post_meta( $menu_item_db_id, '_waves_megamenu', 1 );
    }else{
        update_post_meta( $menu_item_db_id, '_waves_megamenu', 0 );
    }
    if (isset( $_REQUEST['menu-column'][$menu_item_db_id])) {
        update_post_meta( $menu_item_db_id, '_waves_column', $_REQUEST['menu-column'][$menu_item_db_id] );
    }
    if (isset( $_REQUEST['menu-hide-title'][$menu_item_db_id])) {
        update_post_meta( $menu_item_db_id, '_waves_hidetitle', 1 );
    }else{
        update_post_meta( $menu_item_db_id, '_waves_hidetitle', 0 );
    }
}