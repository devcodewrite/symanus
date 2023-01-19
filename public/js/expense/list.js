var expenseTable = $('.dt-expense-reports').DataTable({
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
        url: '/api/datatables/expense-reports',
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
    initComplete:function(settings){
        $('.dataTables_wrapper table').wrap('<div style="overflow-x:auto;" class="w-full"></div>'); 
    },
    columns:[
        {
            data: 'id',
            render:function(data, type, row){
                return null;
            }
        },
        {
            data: null, name:'id',
        render:function(data, type, row){
            if(type === 'display'){
                let icon = $('.svg-icon-payment')[0].outerHTML;
                
                let d = '<div class="hs-tooltip inline-block [--trigger:hover] [--placement:right]">'
                +'<a class="hs-tooltip-toggle inline text-left" href="/expense-reports/'+data.id+'">'
                +'<span class="text-sm px-1  hover:bg-white hover:text-blue-600 transition">' 
                + data.id+'</span><div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity hidden md:inline-block absolute invisible z-10 py-3 px-4 bg-white border text-sm text-gray-600 rounded-md shadow-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400" role="tooltip">'
                +'<p class="flex uppercase py-3">'+icon+'<span class="underline">Expense Report</span></p>'
                + '<p><b>Expense Report Ref: </b>'+data.id+'</p>'
                + '<p><b>Report From: </b>'+data.from_date+'</p>'
                + '<p><b>Report To: </b>'+data.to_date+'</p>'
                +'</div> </a> </div>';
                return d;
            }

            return data.id;
         }
    },
        { data: 'from_date' },
        { data: 'to_date' },
        { 
            data: 'user', 
            name: 'users.firstname',
            render:function(data, type, row){
                if(type === 'display')
                    return `${data.firstname} ${data.surname}`;

                return `${data.firstname} ${data.surname}`;
            } 
        },
        { 
            data: 'approval_user', 
            name: 'users.firstname',
            render:function(data, type, row){
                if(type === 'display')
                    return `${data.firstname} ${data.surname}`;

                return `${data.firstname} ${data.surname}`;
            } 
        },
        { 
            data: 'expense_type', 
            name: 'expense_type_id',
            render:function(data, type, row){
                return data?data.title:null;
            } 
        },
        { data:'updated_at'},
        { data:'created_at'},
        { 
            data: 'id', 
            render:function(data, type, row){
                if(type === 'display'){
                return `<div class="flex gap-3 items-center"><a href="expense-reports/${data}" class="text-gray-600 hover:text-sky-600"><i class="fa fa-eye"></i></a>
                        <a href="expense-reports/${data}/edit" class="text-gray-600 hover:text-sky-600"><i class="fa fa-edit"></i></a></div>`;
                }
                return data;
            }
        }
    ],
    searchPanes:{
        columns:[4,5,6],
    },
    columnDefs: [ 
        {
        orderable: false,
        className: 'select-checkbox',
        targets:   [0],
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
$('.dt-expense-reports').removeClass('hidden');

dtRowSelectAction(expenseTable);