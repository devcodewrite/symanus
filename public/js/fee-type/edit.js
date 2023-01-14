
let form = $(".fee-type-details-form");

form.on("submit", function (e) {
    e.preventDefault();
    let form = this;
        $.ajax({
            method: 'POST',
            url: this.getAttribute("action"),
            data: new FormData(form),
            enctype: 'multipart/form-data',
            dataType: "json",
            contentType: false,
            processData: false,
            cache:false,
            success: function (d, r) {
                if (!d || r === "nocontent") {
                    Swal.fire({
                        icon: "error",
                        text: "Malformed form data sumbitted! Please try agian.",
                    });
                    return;
                }
                if (
                    typeof d.status !== "boolean" ||
                    typeof d.message !== "string"
                ) {
                    Swal.fire({
                        icon: "error",
                        text: "Malformed data response! Please try agian.",
                    });
                    return;
                }

                if (d.status === true) {
                    if(typeof d.input === 'object'){
                        if(d.input._method === 'post'){
                            $(form).trigger('reset');
                            $('select').val('').trigger('change.select2');
                        }
                        let default_redirect = form.getAttribute('data-redirect-url');
                            default_redirect = default_redirect?default_redirect+`/${d.data.id}`:null;
                        let crrurl = new URL(location.href);
                        let backto = crrurl.searchParams.get('backtourl');
                        let redirect_url = backto?backto:default_redirect;

                        if(redirect_url && !d.input?.stay) setTimeout(location.assign(redirect_url),500);
                    }
                    
                    location.assign(changeParam(location.href, 'id', ''));
                }else {
                    Swal.fire({
                        icon: "error",
                        text: d.message,
                    });
                }
            },
            error: function (r) {
                Swal.fire({
                    icon: "error",
                    text: "Unable to submit form! Please try agian.",
                });
            },
        });
});
