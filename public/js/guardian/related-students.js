var studentTable = $('.dt-related-students').DataTable({
    dom: 'PlBftip',
    buttons:[
        {
            text: 'Reload',
            action: function ( e, dt, node, config ) {
                dt.ajax.reload();
            }
        },
        {
            extend: 'excel',
            footer: true,
            title: $('.dt-related-students').data('title')+"\n"+$('.dt-related-students').data('subtitle'),
            messageTop: `Generate with SYMANUS ${APP_VERSION} © ${APP_VERSION_YEAR}.` ,
        },
        {
            extend: 'pdf',
            title: $('.dt-related-students').data('title')+"\n"+$('.dt-related-students').data('subtitle'),
            messageTop: `Generate with SYMANUS ${APP_VERSION} © ${APP_VERSION_YEAR}.` ,
            footer: true,
        },
        {
            extend: 'print',
            footer: true,
            title: $('.dt-related-students').data('title')+"\n"+$('.dt-related-students').data('subtitle'),
            messageTop: `Generate with SYMANUS ${APP_VERSION} © ${APP_VERSION_YEAR}.` ,
        },
        'selectAll',
        'selectNone',
    ],
    ajax:{
        url: '/api/datatables/guardian-related-students',
        dataType: 'json',
        contentType:'application/json',
        data: function(param){
            param.api_token = $('meta[name="api-token"]').attr('content');
            param.guardian_id = $('.dt-related-students').data('guardian-id');
        }
    },
    processing: true,
    serverSide: true,
    search:true,
    stateSave: true,
    drawCallback:function(){
        $('.dt-related-students.dataTables_paginate .paginate_button')
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
        $('.dt-related-students.dataTables_paginate .paginate_button').each(function(i,e){
            $(e).hasClass('active')?$(e).css('background', '#0101f0').children().css('color', 'white')
            :$(e).css('background', '#fff').children().css('color', 'black');
        });
    },
    initComplete:function(settings){
        $('.dt-related-students.dataTables_wrapper table').wrap('<div style="overflow-x:auto;" class="w-full"></div>'); 
    },
    columns:[
        {
            data: 'id',
            render:function(data, type, row){
                return null;
            }
        },
        {
            data: null, name:'studentid',
            render:function(data, type, row){
            if(type === 'display'){
                let icon = data.avatar?`<img src="${data.avatar}" class="h-10 w-auto" />`:$('.svg-icon-student')[0].outerHTML;
                
                let d = '<div class="hs-tooltip inline-block [--trigger:hover] [--placement:right]">'
                +'<a class="hs-tooltip-toggle inline text-left" href="../students/'+data.id+'">'
                +'<span class="text-sm px-1  hover:bg-white hover:text-blue-600 transition">' 
                + data.studentid+'</span><div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity hidden md:inline-block absolute invisible z-10 py-3 px-4 bg-white border text-sm text-gray-600 rounded-md shadow-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400" role="tooltip">'
                +'<p class="flex uppercase py-3">'+icon+'<span class="underline">Class</span></p>'
                + '<p><b>Student Ref: </b>'+data.studentid+'</p>'
                + '<p><b>Student Name: </b>'+data.firstname+' '+data.surname+'</p>'
                + '<p><b>Student Address: </b>'+(data.address?data.address:'')+'</p>'
                +'</div> </a> </div>';
                return d;
            }

            return data.studentid;
         }
    },
    {
        data: null,name:'firstname',
        render:function(data, type, row){
            return data.firstname + ' ' + data.surname;
        }
    },
    {
        data: 'sex',
        render:function(data, type, row){
            return data.toUpperCase();
        }
    },
    {
        data: 'class',
        render:function(data, type, row){
            return data.name.toUpperCase();
        }
    },
        {
            data: 'transit',
            render:function(data, type, row){
                return data.toUpperCase();
            }
        },
        {
            data: 'affiliation',
            render:function(data, type, row){
                return data.toUpperCase();
            }
        },
        {
            data: 'rstate',
            render:function(data, type, row){
                if(type === 'display'){
                    let labels = {
                        open: 'bg-green-600',
                        close: 'bg-red-600'
                    };
                    return `<span class="p-1 px-2 text-white rounded ${labels[data]}">${data.toUpperCase()}</span>`;
                }
                return data;
            }
        },
        {
            data:'updated_at',
        },

        { 
            data: 'id', 
            render:function(data, type, row){
                if(type === 'display'){
                return `<div class="flex gap-3 items-center"><a href="../students/${data}" class="text-gray-600 hover:text-sky-600"><i class="fa fa-eye"></i></a>
                        <a href="../students/${data}/edit" class="text-gray-600 hover:text-sky-600"><i class="fa fa-edit"></i></a></div>`;
                }
                return data;
            }
        }
    ],
    searchPanes:{
        columns:[3,5,4,7],
        layout: 'columns-4',
    },
    columnDefs: [ 
        {
        orderable: false,
        className: 'select-checkbox',
        targets:   [0],
    },
    {
        orderable: false,
        targets:   [9],
    },
 ],
    select: {
        style: 'multi',
        selector: 'td:first-child'
    },
    order: [[ 1, 'asc' ]]
});
$('.dataTables_wrapper .dataTables_length select').css('padding', '6px 30px 6px 20px');
$('.dt-buttons').css('margin','auto 10px auto 10px');
$('.dataTables_paginate').css('margin-top', '5px').css('background-color','#f8f8f8').css('border-radius','.3em').css('background','#f8f8f8').css('box-shadow', '3px 3px #eee');

$('button.dt-button').css('background-color','#fff').css('border-radius','.3em').css('background','#fff').css('box-shadow', '3px 3px #eee');
$('.alert-processing').hide();

dtRowSelectAction(studentTable);