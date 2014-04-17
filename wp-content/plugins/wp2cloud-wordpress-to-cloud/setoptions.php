<?php

function wp2cloud_validate_cdn_url($wp2cloud_cdn)
{
    if (!$wp2cloud_cdn)
        return true;

    $wp2cloud_cdn_url = (strpos($wp2cloud_cdn, "://") === false ? "wp2cloud://" : "").$wp2cloud_cdn;

    return filter_var($wp2cloud_cdn_url, FILTER_VALIDATE_URL);
}

//--------
// Plugin settings page.
function wp2cloud_settings()
{
    if(!empty($_POST['submit']))
    {
        //--------
        // Update settings.
        $wp2cloud_cdn = $_POST['wp2cloud_cdn'];
        $wp2cloud_cdn_html = htmlspecialchars($wp2cloud_cdn);

        $wp2cloud_warn_nocloud = empty($_POST['wp2cloud_warn_nocloud']) ? null : $_POST['wp2cloud_warn_nocloud'];

        if (!wp2cloud_validate_cdn_url($wp2cloud_cdn))
        {
            echo '<div id="error" class="error"><p>';
            printf(__('Invalid Distribution URL: %1$s', 'wp2cloud'), $wp2cloud_cdn_html);
            echo '</p></div>';
        }
        else
        {
            $options = array('cdn' => $wp2cloud_cdn, 'ignore_nocloud' => $wp2cloud_warn_nocloud == '1' ? null : '1');
            update_option('wp2cloud', $options);
            echo '<div id="message" class="updated"><p>' . __('Settings updated.', 'wp2cloud') . '</p></div>';
        }
    }
    else
    {
        //--------
        // Get settings.
        $options = get_option('wp2cloud');
        $wp2cloud_cdn = $options['cdn'];
        $wp2cloud_cdn_html = htmlspecialchars($wp2cloud_cdn);
        $wp2cloud_warn_nocloud = $options['ignore_nocloud'] == '1' ? null : '1';
    }

    $wp2cloud_warn_nocloud_checked = checked('1', $wp2cloud_warn_nocloud, false);

    //--------
    // Display settings page.
    $icon_html = screen_icon('options-general');
    $settings_header = __('WordPress to Cloud Settings', 'wp2cloud');

    $cdn_header = __('Content Distribution Network (CDN)','wp2cloud');
    $cdn_text = __('    You can setup a CDN (e.g. <a href="http://aws.amazon.com/cloudfront/">Amazon CloudFront</a>)
                for media files to make content delivery even faster.  To do so, please specify the distribution
                URL that would be used instead of the <em>host/bucket</em> part of the cloud storage location.
                For example, if your cloud storage location looks like <em>s3.amazonaws.com/oblaksoft-yapixx/db0</em>
                and the distribution URL looks like <em>d111111abcdef8.cloudfront.net</em>, the media files
                would have URLs like <em>http://d111111abcdef8.cloudfront.net/db0/path/to/foo.jpg</em>.  You
                need to <a href="http://www.slideshare.net/artemlivshits/wordpress-on-s3-now-with-cdn">configure</a>
                the CDN to point it to the cloud storage origin location.', 'wp2cloud');
    $cdn_dist_url = __('Distribution URL', 'wp2cloud');
    $cdn_descr = sprintf(__('E.g. %1$s', 'wp2cloud'), '<code>d11111abcdef8.cloudfront.net</code>');

    $dbp_header = __('Cloud database protection', 'wp2cloud');
    $dbp_text = __('    If you opt to store your whole WordPress database in the cloud storage, WordPress to Cloud can
                warn you if any of the WordPress tables are not stored in the cloud. If you decide to ignore
                this warning, you should consider protecting your data by other means (e.g. database backups).',
        'wp2cloud');
    $dbp_warn = __('Warn when WordPress tables are not stored in the cloud storage', 'wp2cloud');

    $save_changes = __('Save Changes', 'wp2cloud');

    print <<<EOT
    <div class="wrap">
        $icon_html <h2>$settings_header</h2>
        <form method="POST">
            <h3>$cdn_header</h3>

            <p>
            $cdn_text
            </p>

            <table class="form-table">
            <tbody><tr valign="top">
                <th scope="row"><label for="wp2cloud_cdn">$cdn_dist_url</label></th>
                <td><input name="wp2cloud_cdn" type="text" id="wp2cloud_cdn" value="$wp2cloud_cdn_html" class="regular-text code">
                <p class="description">$cdn_descr</code></p>
                </td>
            </tr>
            </tbody></table>

            <h3>$dbp_header</h3>
            <p>
            $dbp_text
            </p>

            <table class="form-table">
            <tbody><tr>
            <th scope="row" colspan="2" class="th-full">
            <label for="wp2cloud_warn_nocloud">
            <input name="wp2cloud_warn_nocloud" type="checkbox" id="wp2cloud_warn_nocloud" value="1" $wp2cloud_warn_nocloud_checked>
            $dbp_warn</label>
            </th> </tr>
            </tbody></table>

            <p class="submit">
                <input type="submit" name="submit" class="button-primary" value="$save_changes">
            </p>
        </form>
    </div>
EOT;
}

?>
