<?php require_once("_header.php")?>
    <div class="svs_pt_edit">
        <h3>Design</h3>
        <section class="svs_pt_edit_design">
            <select class="svs_pt_edit_design_options">
                <?php
                    foreach ($_data['templates'] as $template){
                        $dataImgSrc = plugins_url( "../templates/$template/preview.jpg", __DIR__ );
                        $selectedTemplate = ($template == $_data['pricingTable']['template'] ? "selected='selected'" : "" );
                        echo "<option data-img-src='$dataImgSrc' value='$template' $selectedTemplate></option>";
                    }
                ?>
            </select>
        </section>
        <h3>Settings</h3>
        <section class="svs_pt_edit_settings">
            <div class="svs_pt_builder_options_available">
                <ol class="svs_pt_clearfix">
                    <li class="svs_title"><div><i class="svs_icon icon-move oi" data-glyph="move"></i><i class="svs_icon icon-trash-option oi" data-glyph="trash"></i><h2 class="svs_pt_editable_text">Name</h2></div></li>
                    <li class="svs_price"><div><i class="svs_icon icon-move oi" data-glyph="move"></i><i class="svs_icon icon-trash-option oi" data-glyph="trash"></i><p><span class="svs_pt_editable_text">Price</span>&nbsp;<span class="svs_pt_editable_text">/ month</span></p></div></li>
                    <li class="svs_option_value"><div><i class="svs_icon icon-move oi" data-glyph="move"></i><i class="svs_icon icon-trash-option oi" data-glyph="trash"></i><p><span class="svs_pt_editable_text">Value</span>&nbsp;<span class="svs_pt_editable_text">option</span></p></div></li>
                    <li class="svs_option_yes_no"><div><i class="svs_icon icon-move oi " data-glyph="move"></i><i class="svs_icon icon-trash-option oi" data-glyph="trash"></i><p><span class="svs_pt_editable_yes_no">Yes/No</span>&nbsp;<span class="svs_pt_editable_text">option</span></p></div></li>
                    <li class="svs_button"><div><i class="svs_icon icon-move oi" data-glyph="move"></i><i class="svs_icon icon-trash-option oi" data-glyph="trash"></i><i class="svs_icon icon-link oi" data-glyph="link-intact"></i><a href="#" class="svs_pt_editable_text">Button</a></div></li>
                </ol>
            </div>
            <div class="svs_pt_column_size">
                Column width:
                <select>
                    <option value="200px">200px</option>
                    <option value="225px">225px</option>
                    <option value="250px">250px</option>
                    <option value="275px">275px</option>
                    <option value="300px">300px</option>
                    <option value="325px">325px</option>
                    <option value="350px">350px</option>
                </select>
            </div>
            <div class="svs_pt_builder_workarea svs_pt_clearfix">
                <?php echo base64_decode($_data['pricingTable']['backend']);?>
            </div>
            <div class="clearfix"></div>
        </section>
    </div>
<?php require_once("_footer.php")?>