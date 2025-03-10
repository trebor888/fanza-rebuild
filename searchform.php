<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
    <input type="text" class="txt" name="s" id="s" value="<?php esc_html_e('Search','fanzalive'); ?>" onblur="if (this.value == '') {this.value = '<?php esc_html_e('Search','fanzalive'); ?>';}" onfocus="if (this.value == '<?php esc_html_e('Search','fanzalive'); ?>') {this.value = '';}" />
</form>