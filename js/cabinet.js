var l = console.log.bind(console);
$(function(){
	$.extend( $.fn.dataTable.defaults, {
        dom: '<"datatable-header"><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            "url": "/vendors/datatables/Russian.json"
        }
    });
    $('.daterange-basic').daterangepicker({
        autoApply: true,
        applyClass: 'bg-slate-600',
        cancelClass: 'btn-default',
        separator: ' - ',
        ranges: {
            'Сегодня': [moment(), moment()],
            'Вчера': [moment().subtract('days', 1), moment().subtract('days', 1)],
            'Последние 7 дней': [moment().subtract('days', 6), moment()],
            'Последние 30 дней': [moment().subtract('days', 29), moment()],
            'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
            'Прошедший месяц': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        },
        locale: {
            format: 'DD.MM.YYYY',
            applyLabel: 'Вперед',
            cancelLabel: 'Отмена',
            startLabel: 'Начальная дата',
            endLabel: 'Конечная дата',
            customRangeLabel: 'Выбрать дату',
            daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт','Сб'],
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            firstDay: 1
        }
    });
    $('ul.nav-sidebar li').each(function(){
        if ($(this).find('a').size() && $(this).find('a').attr('href') == window.location.pathname)
            $(this).addClass('active');
    });
    $('.date').mask('99.99.9999');
    $('.time').mask('99:99');
    $('.mask').each(function(){
        $(this).mask( $(this).attr('mask') );
    });
    $('.station-name').inputHint('/employee/home/StationsHint');
    $('.cargo-type').inputHint('/employee/home/CargoTypeHint');
    improveTabs();
    disableEnterSubmit( $('.no-enter-submit') );
    submitIfFilled( $('.submit-if-filled') );
});

function disableEnterSubmit(form)
{
    $(form).on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            return false;
        }
    });
}

function submitIfFilled(form)
{
    form.submit(function(){
        var filled = true;
        $(form).find('input[type=text]:visible:not(.optional)').each(function(){
            if (!$(this).val()) filled = false;
        });
        return filled;
    });
}

function improveTabs()
{
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    } 

    // Change hash for page-reload
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });
}

function minutesToText( m )
{
    var t = '';
    if (m > 60) {
        var h = Math.floor(m / 60);
        t =  h + getWordForm(h, ' час ', ' часа ', ' часов ');
        m %= 60;
    }
    t += m + getWordForm(m, ' минута', ' минуты', ' минут');
    return t;
}

function getWordForm(n, w1, w2, w3)
{
    if (typeof n == 'number') n = n.toString();
    var last_digit = n[n.length-1];
    if (n.length>=2)
    {
        var last_two_digits = n[n.length-2] + n[n.length-1];
        if ($.inArray(last_two_digits, ['11', '12', '13', '14', '15', '16', '17', '18', '19'])!=-1) return w3;
    }
    if ($.inArray(last_digit, ['0', '5', '6', '7', '8', '9'])!=-1) return w3;
    if (last_digit == '1') return w1;
    if ($.inArray(last_digit, ['2', '3', '4'])!=-1) return w2;
}