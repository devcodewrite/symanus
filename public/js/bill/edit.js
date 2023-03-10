$(".select2-fees")
    .select2({
        ajax: {
            url: "/api/select2/fees",
            dataType: "json",
            data: function (params) {
                params.api_token = $('meta[name="api-token"]').attr("content");
                return params;
            },
        },
        allowClear: true,
        placeholder: "Select the fee(s)",
    })
    .on("select2:select", function (e) {
        validator.checkAll(form[0]);
    });

$(".select2-feetype")
    .select2({
        allowClear: true,
        placeholder: "Select a fee type",
    })
    .on("select2:select", function (e) {
        validator.checkAll(form[0]);
    });

let form = $(".bill-details-form");

var validator = new FormValidator(
    {
        // shows alert tooltip
        alerts: true,
        // custom trigger events
        events: ["blur", "input", "onchange"],
        // predefined validators
        regex: {
            url: /^(https?:\/\/)?([\w\d\-_]+\.+[A-Za-z]{2,})+\/?/,
            phone: /^\+?([0-9]|[-|' '])+$/i,
            numeric: /^[0-9]+$/i,
            alphanumeric: /^[a-zA-Z0-9]+$/i,
            email: {
                illegalChars: /[\(\)\<\>\,\;\:\\\/\"\[\]]/,
                filter: /^.+@.+\..{2,6}$/, // exmaple email "steve@s-i.photo"
            },
        },
        // default CSS classes
        classes: {
            item: "field",
            alert: "alert",
            bad: "bad",
        },
        texts: {
            invalid: "input is not as expected",
            short: "input is too short",
            long: "input is too long",
            checked: "must be checked",
            empty: "please put something here",
            select: "Please select an option",
            number_min: "too low",
            number_max: "too high",
            url: "invalid URL",
            number: "not a number",
            email: "email address is invalid",
            email_repeat: "emails do not match",
            date: "invalid date",
            time: "invalid time",
            password_repeat: "passwords do not match",
            no_match: "no match",
            complete: "input is not complete",
        },
    },
    form[0]
);

form.on("submit", function (e) {
    e.preventDefault();
    let form = this;
    formValid = validator.checkAll(this);
    if (formValid.valid)
        Swal.fire({
            title: "Are you sure ?",
            text: "This will generate bills for students.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes! Generate it",
        }).then((result) => {
            if (!result.isConfirmed) return Swal.fire("Nothing done!");

            $.ajax({
                method: "POST",
                url: this.getAttribute("action"),
                data: new FormData(form),
                enctype: "multipart/form-data",
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
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
                        if (typeof d.input === "object") {
                            if (d.input._method === "post") {
                                $(form).trigger("reset");
                                $(".select2-fees,.select2-feetype")
                                    .val("")
                                    .trigger("change.select2");
                            }
                            let default_redirect =
                                form.getAttribute("data-redirect-url");
                            default_redirect = default_redirect
                                ? default_redirect + `/${d?.data?.id}`
                                : null;
                            let crrurl = new URL(location.href);
                            let backto = crrurl.searchParams.get("backtourl");
                            let redirect_url = backto
                                ? backto
                                : (d.data?default_redirect:form.getAttribute("data-redirect-url"));

                            if (redirect_url && !d.input?.stay)
                                setTimeout(location.assign(redirect_url), 500);
                        }
                        Swal.fire({
                            icon: "success",
                            text: d.message,
                        });
                    } else {
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
});
