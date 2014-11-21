<div class="fonticon-ajax-data">
    <div class="general-field-container">
        <div class="field-item type-select">
            <div class="field-title">Type</div>
            <div class="field-data">
                <select data-name="cc_type" data-type="select" class="field"><option value="text" hide="icon_type">Text</option><option value="fi" hide="cc_text">Font Icon</option></select>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-select">
            <div class="field-title">Icon Type</div>
            <div class="field-data">
                <select data-name="icon_type" data-type="select" class="field"><option value="fa" hide="none">Font Awesome</option><option value="sl" hide="none">Simple Line</option></select>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-select cc_line_cap">
            <div class="field-title">Line Style</div>
            <div class="field-data">
                <select data-name="cc_line_cap" data-type="select" class="field"><option value="butt" hide="" selected="selected">Normal</option><option value="round" hide="">Rounded</option></select>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-text">
            <div class="field-title">Line Width</div>
            <div class="field-data">
                <input data-name="cc_line_width" data-type="text" class="field" value="10" placeholder="" data-selector="" data-save-to="" type="number" min="1"/>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-text">
            <div class="field-title">Text</div>
            <div class="field-data">
                <input data-name="cc_text" data-type="text" class="field" value="40%" placeholder="" data-selector="" data-save-to="" type="text"/>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-text">
            <div class="field-title">Percent</div>
            <div class="field-data">
                <input data-name="cc_percent" data-type="text" class="field" value="40" placeholder="" data-selector="" data-save-to="" type="number" min="0" max="100" />
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-text">
            <div class="field-title">Size</div>
            <div class="field-data">
                <input data-name="cc_size" data-type="text" class="field" value="100" placeholder="" data-selector="" data-save-to="" type="number" min="1" />
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-text">
            <div class="field-title">Font Size</div>
            <div class="field-data">
                <input data-name="cc_font_size" data-type="text" class="field" value="24" placeholder="" data-selector="" data-save-to="" type="number" min="1"/>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-color">
            <div class="field-title">Font Color</div>
            <div class="field-data">                        
                <div class="color-info"></div>
                <input data-name="cc_font_color" data-type="color" class="field" value="#000" placeholder="" type="text"/>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-color">
            <div class="field-title">Color</div>
            <div class="field-data">
                <div class="color-info"></div>
                <input data-name="cc_color" data-type="color" class="field" value="#ecf0f1" placeholder="" type="text"/>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-color">
            <div class="field-title">Track Color</div>
            <div class="field-data">
                <div class="color-info"></div>
                <input data-name="cc_track_color" data-type="color" class="field" value="#6DAEB7" placeholder="" type="text"/>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item hidden type-hidden">
            <div class="field-title">Icon</div>
            <div class="field-data">
                <input data-name="cc_icon" data-type="hidden" class="field" value="fa-glass" placeholder="" data-selector="" data-save-to="" type="hidden" />
            </div>
            <div class="field-desc"></div>
        </div>
    </div>
    <div class="fonticon-field-container">
        <div class="container">
            <div class="cc-viewer"></div>
            <?php include(WAVES_PATH . "pagebuilder/font-icon-list.php"); ?>
        </div>
    </div>
</div>