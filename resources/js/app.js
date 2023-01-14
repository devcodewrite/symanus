require("./bootstrap");

import "preline";
import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import $ from "jquery";
window.$ = window.jQuery = $;

require('./vue-attendance');

window.JSZip = require("jszip");
let pdfmake = require("pdfmake");
let pdffonts = require("pdfmake/build/vfs_fonts.js");
pdfmake.vfs = pdffonts.pdfMake.vfs;
import Swal from "sweetalert2";
window.Swal = Swal;

require("datatables.net");
require("datatables.net-bs5");
require("datatables.net-buttons");
require("datatables.net-responsive");
require("datatables.net-responsive-dt");
require("datatables.net-buttons/js/buttons.colVis.js");
require("datatables.net-buttons/js/buttons.html5.js");
require("datatables.net-buttons/js/buttons.print.js");
require("datatables.net-buttons/js/buttons.flash");
require("datatables.net-datetime");
require("datatables.net-searchbuilder-dt");
require("datatables.net-searchpanes-dt");
require("datatables.net-select-dt");
require("select2");

$(".select2").select2();

$(".dt-action-select")
    .select2()
    .on("change select2:select", function (e) {
        if ($(this).val() !== "")
            $(".dt-action").find(".dt-action-btn").prop("disabled", false);
        else $(".dt-action").find(".dt-action-btn").prop("disabled", true);
    });

window.dtRowSelectAction = function (table) {
    table.on("select deselect", function (e, dt, type, indexes) {
        if (type === "row" && dt.rows({ selected: true }).count() > 0) {
            $(".dt-action").addClass("show");
        } else if (type === "row") {
            $(".dt-action").removeClass("show");
        }
    });

    $(".dt-action-btn").on("click", function (e) {
        let action = $(".dt-action-select").val();
        let target = $(this).data("target-url");
        if (action === "delete") {
            swal({
                icon: "warning",
                title: "Are you sure ?",
                text: "Once deleted, you will not be able to recover this record!",
                buttons: true,
            }).then(function (val) {
                let data = [],
                    rows = table.rows({ selected: true}).data();
                for (let i = 0; i < rows.length; i++) {
                    data.push(rows[i]);
                }
                if (val) {
                  handleDtPostAction(table, action,target, data);
                } else {
                    swal("Your record is safe!");
                }
            });
        }
        else if (action === "open-rstate") {
            swal({
                icon: "warning",
                title: "Are you sure ?",
                text: "This will set the record(s) status to open.",
                buttons: true,
            }).then(function (val) {
                let data = [],
                    rows = table.rows({ selected: true}).data();
                for (let i = 0; i < rows.length; i++) {
                    data.push(rows[i]);
                }
                if (val) {
                  handleDtPostAction(table, action,target, data);
                } else {
                    swal("Your record is safe!");
                }
            });
        }
        else if (action === "close-rstate") {
            swal({
                icon: "warning",
                title: "Are you sure ?",
                text: "This will set the record(s) status to close.",
                buttons: true,
            }).then(function (val) {
                let data = [],
                    rows = table.rows({ selected: true}).data();
                for (let i = 0; i < rows.length; i++) {
                    data.push(rows[i]);
                }
                if (val) {
                  handleDtPostAction(table, action,target, data);
                } else {
                    swal("Your record is safe!");
                }
            });
        }
        else if (action === "present-status") {
            swal({
                icon: "warning",
                title: "Are you sure ?",
                text: "This will set the record(s) status to present.",
                buttons: true,
            }).then(function (val) {
                let data = [],
                    rows = table.rows({ selected: true}).data();
                for (let i = 0; i < rows.length; i++) {
                    data.push(rows[i]);
                }
                if (val) {
                  handleDtPostAction(table, action,target, data);
                } else {
                    swal("Your record is safe!");
                }
            });
        }
        else if (action === "absent-status") {
            swal({
                icon: "warning",
                title: "Are you sure ?",
                text: "This will set the record(s) status to absent.",
                buttons: true,
            }).then(function (val) {
                let data = [],
                    rows = table.rows({ selected: true}).data();
                for (let i = 0; i < rows.length; i++) {
                    data.push(rows[i]);
                }
                if (val) {
                  handleDtPostAction(table, action,target, data);
                } else {
                    swal("Your record is safe!");
                }
            });
        }
    });
};

function handleDtPostAction(table, action, target, data){
    $.ajax({
        url: target,
        method: "PUT",
        data: JSON.stringify({
            action: action,
            data: data,
            api_token: $('meta[name="api-token"]').attr(
                "content"
            ),
        }),
        dataType: "json",
        contentType: "application/json",
        cache: false,
        processData: false,
        success: function (d, r) {
            if (!d || r === "nocontent") {
                swal({
                    icon: "error",
                    text: "No content! Please try agian.",
                });
                return;
            }
            if (
                typeof d.status !== "boolean" ||
                typeof d.message !== "string"
            ) {
                swal({
                    icon: "error",
                    text: "Malformed data response! Please try agian.",
                });
                return;
            }
            $(".dt-action-select").val(null).trigger('change');

            if (d.status === true) {
                swal({
                    icon: "success",
                    text: d.message,
                });
                table.ajax.reload();
                table.ajax.searchPanes.reload();
                $(".dt-action-btn").prop('disabled', true);
                $(".dt-action").removeClass("show");
            } else {
                swal({
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
}

 window.changeParam = function(url, param, val) {
    var href = new URL(url);
    href.searchParams.set(param, val);
    return href.toString();
}

window.readURL = function(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.avatar-placeholder').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$( window).on('scroll',function() {
    sessionStorage.setItem("scroll_position_y"+location.href, $(this).first().scrollTop());
});

$('#application-sidebar').animate({
    scrollTop: $("li.hs-accordion.active").first().offset().top
}, 2000);

let scrollPositionY = sessionStorage.getItem("scroll_position_y"+location.href);
setTimeout(function(){
    $('html,body').animate({
        scrollTop: scrollPositionY?scrollPositionY:0
    }, 100);
},1000);


/* 
window.testTable = $('table').DataTable({
    dom: 'PlBftip',
    buttons:[
        'print','copy', 'csv', 'pdf', 'excel'
    ],
    ajax:{
        url: '/api/test',
        dataType: 'json',
        contentType:'application/json',
        data: function(param){
            param.api_token = $('meta[name="api-token"]').attr('content');
        }
    },
    processing: true,
    serverSide: true,
    search:true,
    stateSave: true,
    drawCallback:function(){
        $('.dataTables_paginate .paginate_button')
        .css('background','#fff')
        .css('border-radius','.3em')
        .css('border-color','transparent')
        .css('box-shadow', '3px 3px #eee')
        .mouseover(function(){
            $(this).hasClass('disabled')?null:$(this).css('background', '#0101f0').children().css('color', 'white');
        }).mouseout(function(){
            $(this).hasClass('disabled')
            ?null:($(this).hasClass('active')
            ?$(this).css('background', '#0101f0').children().css('color', 'white')
            :$(this).css('background', '#fff').children().css('color', 'black'));
        });
        $('.dataTables_paginate .paginate_button').each(function(i,e){
            $(e).hasClass('active')?$(e).css('background', '#0101f0').children().css('color', 'white')
            :$(e).css('background', '#fff').children().css('color', 'black');
        });
    },
    columns:[
        { data: 'firstname', name:'firstname' },
        { data: 'surname', name: 'lastname' },
        { data: 'studentid', name: 'studentid'},
        { data: 'sex', name: 'sex'},
        { 
            data: 'class', 
            name: 'class',
            render: function(data, type, row){
                return data.name;
            }
        },
    ],
    searchPanes:{
        columns:[3,4],
    },
});
$('.dataTables_wrapper .dataTables_length select').css('padding', '6px 30px 6px 20px');
$('.dt-buttons').css('margin','auto 10px auto 10px');
$('.dataTables_paginate').css('margin-top', '5px').css('background-color','#f8f8f8').css('border-radius','.3em').css('background','#f8f8f8').css('box-shadow', '3px 3px #eee');

$('button.dt-button').css('background-color','#fff').css('border-radius','.3em').css('background','#fff').css('box-shadow', '3px 3px #eee');
$('.dataTables_wrapper table').wrap('<div class="overflow-x-auto w-full"></div>');
 */
