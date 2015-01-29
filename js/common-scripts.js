var protocol = window.location.protocol;
var base_url = protocol + "//" + document.location.hostname + "/office/";
var index_page = "";

function getDataUrl(p)
{
    var jqXHR = $.ajax({
        type: "get",
        url: base_url + index_page + p.url,
        data: p.v,
        cache: false,
        async: false
    });
    return jqXHR.responseText;
}

function genModal(p)
{
    if (p.type === 'confirm')
    {
        $('#myModal .modal-footer').show();
        $('#myModal .modal-title, #myModal .modal-body').empty();
        $('#myModal .modal-footer #button-close, #button-confirm').show();
        $('#myModal .modal-footer #button-ok').hide();
        $('#myModal .modal-title').html(p.title);
        $('#myModal .modal-body').html('<div class="text-center">' + p.text + '</div>');
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: true
        });
    } else if (p.type === 'alert')
    {
        $('#myModal .modal-title, #myModal .modal-body').empty();
        $('#myModal .modal-footer').hide();
        $('#myModal .modal-title').html(p.title);
        $('#myModal .modal-body').html(p.text);
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: true
        });
    } else if (p.type === 'info')
    {
        $('#myModal .modal-title, #myModal .modal-body').empty();
        $('#myModal .modal-footer #button-close, #button-confirm').hide();
        $('#myModal .modal-footer #button-ok').show();
        $('#myModal .modal-title').html(p.title);
        $('#myModal .modal-body').html(p.text);
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: true
        });
    } else {
        $.ajax({
            type: "get",
            url: base_url + index_page + p.url,
            data: p.v,
            cache: false,
            dataType: 'html',
            success: function (result) {
                try {
                    $('#myModal .modal-title, #myModal .modal-body').empty();
                    $('#myModal .modal-footer').hide();
                    $('#myModal .modal-title').html(p.title);
                    $('#myModal .modal-body').html(result);
                    $('#myModal').modal({
                        backdrop: 'static',
                        keyboard: true,
                        width: '680px'
                    });
                } catch (e) {
                    alert('Exception while request..');
                }
            },
            error: function (e) {
                alert('Error while request..');
            }
        });
    }
}

function deleteData(p)
{
    if (p.type === 'general')
    {
        var data = {
            title: p.title,
            type: 'confirm',
            text: 'คุณต้องการลบรายการนี้ใช่หรือไม่ ?'
        };
        genModal(data);

        $('body').on('click', '#myModal #button-confirm', function () {
            var data3 = {
                url: p.url,
                redirect: p.redirect
            };
            var rs = getDataUrl(data3);
            var obj = $.parseJSON(rs);
            if (obj.error.status === true)
            {
                $('#myModal .modal-footer').hide();
                $('#myModal .modal-body').empty();
                $('#myModal .modal-body').html('<div class="text-center"><p><i class="fa fa-spinner fa-spin fa-2x"></i></p>' + obj.error.message + '</div>');
                setTimeout(function () {
                    $('#myModal').modal('hide');
                    $('#myModal').on('hidden.bs.modal', function (e) {
                        window.location.href = base_url + p.redirect;
                    });
                }, 3000);
            } else {

                $('#myModal .modal-footer').show();
                $('#myModal .modal-footer #button-close, #button-confirm').hide();
                $('#myModal .modal-footer #button-ok').show();
                $('#myModal .modal-body').empty();
                $('#myModal .modal-body').html('<div class="text-center">' + obj.error.message + '</div>');
            }
        });
    } else {
        var data = {
            title: p.title,
            type: 'confirm',
            text: 'คุณต้องการลบรายการนี้ใช่หรือไม่ ?'
        };

        genModal(data);

        $('body').on('click', '#myModal #button-confirm', function () {
            var data2 = {
                url: p.url
            };
            var rs = getDataUrl(data2);
            var obj = $.parseJSON(rs);
            if (obj.error.status === true)
            {
                $('#myModal .modal-footer').hide();
                $('#myModal .modal-body').empty();
                $('#myModal .modal-body').html('<div class="text-center"><p><i class="fa fa-spinner fa-spin fa-2x"></i></p>' + obj.error.message + '</div>');
                setTimeout(function () {
                    $('#myModal').modal('hide');
                    $('#myModal').on('hidden.bs.modal', function (e) {
                        window.location.href = base_url + index_page + obj.error.redirect;
                    });
                }, 3000);
            } else {
                $('#myModal .modal-footer').show();
                $('#myModal .modal-footer #button-close, #button-confirm').hide();
                $('#myModal .modal-footer #button-ok').show();
                $('#myModal .modal-body').empty();
                $('#myModal .modal-body').html('<div class="text-center">' + obj.error.message + '</div>');
            }
        });
    }


}

var delay = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();

$('body').on('click', '.link_dialog', function () {
    var data = {
        title: 'Loading',
        type: 'alert',
        text: '<div class="text-center"><p><i class="fa fa-spinner fa-spin fa-2x"></i></p></div>'
    };
    genModal(data);
    if ($(this).attr('rel') !== '')
    {
        if ($(this).hasClass('delete')) {
            var data = {
                url: $(this).attr('rel'),
                title: $(this).attr('title')
            };
            deleteData(data);
        } else {
            var data = {
                url: $(this).attr('rel'),
                title: $(this).attr('title')
            };
            genModal(data);
        }
    }
});

$(function () {
    $('#nav-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        saveState: true,
        disableLink: true,
        speed: 'slow',
        showCount: false,
        autoExpand: true,
//        cookie: 'dcjq-accordion-1',
        classExpand: 'dcjq-current-parent'
    });
});
var Script = function () {
//    sidebar dropdown menu auto scrolling
    jQuery('#sidebar .sub-menu > a').click(function () {
        var o = ($(this).offset());
        diff = 250 - o.top;
        if (diff > 0)
            $("#sidebar").scrollTo("-=" + Math.abs(diff), 500);
        else
            $("#sidebar").scrollTo("+=" + Math.abs(diff), 500);
    });
//    sidebar toggle
    $(function () {
        function responsiveView() {
            var wSize = $(window).width();
            if (wSize <= 768) {
                $('#container').addClass('sidebar-close');
                $('#sidebar > ul').hide();
            }

            if (wSize > 768) {
                $('#container').removeClass('sidebar-close');
                $('#sidebar > ul').show();
            }
        }
        $(window).on('load', responsiveView);
        $(window).on('resize', responsiveView);
    });
    $('.fa-bars').click(function () {
        if ($('#sidebar > ul').is(":visible") === true) {
            $('#main-content').css({
                'margin-left': '0px'
            });
            $('#sidebar').css({
                'margin-left': '-210px'
            });
            $('#sidebar > ul').hide();
            $("#container").addClass("sidebar-closed");
        } else {
            $('#main-content').css({
                'margin-left': '210px'
            });
            $('#sidebar > ul').show();
            $('#sidebar').css({
                'margin-left': '0'
            });
            $("#container").removeClass("sidebar-closed");
        }
    });
// custom scrollbar
    $("#sidebar").niceScroll({styler: "fb", cursorcolor: "#e8403f", cursorwidth: '3', cursorborderradius: '10px', background: '#404040', spacebarenabled: false, cursorborder: ''});
    $("html").niceScroll({styler: "fb", cursorcolor: "#e8403f", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled: false, cursorborder: '', zindex: '1000'});
// widget tools
    jQuery('.panel .tools .fa-chevron-down').click(function () {
        var el = jQuery(this).parents(".panel").children(".panel-body");
        if (jQuery(this).hasClass("fa-chevron-down")) {
            jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200);
        }
    });
    jQuery('.panel .tools .fa-times').click(function () {
        jQuery(this).parents(".panel").parent().remove();
    });
//    tool tips
    $('.tooltips').tooltip();
//    popovers
    $('.popovers').popover();
// custom bar chart
    if ($(".custom-bar-chart")) {
        $(".bar").each(function () {
            var i = $(this).find(".value").html();
            $(this).find(".value").html("");
            $(this).find(".value").animate({
                height: i
            }, 2000)
        })
    }
}();

$(document).keyup(function (e) {
    if (e.keyCode == 119) {
        var data = {
            title: 'Loading',
            type: 'alert',
            text: '<div class="text-center"><p><i class="fa fa-spinner fa-spin fa-2x"></i></p></div>'
        };
        genModal(data);
        var data = {
            url: $('.link_dialog').attr('rel'),
            title: $('.link_dialog').attr('title')
        };
        genModal(data);
    }
    if (e.keyCode == 120) {

    }
    if (e.keyCode == 13) {
        alert('Enter');
    }
});