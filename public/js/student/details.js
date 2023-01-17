$('.close').on('click',function(e){
    updateStatus('close', 'close');
});

function updateStatus(status, action) {
    Swal.fire({
        title: "Are you sure ?",
        text:  `You wan to ${action} this record!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: `Yes! ${action} it`,
    }).then((result) => {
        if (!result.isConfirmed) return Swal.fire("Record is safe!");

        $.ajax({
            method: "PUT",
            url: location.href,
            data: {
                rstate: status,
                _token: $('meta[name="csrf-token"]').attr("content")
            },
            dataType: "json",
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
                    Swal.fire({
                        icon: "success",
                        text: d.message,
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 600);
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
}
