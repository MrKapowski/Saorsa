<?php
/**
 * Anything we want to add to the Wordpress admin area
 * @package Saorsa
 * @since Saorsa 0.0.1
 */

add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'saorsa_user_profile_fields' );

function saorsa_user_profile_fields( $user ) { ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="pronouns"><?php _e("Pronouns"); ?></label></th>
            <td>
                <input type="text" name="pronouns" id="pronouns" value="<?php echo esc_attr( get_the_author_meta( 'pronouns', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please select your pronouns."); ?></span>
            </td>
        </tr>
    </table>
<?php }

add_action( 'personal_options_update', 'saorsa_save_user_profile_fields' );
add_action( 'edit_user_profile_update', 'saorsa_save_user_profile_fields' );

function saorsa_save_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'pronouns', $_POST['pronouns'] );
}