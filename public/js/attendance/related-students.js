var studentTable = $('.dt-related-students').DataTable({
    dom: 'PlBftip',
    buttons:[
        {
            text: 'Reload',
            action: function ( e, dt, node, config ) {
                dt.ajax.reload();
            }
        },
        'print', 'pdf', 'excel',
        'selectAll',
        'selectNone',
    ],
    ajax:{
        url: '/api/datatables/attendance-related-students',
        dataType: 'json',
        contentType:'application/json',
        data: function(param){
            param.api_token = $('meta[name="api-token"]').attr('content');
            param.attendance_id = $('.dt-related-students').data('attendance-id');
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
            data: 'guardian', 
            name: 'guardian_id',
            render: function(data, type, row){
                if(type === 'display' && data) {

                    let d = '<div class="hs-tooltip inline-block [--trigger:hover] [--placement:right]">'
                    +'<a class="hs-tooltip-toggle inline text-left" href="../guardians/'+data.id+'">'
                    +'<span class="px-1 hover:bg-white hover:text-blue-600 transition">' 
                    + data.firstname +' '+data.surname+'</span><div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity hidden md:inline-block absolute invisible z-10 py-3 px-4 bg-white border text-sm text-gray-600 rounded-md shadow-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400" role="tooltip">'
                    +'<p class="flex py-3 items-end"><img class="h-8 mx-1" src="'+(data.avatar?'':'../img/user.png')+'"><span class="underline uppercase">User</span></p>'
                    + '<p><b>Guardian Ref: </b>'+data.username+'</p>'
                    + '<p><b>Guardian Name: </b>'+data.firstname +' '+data.surname+'</p>'
                    + '<p><b>Gaurdian Phone: </b>'+data.phone+'</p>'
                    +'</div> </a> </div>';

                    return d;
                }
                
                return data?data.firstname +' '+data.surname:'<span>Not Assigned</span>';
            },
        },
        {
            data: 'status',
            render:function(data, type, row){
                if(type === 'display'){
                    let labels = {
                        present: 'bg-green-600',
                        absent: 'bg-red-600'
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
        columns:[3,4,5,7],
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
        targets:   [8],
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