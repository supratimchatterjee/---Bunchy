(function ($) {

    $(document).ready( function() {

        handleMultiCheckboxControl();

    });

    function handleMultiCheckboxControl () {

        $('.customize-control-multi-checkbox input[type="checkbox"]').on( 'change', function() {

                var $checked = $(this).parents('.customize-control').find('input[type="checkbox"]:checked');
                var $hidden = $(this).parents('.customize-control').find('input[type="hidden"]');

                var values = $checked.map(
                    function() {
                        return this.value;
                    }
                ).get().join(',');

                $hidden.val(values).trigger('change');
            }
        );
    }

})(jQuery);