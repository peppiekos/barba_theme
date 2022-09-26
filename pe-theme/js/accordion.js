class PE_Accordion {
    wrapper;
    constructor(wrapper) {
        this.wrapper = wrapper;
        this.bindEvents();
    }

    bindEvents() {
        let self = this;
        this.wrapper.children('.toggle').on('click', function () {
            self.onToggle(this);
        });
    }

    onToggle = (toggle) => {
        toggle = jQuery(toggle);
        if (toggle.hasClass('open')) return this.closePanel(toggle);

        this.closePanel(this.wrapper.children('.toggle'));
        this.openPanel(toggle);
    }

    openPanel(toggle) {
        toggle.addClass('open');
        let panel = jQuery(toggle.next('.panel'));
        panel.css('max-height', panel.get(0).scrollHeight + "px");
    }
    closePanel(toggle) {
        toggle.removeClass('open');
        jQuery(toggle.next('.panel')).css('max-height', '0px');
    }
}

jQuery(document).ready(function () {
    jQuery('.accordion').each(function () {
        new PE_Accordion(jQuery(this));
    });
});