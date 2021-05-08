<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Shortcodes
 *
 * @class Shortcodes
 */
class Equipeer_Shortcodes extends Equipeer {

    /**
     *  Equipeer template shortcodes __construct
     *  Initial loaded when class create an instance
     *
     *  @since 1.0.1
     */
    function __construct() {
        // TITLE Tag in header HTML (Rewrite)
        add_shortcode('equine-single-title', array( $this, 'single_title_shortcode' ) );
        // ADD TO SELECTION Button
        add_shortcode('equine-add-to-selection', array( $this, 'add_to_selection' ) );
        // ADD TO SELECTION Button Mini
        add_shortcode('equine-add-to-selection-mini', array( $this, 'add_to_selection_mini' ) );
        // PREV - RETURN ADS - NEXT Buttons
        add_shortcode('equine-prev-list-next', array( $this, 'prev_list_next' ) );
        add_shortcode('equine-prev-list-next-mob', array( $this, 'prev_list_next_mob' ) );
        // SAVE MY SEARCH Button
        add_shortcode('equine-save-my-search', array( $this, 'save_my_search' ) );
        // SEE MY SELECTION Button
        add_shortcode('equine-see-my-selection', array( $this, 'see_my_selection' ) );
        // SEND MY SELECTION Button
        add_shortcode('equine-send-my-selection', array( $this, 'send_my_selection' ) );
        // QUESTIONNAIRE PROJET Form
        add_shortcode('equine-questionnaire-projet', array( $this, 'questionnaire_projet' ) );
    }

    /**
     * Customize the title for Equine Single Page
     *
     * @param string $title The original title
     * 
     * @return string The title to use
     */
    function single_title_shortcode() {
        $equipeer_title = equipeer_head_text_horse( get_the_ID(), false );
        return $equipeer_title;
    }
    
    /**
     * Add buttons PREV / RETURN TO LIST / NEXT
     *
     * @return string
     */
    function prev_list_next() {
        global $post, $_SESSION;
        $buttons    = "";
        $return_ads = (isset($_SESSION['equipeer_list_back']) && $_SESSION['equipeer_list_back'] != '') ? $_SESSION['equipeer_list_back'] : get_site_url() . '/annonces/';
        // Check if user comes from list result (SESSION in progress)
        if (!isset($_SESSION['equipeer_user_list'])) equipeer_get_prev_list_next();
        // Get the current array key
        $key  = array_search (get_the_ID(), $_SESSION['equipeer_user_list']);
        // PREV (ID value)
        $prev = equipeer_previous_element($_SESSION['equipeer_user_list'], $key);
        $prev_class = (!$prev) ? ' disabled' : '';
        // NEXT (ID value)
        $next = equipeer_next_element($_SESSION['equipeer_user_list'], $key);
        $next_class = (!$next) ? ' disabled' : '';
        // PREV - RETURN ADS - NEXT
        $buttons .= '<div class="btn-group mb-3" style="width: 100%;">
                        <a class="btn eq-button-blue'.$prev_class.'" data-test="'.$prev.'" href="'.get_permalink( $prev ).'" role="button">' . __( 'Prev.', EQUIPEER_ID ) . '</a>
                        <a class="btn eq-button-red btn-block" href="' . $return_ads . '" role="button">' . __( 'Return to list', EQUIPEER_ID ) . '</a>
                        <a class="btn eq-button-blue'.$next_class.'" data-test="'.$next.'" href="'.get_permalink( $next ).'" role="button">' . __( 'Next.', EQUIPEER_ID ) . '</a>
                    </div>';
        // ADD TO MY SELECTION
        $ad_type = get_post_meta( get_the_ID(), 'type_annonce', true );
        // Type 1 : libre
        // Type 2 : expertise
        // Check if expertise ads
        if ($ad_type == 2) {
            // Check if horse is solded
            $horse_sold      = (get_post_meta( get_the_ID(), 'sold', true ) == 1) ? true : false;
            $type_annonce    = get_post_meta( get_the_ID(), 'type_annonce', true ); // 1: Libre - 2: Expertise
            $horse_expertise = (get_post_meta( get_the_ID(), 'to_expertise', true ) == 1 && $type_annonce == 2) ? true : false;
            if ($horse_expertise && !$horse_sold) {
                // Add to my selection authorized
                $buttons .= do_shortcode('[equine-add-to-selection pid="'.get_the_ID().'" uid="' . get_current_user_id() . '" op="' . equipeer_get_selection(get_the_ID(),  get_current_user_id() ) . '" group="true"]');
            }
        } else {
            // So, show the contact seller button
            $button_text = __( 'Contact seller', EQUIPEER_ID );
            // --- Check if user is logged in
            if (is_user_logged_in()) {
                $user_email = get_post_meta( get_the_ID(), 'owner_email', true );
                $user_id    = get_user_by( "email", $user_email );
                $buttons .= '<div id="eqmessagerie" style="display: none;"></div>'; // Ne pas supprimer
                //$buttons .= do_shortcode('[yobro_chat_new_message user_id='.$user_id->ID.']');
            } else {
                $buttons .= '<div class="btn-group btn-group-toggle mb-3" style="width: 100%;" data-toggle="buttons">
                                <a role="button" class="btn eq-button-red btn-lg btn-block equipeer-not-connected" pid="'.get_the_ID().'" uid="' . get_current_user_id() . '" href="#" ' . $this->attributes_button_not_connected($button_text) . '><i class="fas fa-comments"></i>&nbsp;&nbsp;' . __('Contact seller', EQUIPEER_ID) . '</a>
                             </div>';
            }
        }
        
        return $buttons;
    }
    
    /**
     * Add buttons PREV / RETURN TO LIST / NEXT
     *
     * @return string
     */
    function prev_list_next_mob() {
        global $post, $_SESSION;
        $buttons    = "";
        $return_ads = (isset($_SESSION['equipeer_list_back']) && $_SESSION['equipeer_list_back'] != '') ? $_SESSION['equipeer_list_back'] : get_site_url() . '/annonces/';
        // Check if user comes from list result (SESSION in progress)
        if (!isset($_SESSION['equipeer_user_list'])) equipeer_get_prev_list_next();
        // Get the current array key
        $key  = array_search (get_the_ID(), $_SESSION['equipeer_user_list']);
        // PREV (ID value)
        $prev = equipeer_previous_element($_SESSION['equipeer_user_list'], $key);
        $prev_class = (!$prev) ? ' disabled' : '';
        // NEXT (ID value)
        $next = equipeer_next_element($_SESSION['equipeer_user_list'], $key);
        $next_class = (!$next) ? ' disabled' : '';
        // ---------------------------------------------------
        // PREV - RETURN ADS - NEXT - ADD TO SELECTION or CHAT
        // ---------------------------------------------------
        $ad_type = get_post_meta( get_the_ID(), 'type_annonce', true );
        //$button_group = ($ad_type == 1 && is_user_logged_in()) ? 3 : 4;
        $button_group = 4;
        $buttons .= '<div class="btn-group mb-'.$button_group.'" style="width: 100%;">
                        <a class="btn eq-button-blue'.$prev_class.'" style="border-radius: 0;" data-test="'.$prev.'" href="'.get_permalink( $prev ).'" role="button">' . __( 'Prev.', EQUIPEER_ID ) . '</a>
                        <a class="btn eq-button-red btn-block" href="' . $return_ads . '" role="button">' . __( 'Return to list', EQUIPEER_ID ) . '</a>
                        <a class="btn eq-button-blue'.$next_class.'" data-test="'.$next.'" href="'.get_permalink( $next ).'" role="button">' . __( 'Next.', EQUIPEER_ID ) . '</a>';
        if ($ad_type == 1 && is_user_logged_in()) {
            // Close to show CHAT DIV
            //$buttons .= '</div>';
        }
        // ---------------------------------------------------
        // ADD TO MY SELECTION
        // ---------------------------------------------------
        // Type 1 : libre
        // Type 2 : expertise
        // Check if expertise ads
        if ($ad_type == 2) {
            // Check if horse is solded
            $horse_sold = (get_post_meta( get_the_ID(), 'sold', true ) == 1) ? true : false;
            if (!$horse_sold) {
                // Add to my selection authorized
                $buttons .= do_shortcode('[equine-add-to-selection mini="yes" pid="'.get_the_ID().'" uid="' . get_current_user_id() . '" op="' . equipeer_get_selection(get_the_ID(),  get_current_user_id() ) . '"]');
                //$buttons .= '</div>';
            }
        } else {
            // So, show the contact seller button
            $button_text = __( 'Contact seller', EQUIPEER_ID );
            // --- Check if user is logged in
            if (is_user_logged_in()) {
                //$buttons .= '<div class="btn-group btn-group-toggle mb-3" style="width: 100%;" data-toggle="buttons">
                                //<a role="button" class="btn eq-button-red btn-lg btn-block" pid="'.get_the_ID().'" uid="' . get_current_user_id() . '" href="#"><i class="fas fa-comments"></i>&nbsp;&nbsp;' . __('Contact seller', EQUIPEER_ID) . '</a>
                             //</div>';
                $user_email = get_post_meta( get_the_ID(), 'owner_email', true );
                $user_id    = get_user_by( "email", $user_email );
                //$buttons .= do_shortcode('[yobro_chat_new_message user_id='.$post->post_author.']');
                $buttons .= do_shortcode('[yobro_chat_new_message user_id='.$user_id->ID.']');
            } else {
                $buttons .= '<a style="border-radius: 0;" role="button" class="btn eq-button-red equipeer-not-connected" pid="'.get_the_ID().'" uid="' . get_current_user_id() . '" href="#" ' . $this->attributes_button_not_connected($button_text) . '><i class="fas fa-comments"></i></a>';
                //$buttons .= '</div>';
            }
        }
        // ---------------------------------------------------
        // END PREV - RETURN ADS - NEXT - ADD TO SELECTION or CHAT
        // ---------------------------------------------------
        $buttons .= '</div>';
        // ---------------------------------------------------        
        return $buttons;
    }
    
    /**
     * Add button ADD TO MY SELECTION (Single Equine Page)
     *
     * @param array  $atts    Shortcode attributes
     * @param string $content Shortcode content
     * @param string $tag     The shortcode which invoked the callback
     *
     * @return string
     */
    function add_to_selection($atts, $content, $tag) {
        $atts        = shortcode_atts( array( 'mini' => false, 'group' => false, 'pid' => 0, 'uid' => 0, 'op' => 'add' ), $atts );
        $pid         = intval($atts['pid']);
        $uid         = intval($atts['uid']);
        $op          = trim( $atts['op'] );
        if ($atts['mini']) {
            $button      = ($atts['group']) ? '<div class="btn-group btn-group-toggle mb-3" style="width: 100%;" data-toggle="buttons">' : '';
            $button_text = '<i class="fas fa-star"></i>';
        } else {
            $button      = ($atts['group']) ? '<div class="btn-group btn-group-toggle mb-3" style="width: 100%;" data-toggle="buttons">' : '';
            $button_text = '<i class="fas fa-star"></i>&nbsp;&nbsp;' . ( $op == 'add' ? __( 'Add to my selection', EQUIPEER_ID ) : __( 'Remove from my selection', EQUIPEER_ID ) );
        }
        // --- Check if user is logged in
        if (is_user_logged_in()) {
            // Horse infos
            $the_prefix       = get_term_meta( get_post_meta( $pid, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
            $the_reference    = equipeer_get_format_reference( @get_post_meta( $pid, 'reference', true ) );
            $the_discipline   = get_term_by( 'id', get_post_meta( $pid, 'discipline', true ), 'equipeer_discipline' )->name;
            $the_breed        = get_term_by( 'id', get_post_meta( $pid, 'breed', true ), 'equipeer_breed' )->name;
            $the_gender       = get_term_by( 'id', get_post_meta( $pid, 'sex', true ), 'equipeer_gender' )->name;
            $the_color        = get_term_by( 'id', get_post_meta( $pid, 'dress', true ), 'equipeer_color' )->name;
            $the_size         = get_post_meta( $pid, 'size_cm', true ) . ' cm';
            $the_age          = equipeer_get_age_by_year( get_post_meta( $pid, 'birthday', true ) );
            $the_potential    = @get_term_by( 'id', get_post_meta( $pid, 'potentiel', true ), 'equipeer_potential' )->name;
            $the_price        = equipeer_get_price( get_post_meta($pid, 'price_equipeer', true), false );
            $the_url          = get_permalink($pid);
            $the_localisation = equipeer_get_localisation_detail($pid, false);
            // image
            $photo_1_id       = @get_post_meta( $pid, 'photo_1', true );
            $the_photo_url    = ($photo_1_id) ? wp_get_attachment_image_src( $photo_1_id, array("133",  "100") ) : false;
            // User is connected
            if ($atts['mini']) {
                $button .= '<a style="border-radius: 0;" role="button" class="btn eq-button-red equine-' . $op . '-selection action-to-selection" data-pid="' . $pid . '" data-uid="' . $uid .'" data-op="' . $op . '" data-mini="true" data-ref="' . $the_prefix . '-' . $the_reference . '" data-sexe="' . $the_gender . '" data-robe="' . $the_color . '" data-taille="' . $the_size . '" data-discipline="' . $the_discipline . '" data-potentiel="' . $the_potential . '" data-photo="' . $the_photo_url[0] . '" data-price="' . $the_price . '" data-localisation="' . $the_localisation . '" data-url="' . $the_url . '" href="#">' . $button_text . '</a>';
            } else {
                $button .= '<a role="button" class="btn eq-button-red btn-lg btn-block equine-' . $op . '-selection action-to-selection" data-pid="' . $pid . '" data-uid="' . $uid .'" data-op="' . $op . '" data-ref="' . $the_prefix . '-' . $the_reference . '" data-sexe="' . $the_gender . '" data-robe="' . $the_color . '" data-taille="' . $the_size . '" data-discipline="' . $the_discipline . '" data-potentiel="' . $the_potential . '" data-photo="' . $the_photo_url[0] . '" data-price="' . $the_price . '" data-localisation="' . $the_localisation . '" data-url="' . $the_url . '" href="#">' . $button_text . '</a>';
            }
        } else {
            // User is not connected
            if ($atts['mini']) {
                $button .= '<button style="border-radius: 0;" class="btn eq-button-red equipeer-not-connected" ' . $this->attributes_button_not_connected($button_text) . '>' . $button_text . '</button>';
            } else {
                $button .= '<button class="btn eq-button-red btn-lg btn-block mb-3 w-100 equipeer-not-connected" ' . $this->attributes_button_not_connected($button_text) . '>' . $button_text . '</button>';
            }
        }
        $button .= ($atts['group']) ? '</div>' : '';
        
        return $button;
    }
    
    /**
     * Add mini button ADD TO MY SELECTION (Archive Equine Page)
     *
     * @param array  $atts    Shortcode attributes
     * @param string $content Shortcode content
     * @param string $tag     The shortcode which invoked the callback
     *
     * @return string
     */
    function add_to_selection_mini($atts, $content, $tag) {
        $atts        = shortcode_atts( array( 'pid' => 0, 'uid' => 0, 'op' => 'add' ), $atts );
        $pid         = intval($atts['pid']);
        $uid         = intval($atts['uid']);
        $op          = trim( $atts['op'] );
        $button      = '';
        $button_text = '<i class="fas fa-star"></i>&nbsp;&nbsp;' . ( $op == 'add' ? __( 'Add to my selection', EQUIPEER_ID ) : __( 'Remove from my selection', EQUIPEER_ID ) );
        // --- Check if user is logged in
        if (is_user_logged_in()) {
            $the_prefix    = get_term_meta( get_post_meta( $pid, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
            $the_reference = equipeer_get_format_reference( @get_post_meta( $pid, 'reference', true ) );
            $the_discipline   = get_term_by( 'id', get_post_meta( $pid, 'discipline', true ), 'equipeer_discipline' )->name;
            $the_breed        = get_term_by( 'id', get_post_meta( $pid, 'breed', true ), 'equipeer_breed' )->name;
            $the_gender       = get_term_by( 'id', get_post_meta( $pid, 'sex', true ), 'equipeer_gender' )->name;
            $the_color        = get_term_by( 'id', get_post_meta( $pid, 'dress', true ), 'equipeer_color' )->name;
            $the_size         = get_post_meta( $pid, 'size_cm', true ) . ' cm';
            $the_age          = equipeer_get_age_by_year( get_post_meta( $pid, 'birthday', true ) );
            $the_potential    = @get_term_by( 'id', get_post_meta( $pid, 'potentiel', true ), 'equipeer_potential' )->name;
            $the_price        = equipeer_get_price( get_post_meta($pid, 'price_equipeer', true), false );
            $the_url          = get_permalink($pid);
            $the_localisation = equipeer_get_localisation_detail($pid, false);
            // image
            $photo_1_id       = @get_post_meta( $pid, 'photo_1', true );
            $the_photo_url    = ($photo_1_id) ? wp_get_attachment_image_src( $photo_1_id, array("133",  "100") ) : false;
            // User is connected
            $button .= '<a role="button" class="btn btn-outline-secondary eq-button-red equine-' . $op . '-selection action-to-selection" data-pid="' . $pid . '" data-uid="' . $uid .'" data-op="' . $op . '" data-ref="' . $the_prefix . '-' . $the_reference . '" data-sexe="' . $the_gender . '" data-robe="' . $the_color . '" data-taille="' . $the_size . '" data-discipline="' . $the_discipline . '" data-potentiel="' . $the_potential . '" data-photo="' . $the_photo_url[0] . '" data-price="' . $the_price . '" data-localisation="' . $the_localisation . '" data-url="' . $the_url . '" href="#">' . $button_text . '</a>';
        } else {
            // User is not connected
            $button .= '<button class="btn btn-outline-secondary eq-button-red equine-add-selection equipeer-not-connected" ' . $this->attributes_button_not_connected($button_text) . '>' . $button_text . '</button>';
        }
        
        return $button;
    }
    
    /**
     * Add button SAVE MY SEARCH (Archive Equine Page)
     *
     * @param array  $atts    Shortcode attributes
     * @param string $content Shortcode content
     * @param string $tag     The shortcode which invoked the callback
     * 
     * @return string
     */
    function save_my_search($atts, $content, $tag) {
        $atts        = shortcode_atts( array( 'large' => false, 'red' => false ), $atts );
        $button_text = __( 'Save my search', EQUIPEER_ID );
        $btnlarge    = ($atts['large']) ? ' btn-block' : '';
        $btncolor    = ($atts['red']) ? 'eq-button-red' : 'eq-button-blue';
        $button      = "";
        // --- Check if user is logged in
        if (is_user_logged_in()) {
            // User is connected
            $button .= '<a role="button" class="eq-button equipeer-save-my-search' . $btnlarge . ' ' . $btncolor . '" href="#" data-s-url="' . equipeer_current_url() . '" ' . $this->attributes_button_save_my_search() . '>' . $button_text . '</a>';
        } else {
            // User is not connected
            $button .= '<button class="btn eq-button-blue equipeer-not-connected' . $btnlarge . '" ' . $this->attributes_button_not_connected($button_text) . '>' . $button_text . '</button>';
        }

        return $button;
    }

    /**
     * Default Button for Save My Search - users
     *
     * @return string
     */
    function attributes_button_save_my_search() {
        $button  = "";
        // User is not connected
        $button .= 'data-title="' . __( "Save my search", EQUIPEER_ID ) . '"
                    data-txt-cancel="' . __( "Cancelled", EQUIPEER_ID ) . '"
                    data-txt-success="' . __( "Perfect", EQUIPEER_ID ) . '"
                    data-button-cancel="' . __( "Cancel", EQUIPEER_ID ) . '"
                    data-button-confirm="' . __( 'Save', EQUIPEER_ID ) . '"
                    data-text-confirm="' . __( "Your search has been saved!", EQUIPEER_ID ) . '"
                    data-text-cancel="' . __( "You have not saved your search!", EQUIPEER_ID ) . '"
                    ';
        return $button;
    }
    
    /**
     * Add button SEE MY SELECTION (Head menu)
     *
     * @param array  $atts    Shortcode attributes
     * @param string $content Shortcode content
     * @param string $tag     The shortcode which invoked the callback
     *
     * @return string
     */
    function see_my_selection($atts, $content, $tag) {
        $atts        = shortcode_atts( array( 'selection' => false ), $atts );
        $button      = '';
        $button_text = __( 'See my selection', EQUIPEER_ID );
        // --- Check if user is logged in
        if (is_user_logged_in()) {
            // User is connected
            $button .= '<a role="button" class="eq-button eq-button-red" href="#">' . $button_text . '</a>';
        } else {
            // User is not connected
            $button .= '<a role="button" class="eq-button eq-button-red equipeer-not-connected" ' . $this->attributes_button_not_connected($button_text) . ' href="#">' . $button_text . '</a>';
        }
        
        return $button;
    }
    
    /**
     * Add button SEND MY SELECTION (Head menu)
     *
     * @param array  $atts    Shortcode attributes
     * @param string $content Shortcode content
     * @param string $tag     The shortcode which invoked the callback
     *
     * @return string
     */
    function send_my_selection($atts, $content, $tag) {
        $atts        = shortcode_atts( array( 'selection' => false ), $atts );
        $button      = '';
        $button_text = __( 'Send my selection', EQUIPEER_ID );
        // --- Check if user is logged in
        if (is_user_logged_in()) {
            // User is connected
            $button .= '<a role="button" class="eq-button eq-button-blue" href="#">' . $button_text . '</a>';
        } else {
            // User is not connected
            $button .= '<a role="button" class="eq-button eq-button-blue equipeer-not-connected" ' . $this->attributes_button_not_connected($button_text) . ' href="#">' . $button_text . '</a>';
        }
        
        return $button;
    }
    
    /**
     * Default Button for Not connected users
     *
     * @return string
     */
    function attributes_button_not_connected($button_text = '') {
        $button  = "";
        // User is not connected
        $button .= 'data-title="' . __( "You're not logged in?", EQUIPEER_ID ) . '"
                    data-text="' . __( 'This functionality is reserved for connected users', EQUIPEER_ID ) . '"
                    data-cancel="' . __( 'Close', EQUIPEER_ID ) . '"
                    data-connect="' . __( 'Sign in', EQUIPEER_ID ) . '"
                    data-connect-url="' . get_site_url() . '/login"
                    data-register="' . __( 'Sign up', EQUIPEER_ID ) . '"
                    data-register-url="' . get_site_url() . '/register"';
        
        return $button;
    }
    
    /**
     * Equine "Questionnaire PROJET"
     *
     * @return string
     */
    function questionnaire_projet($atts, $content, $tag) {
        global $pagenow;

        $html = "";

        // Check if EDIT in admin
        if ($pagenow == 'post.php' && (isset($_GET['action']) && ($_GET['action'] == 'edit' || $_GET['action'] == 'elementor'))) {
            //return $html;
        } else {
        
            $atts = shortcode_atts( array( 'step' => 1 ), $atts );
            // ---------------------------
            // Initialize
            // ---------------------------
            $step        = intval($atts['step']);
            $step_next   = $step + 1;
            $step_total  = 7;
            // ---------------------------
            $quest_age_min = 1;
            $quest_age_max = 20;
            // ---------------------------
            $quest_price_min = 5000;
            $quest_price_max = 100000;
            // ---------------------------
            $quest_around_min = 50;
            $quest_around_max = 1000;
            // ---------------------------
            $h2 = '<h2 class="display-4">' . __( 'In a few clicks find the horse that suits you, among all the ads', EQUIPEER_ID ) . '</h2>';
            $h3 = '<h3 class="display-4">%s</h3>';
            // ---------------------------
            $step_button = '<p class="lead mt-4"><a data-step="'.$step.'" data-step-next="'.$step_next.'" data-step-total="' . $step_total . '" role="button" class="eq-button eq-button-blue questionnaire-achat-btn" href="#">' . __( 'Next', EQUIPEER_ID ) . ' ' . $step . '/' . $step_total . '</a></p>';
            // ---------------------------
            switch($step) {
                default:
                    // --------------------------------------------
                    // ------------------ STEP 1 ------------------
                    // ------------- QUELLE CATEGORIE -------------
                    // --------------------------------------------
                    // --- All disciplines
                    //[0]=>
                    //  array(11) {
                    //    ["id"]=>
                    //    int(35)
                    //    ["name"]=>
                    //    string(6) "Autres"
                    //    ["slug"]=>
                    //    string(6) "autres"
                    //    ["group"]=>
                    //    int(0)
                    //    ["taxonomy_id"]=>
                    //    int(35)
                    //    ["taxonomy"]=>
                    //    string(19) "equipeer_discipline"
                    //    ["description"]=>
                    //    string(0) ""
                    //    ["parent"]=>
                    //    int(0)
                    //    ["count"]=>
                    //    int(0)
                    //    ["filter"]=>
                    //    string(3) "raw"
                    //    ["meta"]=>
                    //    NULL
                    //  }
                    $all_disciplines = equipeer_get_terms('equipeer_discipline', $meta_key = array(), $meta_value = '', $orderby = 'id', $order = 'ASC');
                    $html .= '<div class="jumbotron jumbotron-fluid questionnaire-achat">';
                        $html .= '<div class="container text-center">';
                            $html .= $h2; // H2 Title
                            // ----------------------------------------------------------------------------------------------
                            // --- FORM
                            $html .= '<form id="formquest" method="get" action="'.get_site_url().'/annonces/">';
                            $html .= '<input type="hidden" name="s" value="search_quest">';
                            $html .= '<input type="hidden" name="quest_discipline" id="quest_discipline" value="">';
                            $html .= '<input type="hidden" name="quest_level" id="quest_level" value="">';
                            $html .= '<input type="hidden" name="quest_age_min" id="quest_age_min" value="' . $quest_age_min . '">';
                            $html .= '<input type="hidden" name="quest_age_max" id="quest_age_max" value="' . $quest_age_max . '">';
                            $html .= '<input type="hidden" name="quest_price_min" id="quest_price_min" value="' . $quest_price_min . '">';
                            $html .= '<input type="hidden" name="quest_price_max" id="quest_price_max" value="' . $quest_price_max . '">';
                            $html .= '<input type="hidden" name="quest_gender" id="quest_gender" value="">';
                            $html .= '<input type="hidden" name="quest_localisation_latitude" id="quest_localisation_latitude" value="">';
                            $html .= '<input type="hidden" name="quest_localisation_longitude" id="quest_localisation_longitude" value="">';
                            $html .= '<input type="hidden" name="quest_localisation_distance" id="quest_localisation_distance" value="' . $quest_around_min . '">';
                            $html .= '<input type="hidden" name="quest_localisation_name" id="quest_localisation_name" value="">';
                            $html .= '</form>';
                            // ----------------------------------------------------------------------------------------------
                            // --- DISCIPLINE ---
                            $html .= '<div id="questionnaire-container">';                        
                                $html .= '<div id="questionnaire-content">';
                                    $html .= sprintf( $h3, __( 'You are looking for a horse of which category?', EQUIPEER_ID ) ); // H3 Subtitle
                                    $html .= '<div class="lead">';
                                        foreach($all_disciplines as $row) {
                                            if ($row['id'] != 35) {
                                                $image_infos = get_term_meta($row['id'], 'equipeer_image_taxonomy_parent_id', true);
                                                $html .= '<figure class="figure quest-discipline" data-id="' . $row['id'] . '">';
                                                    $html .= '<img class="figure-img img-fluid rounded-circle" src="'.$image_infos['url'].'" alt="">';
                                                    $html .= '<figcaption class="figure-caption"><h3 class="questionnaire-h3-fig">' . $row['name'] . '</h3></figcaption>';
                                                $html .= '</figure>';
                                            }
                                        }
                                    $html .= '</div>';
                                $html .= '</div>';
                            $html .= '</div>';
                            $html .= $step_button;
                        $html .= '</div>';
                    $html .= '</div>';
                break;
                case 2:
                    // --------------------------------------------
                    // ------------------ STEP 2 ------------------
                    // --------------- QUEL NIVEAU ----------------
                    // --------------------------------------------
                    $meta_value = intval($_POST['discipline']); // Discipline choisie
                    $all_levels = equipeer_get_terms('equipeer_level', $meta_key = array('equipeer_select_discipline_taxonomy_parent_id', 'equipeer_select_discipline_2_taxonomy_parent_id', 'equipeer_select_discipline_3_taxonomy_parent_id'), $meta_value, $orderby = 'name', $order = 'ASC');
                    $html .= sprintf( $h3, __( 'What level are you looking for?', EQUIPEER_ID ) ); // H3 Subtitle
                    // 28  => 'CSO'
                    // 30  => 'Dressage'
                    if (!$all_levels) {
                        $html .= '<p class="lead" style="margin: 0 2em;">' . __( 'No level for this discipline', EQUIPEER_ID ) . '<br>' . __( 'Click on next', EQUIPEER_ID ) .  '</p>';
                    } else {
                        $cpt_level = count($all_levels);
                        $divider   = ceil($cpt_level / 2); // Round UP
                        $html .= '<div class="lead" style="margin: 0 2em;">';
                            $html .= '<div class="container">';
                                $html .= '<div class="row">';
                                    $html .= '<div class="col col-mob"></div>';
                                        $html .= '<div class="col col-mob-100 text-left">';
                                        $i = 0;
                                        foreach($all_levels as $row) {
                                            $html .= '<input class="quest-level" type="checkbox" name="quest_level_' . $row['id'] . '" value="' . $row['id'] . '" data-text="' . $row['name'] . '">&nbsp;'.$row['name'];
                                            // Exceptions si
                                            // CSO : 28
                                            // Hunter : 449
                                            // Poney : 454
                                            if ($meta_value == 28 || $meta_value == 449 || $meta_value == 454) {
                                                if ($row['id'] != 39) $html .= ' cm';
                                            }
                                            $html .= '<br>';
                                            $i++;
                                            if ($i % $divider == 0 && $i < $cpt_level) {
                                                $html .= '</div>';
                                                $html .= '<div class="col col-mob-100 text-left">';
                                            }
                                        }
                                    $html .= '</div>';
                                    $html .= '<div class="col col-mob"></div>';
                                $html .= '</div>';
                            $html .= '</div>';
                            //$html .= 'Contenu niveau';
                        $html .= '</div>';
                    }
                break;
                case 3:
                    // --------------------------------------------
                    // ------------------ STEP 3 ------------------
                    // ----------------- QUEL AGE -----------------
                    // --------------------------------------------
                    $html .= sprintf( $h3, __( 'Looking for a horse from what age?', EQUIPEER_ID ) ); // H3 Subtitle
                    $html .= '<p class="lead" style="margin: 0 2em;">';
                    //$html .= '<input type="text" class="js-range-slider" name="quest_age" id="quest_age" value="" data-postfix=" ans" data-type="double" data-min="' . $quest_age_min . '" data-max="'. $quest_age_max . '" data-from="' . $quest_age_min . '" data-to="' . $quest_age_max . '" data-grid="false" data-step="1">';
                    $html .= '<input type="text" class="js-range-slider" name="quest_age" id="quest_age" value="" data-type="double" data-values="" data-grid="false">';
                    $html .= '<input type="hidden" name="test" value="">';
                    $html .= '</p>';
                    $html .= '<script>
                    // Populate SLIDER
                    jQuery(function($) {
                        var search_discipline = $("#quest_discipline").val();
                        // check if choosen taxonomy is not ELEVAGE
                        if (search_discipline != 446) {
                            $("#quest_age").attr("data-values", "3 ans, 4 ans, 5 ans, 6 ans, 7 ans, 8 ans, 9 ans, 10 ans, 11 ans, 12 ans, 13 ans, 14 ans, 15 ans, 16 ans, 17 ans, 18 ans, 19 ans, 20 ans");
                        } else {
                            $("#quest_age").attr("data-values", "Foal, 1 an, 2 ans, 3 ans, 4 ans, 5 ans, 6 ans, 7 ans, 8 ans, 9 ans, 10 ans, 11 ans, 12 ans, 13 ans, 14 ans, 15 ans, 16 ans, 17 ans, 18 ans, 19 ans, 20 ans");
                        }
                    });
                    </script>';
                break;
                case 4:
                    // --------------------------------------------
                    // ------------------ STEP 4 ------------------
                    // ---------------- QUEL BUDGET ---------------
                    // --------------------------------------------
                    $html .= sprintf( $h3, __( 'Looking for a horse from what budget?', EQUIPEER_ID ) ); // H3 Subtitle
                    $html .= '<p class="lead" style="margin: 0 2em;">';
                    $html .= '<input type="text" class="js-range-slider" name="quest_price" id="quest_price" value="" data-postfix=" euros" data-type="double" data-min="' . $quest_price_min . '" data-max="' . $quest_price_max . '" data-from="' . $quest_price_min . '" data-to="' . $quest_price_max . '" data-grid="false" data-step="1000">';
                    $html .= '</p>';
                break;
                case 5:
                    // --------------------------------------------
                    // ------------------ STEP 5 ------------------
                    // ---------------- QUEL SEXE -----------------
                    // --------------------------------------------
                    $all_genders = equipeer_get_terms('equipeer_gender', $meta_key = array(), $meta_value = '', $orderby = 'id', $order = 'ASC');
                    $html .= sprintf( $h3, __( 'You are looking for a horse of what gender?', EQUIPEER_ID ) ); // H3 Subtitle
                    $html .= '<div class="lead" style="margin: 0 2em;">';
                        $html .= '<div class="container">';
                            $html .= '<div class="row">';
                                $html .= '<div class="col col-mob"></div>';
                                    $html .= '<div class="col col-mob-100 text-left">';
                                    $i = 0;
                                    foreach($all_genders as $row) {
                                        $html .= '<input class="quest-sex" type="checkbox" name="quest_sex_' . $row['id'] . '" value="' . $row['id'] . '">&nbsp;'.$row['name'] . '<br>';
                                        $i++;
                                        if ($i % 2 == 0 && $i < count($all_genders)) {
                                            $html .= '</div>';
                                            $html .= '<div class="col col-mob-100 text-left">';
                                        }
                                    }
                                $html .= '</div>';
                                $html .= '<div class="col col-mob"></div>';
                            $html .= '</div>';
                        $html .= '</div>';
                        //$html .= 'Contenu sexe';
                    $html .= '</div>';
                break;
                case 6:
                    // --------------------------------------------
                    // ------------------ STEP 6 ------------------
                    // ----------- QUELLE LOCALISATION ------------
                    // --------------------------------------------
                    $html .= sprintf( $h3, __( 'What location?', EQUIPEER_ID ) ); // H3 Subtitle
                    $html .= '<div id="autocomplete_quest" class="lead text-center aut">';
                        $html .= '<div id="searchQuest" class="input-group mb-3 text-center" style="max-width: 300px; margin: 0 auto;">';
                            $html .= '<div class="input-group-prepend">';
                                $html .= '<span class="input-group-text" id="basic-addon1"><i class="fas fa-map-marker-alt"></i></span>';
                            $html .= '</div>';
                            $html .= '<input id="autocomplete" type="text" class="form-control autocomplete" placeholder="' . __('Enter a place', EQUIPEER_ID) . '" onFocus="geolocate();" aria-label="Username" aria-describedby="basic-addon1">';
                        $html .= '</div>';
                    $html .= '</div>';
                    $html .= __( 'In a radius around', EQUIPEER_ID );
                    $html .= '<br>';
                    $html .= '<div class="text-center" style="max-width: 400px; margin: 0 auto;">';
                        $html .= '<input type="text" class="js-range-slider" name="quest_around" id="quest_around" value="" data-postfix=" km" data-min="' . $quest_around_min . '" data-max="' . $quest_around_max . '" data-from="' . $quest_around_min . '" data-to="' . $quest_around_max . '" data-max-postfix=" +" data-grid="false" data-step="100">';
                    $html .= '</div>';
                    $html .= "<script>
                        // This sample uses the Autocomplete widget to help the user select a
                        // place, then it retrieves the address components associated with that
                        // place, and then it populates the form fields with those details.
                        // This sample requires the Places library. Include the libraries=places
                        // parameter when you first load the API. For example:
                        // <script
                        // src=\"https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places\">
                        var placeSearch, autocomplete;
                        // Put the same ID to your INPUTS
                        var componentForm = {
                            street_number: 'short_name',   // long_name | short_name
                            route: 'long_name',            // long_name | short_name
                            locality: 'long_name',         // long_name | short_name
                            //administrative_area_level_1: 'short_name',
                            //administrative_area_level_2: 'short_name',
                            country: 'long_name',          // long_name | short_name
                            postal_code: 'long_name'       // long_name | short_name
                        };
                        // Init Autocomplete
                        function initAutocomplete() {
                            // Create the autocomplete object, restricting the search predictions to
                            // geographical location types.
                            autocomplete = new google.maps.places.Autocomplete(
                                document.getElementById('autocomplete'), {
                                    types: ['(cities)'],
                                    //componentRestrictions: {
                                    //    country: ['FR','BE','DE','IT','ES'] // 5 max autorise (Code ISO 3166)
                                    //}
                                }
                            );
                            // Avoid paying for data that you don't need by restricting the set of
                            // place fields that are returned to just the address components.
                            autocomplete.setFields(['address_component', 'geometry']);
                            // When the user selects an address from the drop-down, populate the
                            // address fields in the form.
                            autocomplete.addListener('place_changed', fillInAddress);
                        }
                        // Fill in Address Fields
                        function fillInAddress() {
                            // Get the place details from the autocomplete object.
                            var place = autocomplete.getPlace();                      
                            var lat   = place.geometry.location.lat(),
                                lng   = place.geometry.location.lng();				
                            // Add Longitude / Latitude
                            jQuery( \"#quest_localisation_latitude\" ).val( lat );
                            jQuery( \"#quest_localisation_longitude\" ).val( lng );
                            jQuery( \"#quest_localisation_name\").val( jQuery( \"#autocomplete\" ).val() );
                        }
                        // Bias the autocomplete object to the user's geographical location,
                        // as supplied by the browser's 'navigator.geolocation' object.
                        function geolocate() {
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(function(position) {
                                    var geolocation = {
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude
                                    };
                                    var circle = new google.maps.Circle(
                                        {center: geolocation, radius: position.coords.accuracy});
                                    autocomplete.setBounds(circle.getBounds());
                                });
                            }
                        }
                    </script>";
                    $html .= "<script src=\"https://maps.googleapis.com/maps/api/js?key=" . get_option( 'equine_google_place_api_key' ) . "&libraries=places&callback=initAutocomplete\" async defer></script>";
                break;
                case 7:
                    // --------------------------------------------
                    // ------------------ STEP 7 ------------------
                    // ---------------- TRAITEMENT ----------------
                    // --------------------------------------------
                    $html .= sprintf( $h3, __( 'Search in progress...', EQUIPEER_ID ) ); // H3 Subtitle
                    $html .= '<p class="lead text-center">';
                        $html .= '<img class="border-none" src="' . get_stylesheet_directory_uri() . '/assets/images/loader-ajax-rider.gif" alt="">';
                    $html .= '</p>';
                    $html .= '<script>
                        var auto = setTimeout(function() { autoRefresh(); }, 100);
                
                        function submitform(){
                            document.forms["formquest"].submit();
                        }
                
                        function autoRefresh() {
                             clearTimeout(auto);
                             auto = setTimeout(function(){ submitform(); autoRefresh(); }, 3000);
                        }
                    </script>';
                break;
            }

            $html .= "<script>
                jQuery(function($) {
                    // ======================
                    // ===== DISCIPLINE =====	
                    // ======================
                    $('.quest-discipline').click(function() {
                        var discipline = $(this);
                        // Clean all
                        $('.quest-discipline, .quest-discipline img').removeClass('jqhover');
                        // Add ACTIVE
                        discipline.addClass('jqhover');
                        discipline.find('img').addClass('jqhover');
                        // Add value to input
                        $('#quest_discipline').val( discipline.attr('data-id') );
                    });
                    // ================
                    // ===== SEXE =====	
                    // ================
                    $('.quest-sex').click(function() {
                        var checkedVals = $('.quest-sex:checkbox:checked').map(function() {
                            return this.value;
                        }).get();
                        $('#quest_gender').val( checkedVals.join(\",\") );
                    });
                    // ==================
                    // ===== NIVEAU =====	
                    // ==================
                    $('.quest-level').click(function() {
                        var checkedVals = $('.quest-level:checkbox:checked').map(function() {
                            return this.value;
                        }).get();
                        $('#quest_level').val( checkedVals.join(\",\") );
                    });
                    // ============================
                    // ===== RANGE SLIDER AGE =====	
                    // ============================
                    $('#quest_age').ionRangeSlider({
                        skin: \"big\",
                        onStart: function (data) {
                            //$('#quest_age').ionRangeSlider({
                            //    from_min: '3 ans'
                            //});
                            //// Check if not ELEVAGE
                            //if ($('#quest_discipline).val() != '446') {
                            //    //from_min
                            //}
                        },
                        onFinish: function (data) {
                            // Called every time handle position is changed
                            var delta = ($('#quest_discipline').val() == '446') ? 0 : 3;
                            $('#quest_age_min').val( parseInt( data.from + delta ) );
                            $('#quest_age_max').val( parseInt( data.to + delta ) );
                        }
                    });
                    //$('.js-irs-6 .irs-from').text('toto');
                    // ==============================
                    // ===== RANGE SLIDER PRICE =====	
                    // ==============================
                    $('#quest_price').ionRangeSlider({
                        skin: \"big\",
                        max_postfix: \" +\",
                        onFinish: function (data) {
                            // Called every time handle position is changed
                            $('#quest_price_min').val( parseInt( data.from ) );
                            $('#quest_price_max').val( parseInt( data.to ) );
                        }
                    });
                    // =====================================
                    // ===== RANGE SLIDER LOCALISATION =====	
                    // =====================================
                    $('#quest_around').ionRangeSlider({
                        skin: \"big\",
                        onFinish: function (data) {
                            // Called every time handle position is changed
                            $('#quest_localisation_distance').val( parseInt( data.from ) );
                        }
                    });
                });
            </script>";
        
        }
        
        return $html;

    }

}

?>