var guardianTable = $('.dt-guardians').DataTable({
    dom: 'lBftip',
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
            title: $('.dt-guardians').data('title')+"\n"+$('.dt-guardians').data('subtitle'),
            messageTop: `Generate with SYMANUS ${APP_VERSION} © ${APP_VERSION_YEAR}.` ,
        },
        {
            extend: 'pdf',
            title: $('.dt-guardians').data('title')+"\n"+$('.dt-guardians').data('subtitle'),
            messageTop: `Generate with SYMANUS ${APP_VERSION} © ${APP_VERSION_YEAR}.` ,
            footer: true,
        },
        {
            extend: 'print',
            footer: true,
            title: $('.dt-guardians').data('title')+"\n"+$('.dt-guardians').data('subtitle'),
            messageTop: `Generate with SYMANUS ${APP_VERSION} © ${APP_VERSION_YEAR}.` ,
        },
        'selectAll',
        'selectNone',
    ],
    ajax:{
        url: '/api/datatables/guardians',
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
            data: null, name:'firstname',
        render:function(data, type, row){
            if(type === 'display'){
                let icon = `<img src="${data.avatar?data.avatar:'/img/user.png'}" class="h-10 w-auto mx-1" />`;
                
                let d = '<div class="hs-tooltip inline-block [--trigger:hover] [--placement:right]">'
                +'<a class="hs-tooltip-toggle inline text-left" href="/guardians/'+data.id+'">'
                +'<span class="text-sm px-1  hover:bg-white hover:text-blue-600 transition">' 
                + data.id+'</span><div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity hidden md:inline-block absolute invisible z-10 py-3 px-4 bg-white border text-sm text-gray-600 rounded-md shadow-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400" role="tooltip">'
                +'<p class="flex uppercase py-3 items-end">'+icon+'<span class="underline">Guardian</span></p>'
                + '<p><b>Guardian Ref: </b>'+data.id+'</p>'
                + '<p><b>Guardian Name: </b>'+data.firstname+' '+data.surname+'</p>'
                + '<p><b>Guardian Phone: </b>'+(data.phone?data.phone:'')+'</p>'
                +'</div> </a> </div>';
                return d;
            }

            return data.id;
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
        data: 'phone',
    },
    {
        data: 'address',
    },
        { 
            data: 'students', 
            name: 'id',
            render: function(data, type, row){
                let students = '';
                data.forEach((st,i)=>{
                    let s = '';
                   students +=s.concat(`<a href="students/${st.id}" class="hover:text-sky-600">`,st.firstname, ' ', st.surname,`\n</a>`);
                });
                return students;
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
        {data: 'updated_at'},
        {data: 'created_at'},
        { 
            data: 'id', 
            render:function(data, type, row){
                if(type === 'display'){
                return `<div class="flex gap-3 items-center"><a href="guardians/${data}" class="text-gray-600 hover:text-sky-600"><i class="fa fa-eye"></i></a>
                        <a href="guardians/${data}/edit" class="text-gray-600 hover:text-sky-600"><i class="fa fa-edit"></i></a></div>`;
                }
                return data;
            }
        }
    ],
    searchPanes:{
        columns:[3,7],
    },
    columnDefs: [ 
        {
        orderable: false,
        className: 'select-checkbox',
        targets:   [0],
    },
    {
        orderable: false,
        targets:   [10],
    },
 ],
    select: {
        style: 'multi',
        selector: 'td:first-child'
    },
    order: [[ 10, 'asc' ]]
});
$('.dataTables_wrapper .dataTables_length select').css('padding', '6px 30px 6px 20px');
$('.dt-buttons').css('margin','auto 10px auto 10px');
$('.dataTables_paginate').css('margin-top', '5px').css('background-color','#f8f8f8').css('border-radius','.3em').css('background','#f8f8f8').css('box-shadow', '3px 3px #eee');

$('button.dt-button').css('background-color','#fff').css('border-radius','.3em').css('background','#fff').css('box-shadow', '3px 3px #eee');
$('.alert-processing').hide();
$('.dt-guardians').removeClass('hidden');

dtRowSelectAction(guardianTable);