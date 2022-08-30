<?php ob_start(); ?>
<?php if (isset($args) && $args->optionsGroup): ?>
    <?php
    $options = apply_filters('getNFTBannerConfigOptions', 'options');
    $env = $options['env'] ?? 'testnet';
    $bannerZoneId1 = $options['banner_zone_id_1'] ?? 'a_4206213879';
    ?>
    <div class="form">
        <h1><?php _e('nSpot Banner configuration', 'TBNFTBanner'); ?></h1>
        <form method="post" action="options.php" class="settings-form">
            <?php settings_fields($args->optionsGroup); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('Environment'); ?></th>
                    <td>
                        <select name="<?= esc_attr("$args->optionsGroup[env]") ?>">
                            <?php $selected = $env == 'mainnet' ? 'selected = "selected"' : ''; ?>
                            <option value="testnet"><?php _e('Testnet', 'TBLNCCertificate'); ?></option>
                            <option value="mainnet" <?= $selected ?> ><?php _e('Mainnet', 'nspot-wordpress'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('1st banner zone id'); ?></th>
                    <td>
                        <input type="text"
                            class="regular-text"
                            name="<?= esc_attr("$args->optionsGroup[banner_zone_id_1]") ?>"
                            value="<?= esc_attr($bannerZoneId1) ?>"
                        />
                    </td>
                </tr>
            </table>

            <button type="submit" class="button button-primary"><?php _e('Save', 'nspot-wordpress'); ?></button>

        </form>
    </div>
<?php endif; ?>
<?php return ob_get_clean(); ?>
