
$(".select2-expensetype").select2({
    allowClear: true,
    placeholder: "Select a expense type",
}).on('select2:select', function(e){
   validator.checkAll(form[0]);
});

let form = $(".expense-details-form");
let deleteButton = $(".delete-expense");

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

deleteButton.on("click", function (e) {
    e.preventDefault();
    Swal.fire({
        title:'Are you sure ?',
        text: "You will not be able to recover this record.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes! delete it",
    }).then(result => {
        if(!result.isConfirmed) return Swal.fire("Record is safe!");

        $.ajax({
            method: 'DELETE',
            url: this.getAttribute("href"),
            headers: {
                'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
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
                    location.reload();
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
    })
});


var expenseItemTable = $('.dt-expenses').DataTable({
    order: [[ 3, 'desc' ]],
});

$('.dataTables_wrapper .dataTables_length select').css('padding', '6px 30px 6px 20px');
$('.dt-buttons').css('margin','auto 10px auto 10px');
$('.dataTables_paginate').css('margin-top', '5px').css('background-color','#f8f8f8').css('border-radius','.3em').css('background','#f8f8f8').css('box-shadow', '3px 3px #eee');

$('button.dt-button').css('background-color','#fff').css('border-radius','.3em').css('background','#fff').css('box-shadow', '3px 3px #eee');


dtRowSelectAction(expenseItemTable);

$('.dataTables_wrapper table').wrap('<div style="overflow-x:auto;" class="w-full"></div>'); 
