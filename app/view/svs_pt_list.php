<?php require_once("_header.php")?>
<a href="<?php admin_url()?>admin.php?page=svs_pricing_tables&Action=pricingTableNew" class="svs_pt_button svs_pt_button_green oi" data-glyph="file">&nbsp;Create Pricing Table</a>
<div class="svs_pt_list">
    <table>
        <thead> <tr><td>ID</td><td>Name</td><td>ShortCode</td><td>Actions</td></tr></thead>
        <?php
            if (empty($_data)) {
                echo '<tr><td colspan="5">';
                _e('No pricing tables found');
                echo '</td></tr>';
            } else {
                foreach ($_data as $pricing_table) {
                    echo '<tr>';
                    foreach ($pricing_table as $value) {
                        echo '<td>';
                        _e($value);
                        echo '</td>';
                    }
                    echo '<td>
                            <a class="svs_pt_button svs_pt_button_red oi" data-glyph="trash" onclick="if (confirm(\'Are you sure you want to delete this plan?\')){document.location.href=\'' . admin_url() . 'admin.php?page=svs_pricing_tables&Action=pricingTableDelete&ID=' . $pricing_table->ID . '\'};"></a>
                            <a href="' . admin_url() . 'admin.php?page=svs_pricing_tables&Action=pricingTableEdit&ID=' . $pricing_table->ID . '" class="svs_pt_button svs_pt_button_orange oi" data-glyph="pencil"></a>
                            </td>';
                    echo '</tr>';
                }
            }
        ?>
    </table>
</div>
<?php require_once("_footer.php")?>