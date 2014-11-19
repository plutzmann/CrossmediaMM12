<div class="fonticon-ajax-data">
    <div class="general-field-container">
        <div class="field-item type-select">
            <div class="field-title">Icon Type</div>
            <div class="field-data">
                <select data-name="icon_type" data-type="select" class="field"><option value="fa" hide="none">Font Awesome</option><option value="sl" hide="none">Simple Line</option></select>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-color">
            <div class="field-title">Font Color</div>
            <div class="field-data">
                <input data-name="fi_color" data-type="color" class="field" value="" placeholder="" type="text" />
                <div class="color-info"></div>
            </div>
            <div class="field-desc">Color.</div>
        </div>
        <div class="field-item type-color">
            <div class="field-title">Border Color</div>
            <div class="field-data">
                <input data-name="fi_border_color" data-type="color" class="field" value="" placeholder="" type="text" />
                <div class="color-info"></div>
            </div>
            <div class="field-desc">Border Color.</div>
        </div>
        <div class="field-item type-color">
            <div class="field-title">Background Color</div>
            <div class="field-data">
                <input data-name="fi_bg_color" data-type="color" class="field" value="" placeholder="" type="text" />
                <div class="color-info"></div>
            </div>
            <div class="field-desc">Background Color.</div>
        </div>
        <div class="field-item type-text">
            <div class="field-title">Font Size</div>
            <div class="field-data">
                <input data-name="fi_size" data-type="text" class="field" value="" placeholder="" data-selector="" data-save-to="" type="number" min="0"/>
            </div>
            <div class="field-desc">Size.</div>
        </div>
        <div class="field-item type-text">
            <div class="field-title">Font Padding</div>
            <div class="field-data">
                <input data-name="fi_padding" data-type="text" class="field" value="" placeholder="" data-selector="" data-save-to="" type="number" min="0"/>
            </div>
            <div class="field-desc">Padding.</div>
        </div>
        <div class="field-item type-text">
            <div class="field-title">Border width Size</div>
            <div class="field-data">
                <input data-name="fi_rounded" data-type="text" class="field" value="" placeholder="" data-selector="" data-save-to="" type="number" min="0"/>
            </div>
            <div class="field-desc">Border width Size.</div>
        </div>
         <div class="field-item type-text">
            <div class="field-title">Border rounded Size</div>
            <div class="field-data">
                <input data-name="fi_rounded_size" data-type="text" class="field" value="" placeholder="" data-selector="" data-save-to="" type="number" min="0"/>
            </div>
            <div class="field-desc">Border rounded Size.</div>
        </div>
        <div class="field-item type-select">
            <div class="field-title">Box Shadow Inset?</div>
            <div class="field-data">
                <select data-name="fi_box_shadow" data-type="select" class="field"><option value="false" hide="none">No</option><option value="true" hide="none">Yes</option></select>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-select">
            <div class="field-title">Rotate?</div>
            <div class="field-data">
                <select data-name="fi_rotate" data-type="select" class="field"><option value="false" hide="none">No</option><option value="true" hide="none">Yes</option></select>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item hidden type-hidden">
            <div class="field-title">Icon</div>
            <div class="field-data">
                <input data-name="fi_icon" data-type="hidden" class="field" value="" placeholder="" data-selector="" data-save-to="" type="hidden" />
            </div>
            <div class="field-desc">Icon.</div>
        </div>
    </div>
    <div class="fonticon-field-container">
        <div class="container">
            <div class="fi-viewer"></div>
            <?php include(WAVES_PATH . "pagebuilder/font-icon-list.php"); ?>
        </div>
    </div>
</div>