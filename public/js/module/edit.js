
let form = $(".module-form");

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
                    Swal.fire({
                        icon: "success",
                        text: d.message,
                    });
                }else {
                    Swal.fire({
                        icon: "error",
                        text: d.message,
                    });
                }

                setTimeout(function(){ location.reload() }, 500);
            },
            error: function (r) {
                Swal.fire({
                    icon: "error",
                    text: "Unable to submit form! Please try agian.",
                });
            },
        });
});
