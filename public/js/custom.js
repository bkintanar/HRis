$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var utcHandler = function(format, self){
        var utc = $(self).data('utc'),
            local = moment.utc(utc).toDate();

        if(utc === undefined || utc === '') return;
        $(self).text(moment(local).format(format));
    };

    $('.time').each(function(){utcHandler('hh:mm A', this)});
    $('.date').each(function(){utcHandler('MMM D, YYYY', this)});
});