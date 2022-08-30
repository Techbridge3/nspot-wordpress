<?php ob_start();?>
<?php
$args = 0;
if (isset($data)) {
    $args = $data;
}
?>
    <div class="actions custom">
        <button
                style="height: 29px;"
                onclick="return false;"
                type="submit"
                class="button nspot_export"
            <?php if (isset($args['buttonID']) && $args['buttonID']) : ?>
                id = "<?php echo $args['buttonID'];?>"
            <?php endif;?>
            <?php if (isset($args['action']) && $args['action']) : ?>
                data-action="<?php echo $args['action'];?>"
            <?php endif;?>
            <?php if (isset($args['offset']) && $args['offset']) : ?>
                data-offset="<?php echo $args['offset'];?>"
            <?php endif;?>
            <?php if (isset($args['totalRows']) && $args['totalRows']) : ?>
                data-totalRows="<?php echo $args['totalRows'];?>"
            <?php endif;?>
            <?php if (isset($args['id']) && $args['id']) : ?>
                data-id="<?php echo $args['id'];?>"
            <?php endif;?>
        >
            <?php if (isset($args['buttonName']) && $args['buttonName']) : ?>
                <?php echo $args['buttonName'];?>
            <?php endif;?>
        </button>
        <span class="step"></span>
    </div>
<script>
    const exporter = {
        totalRows: null,

        action: null,

        offset: null,

        filters: null,

        step: 0,

        button: null,

        stepElement: null,

        filterFieldsButton: null,

        filterFieldsBlock: null,

        exportFieldsSelector: null,

        fields: '',

        init(button) {
            this.setFields(button);
            this.exportAction();
        },

        setFields(button) {
            this.button = button;
            this.totalRows = this.button.data('totalrows');
            this.action = this.button.data('action');
            this.offset = this.button.data('offset');
            this.id = this.button.data('id');
            this.stepElement = jQuery(this.button.parent().find('.step')[0]);
        },

        export() {
            if (!ajaxurl) {
                ajaxurl = '/wp-admin/admin-ajax.php';
            }

            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: this.action,
                    data: {
                        step: this.step,
                        offset: this.offset,
                        id: this.id,
                        totalRows: this.totalRows,
                        fields: this.fields,
                    },
                },
                success: (data) => {
                    if (data) {
                        this.step += this.offset;
                        const lastIteration = this.totalRows + this.offset;
                        let step = this.step;
                        if (step <= lastIteration) {
                            if (step > this.totalRows) {
                                step = this.totalRows;
                            }
                            jQuery(this.stepElement).html(`${step} from ${this.totalRows}`);
                            this.export();
                        } else {
                            this.step = 0;
                            jQuery(this.stepElement).html(`<a download='nspot_export.csv' href="${data}">Download</a>`);
                        }
                    }
                },
                error: () => {
                },
            });
        },

        exportAction() {
            jQuery(this.button).click((e) => {
                alert('Export Started please wait!');
                e.preventDefault();
                this.export();
                jQuery(this.button).unbind("click");
                return false;
            })
        },

    };
    jQuery(document).ready(() => {
        jQuery('.nspot_export').each(function () {
            exporter.init(jQuery(this));
        });
    });

</script>
<?php return ob_get_clean();?>