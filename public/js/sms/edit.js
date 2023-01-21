const paymentForm = $(".sms-edit-form").on("submit", payWithPaystack);

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
    paymentForm[0]
);

function payWithPaystack(e) {
    e.preventDefault();
    formValid = validator.checkAll(this);
    let form = this;
    formValid = validator.checkAll(this);
    if (formValid.valid) {
        let handler = PaystackPop.setup({
            key: MIX_PAYSTACK_PUBLIC_KEY,
            email: document.getElementById("email").value,
            amount: document.getElementById("amount").value * 100,
            ref: Math.floor(100000 + Math.random() * 900000 + 1),
            currency: MIX_PAYSTACK_CURRENCY,
            onClose: function () {},
            callback: function (response) {
                $.ajax({
                    url: `${location.href}?action=confirm&ref=${response.reference}`,
                    dateType: "json",
                    success: function (data, status) {
                        if (data.status === true) {
                            paymentForm.trigger("reset");
                            Swal.fire({
                                icon: "success",
                                text: data.message,
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false,
                            });
                            window.setTimeout(window.location.reload(), 3000);
                        } else {
                            Swal.fire({
                                icon: "error",
                                text: data.message,
                                type: "error",
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }
                    },
                });
            },
        });

        handler.openIframe();
    }
}

var table = $('.dt-credits').DataTable({
    order: [[ 3, 'desc' ]],
});

$('.dataTables_wrapper .dataTables_length select').css('padding', '6px 30px 6px 20px');
$('.dt-buttons').css('margin','auto 10px auto 10px');
$('.dataTables_paginate').css('margin-top', '5px').css('background-color','#f8f8f8').css('border-radius','.3em').css('background','#f8f8f8').css('box-shadow', '3px 3px #eee');

$('button.dt-button').css('background-color','#fff').css('border-radius','.3em').css('background','#fff').css('box-shadow', '3px 3px #eee');

$('.dataTables_wrapper table').wrap('<div style="overflow-x:auto;" class="w-full"></div>'); 