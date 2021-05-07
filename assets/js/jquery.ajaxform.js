(function($) {
    $.fn.ajaxForm = function(callback) {
        this.submit(function(e) {
            if (e.preventDefault) {
                e.preventDefault();
            }

            var elements = $(e.target).serializeArray();
            var params = {}, i;
            for (i in elements) {
                element = elements[i];
                if (element.name in params) {
                    if (!(params[element.name] instanceof Array)) {
                        params[element.name] = Array(params[element.name]);
                    }
                    params[element.name].push(element.value);
                } else {
                    params[element.name] = element.value;
                }
            }

            $.ajax({
                url: e.target.action,
                traditional: true,
                data: params,
                type: "POST",
                success: callback
            });

            return false;
        });
    };
})(jQuery);