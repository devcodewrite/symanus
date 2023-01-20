
$(".submit").on("click",function(e){
    updateStatus("submitted", 'submit');
});

$(".approve").on("click",function(e){
    updateStatus("approved", 'approve');
});

$(".reject").on("click",function(e){
    updateStatus("rejected", 'reject');
});

$(".draft").on("click",function(e){
    updateStatus("draft", 'modify');
});
function updateStatus(status, action) {
    Swal.fire({
        title: "Are you sure ?",
        text:  `You want to ${action} this attendance!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: `Yes! ${action} it`,
        didOpen: () => {
            Swal.showLoading();
          },
    }).then((result) => {
        if (!result.isConfirmed) return Swal.fire("Record is safe!");

        $.ajax({
            method: "PUT",
            url: location.href,
            data: {
                status: status,
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
                    Swal.close();
                    location.reload();
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
