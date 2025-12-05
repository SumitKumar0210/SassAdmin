(function ($) {
    "use strict";
    $(document).on("click", function (e) {
        var outside_space = $(".outside");
        if (
            !outside_space.is(e.target) &&
            outside_space.has(e.target).length === 0
        ) {
            $(".menu-to-be-close").removeClass("d-block");
            $(".menu-to-be-close").css("display", "none");
        }
    });

    $('.prooduct-details-box .close').on('click', function (e) {
        var tets = $(this).parent().parent().parent().parent().addClass('d-none');
    })



    if ($('.page-wrapper').hasClass('horizontal-wrapper')) {

        $(".sidebar-list").hover(
            function () {
                $(this).addClass("hoverd");
            },
            function () {
                $(this).removeClass("hoverd");
            }
        );
        $(window).on('scroll', function () {
            if ($(this).scrollTop() < 600) {
                $(".sidebar-list").removeClass("hoverd");
            }
        });
    }

    /*----------------------------------------
     passward show hide
     ----------------------------------------*/
    $('.show-hide').show();
    $('.show-hide span').addClass('show');

    $('.show-hide span').on("click", function () {
        if ($(this).hasClass('show')) {
            $('input[name="login[password]"]').attr('type', 'text');
            $(this).removeClass('show');
        } else {
            $('input[name="login[password]"]').attr('type', 'password');
            $(this).addClass('show');
        }
    });
    $('form button[type="submit"]').on('click', function () {
        $('.show-hide span').addClass('show');
        $('.show-hide').parent().find('input[name="login[password]"]').attr('type', 'password');
    });

    /*=====================
      02. Background Image js
      ==========================*/
    $(".bg-center").parent().addClass('b-center');
    $(".bg-img-cover").parent().addClass('bg-size');
    $('.bg-img-cover').each(function () {
        var el = $(this),
            src = el.attr('src'),
            parent = el.parent();
        parent.css({
            'background-image': 'url(' + src + ')',
            'background-size': 'cover',
            'background-position': 'center',
            'display': 'block'
        });
        el.hide();
    });

    $(".mega-menu-container").css("display", "none");
    $(".header-search").on("click", function () {
        $(".search-full").addClass("open");
    });
    $(".close-search").on("click", function () {
        $(".search-full").removeClass("open");
        $("body").removeClass("offcanvas");
    });
    $(".mobile-toggle").on("click", function () {
        $(".nav-menus").toggleClass("open");
    });
    $(".mobile-toggle-left").on("click", function () {
        $(".left-header").toggleClass("open");
    });
    $(".bookmark-search").on("click", function () {
        $(".form-control-search").toggleClass("open");
    })
    $(".filter-toggle").on("click", function () {
        $(".product-sidebar").toggleClass("open");
    });
    $(".toggle-data").on("click", function () {
        $(".product-wrapper").toggleClass("sidebaron");
    });
    $(".form-control-search input").keyup(function (e) {
        if (e.target.value) {
            $(".page-wrapper").addClass("offcanvas-bookmark");
        } else {
            $(".page-wrapper").removeClass("offcanvas-bookmark");
        }
    });
    $(".search-full input").keyup(function (e) {
        if (e.target.value) {
            $("body").addClass("offcanvas");
        } else {
            $("body").removeClass("offcanvas");
        }
    });

    $('body').keydown(function (e) {
        if (e.keyCode == 27) {
            $('.search-full input').val('');
            $('.form-control-search input').val('');
            $('.page-wrapper').removeClass('offcanvas-bookmark');
            $('.search-full').removeClass('open');
            $('.search-form .form-control-search').removeClass('open');
            $("body").removeClass("offcanvas");
        }
    });
    $(".mode").on("click", function () {
        const bodyModeDark = $("body").hasClass("dark-only")

        if (!bodyModeDark) {
            $(".mode").addClass("active")
            localStorage.setItem("mode", "dark-only")
            $("body").addClass("dark-only")
            $("body").removeClass("light")
        }
        if (bodyModeDark) {

            $(".mode").removeClass("active")
            localStorage.setItem("mode", "light")
            $("body").removeClass("dark-only")
            $("body").addClass("light")
        }

    })
    $("body").addClass(localStorage.getItem("mode") ? localStorage.getItem("mode") : "light")
    $(".mode").addClass(localStorage.getItem("mode") === "dark-only" ? "active" : " ")

    // sidebar filter
    $('.md-sidebar .md-sidebar-toggle ').on('click', function (e) {
        $(".md-sidebar .md-sidebar-aside ").toggleClass("open");
    });

})(jQuery);

$('.loader').fadeOut('slow', function () {
    $(this).remove();
});

$(window).on("scroll", function () {
    if ($(this).scrollTop() > 600) {
        $(".tap-top").fadeIn();
    } else {
        $(".tap-top").fadeOut();
    }
});

$(".tap-top").click(function () {
    $("html, body").animate(
        {
            scrollTop: 0,
        },
        600
    );
    return false;
});

(function ($, window, document, undefined) {
    "use strict";
    var $ripple = $(".js-ripple");
    $ripple.on("click.ui.ripple", function (e) {
        var $this = $(this);
        var $offset = $this.parent().offset();
        var $circle = $this.find(".c-ripple__circle");
        var x = e.pageX - $offset.left;
        var y = e.pageY - $offset.top;
        $circle.css({
            top: y + "px",
            left: x + "px"
        });
        $this.addClass("is-active");
    });
    $ripple.on(
        "animationend webkitAnimationEnd oanimationend MSAnimationEnd",
        function (e) {
            $(this).removeClass("is-active");
        });


})(jQuery, window, document);


// active link

$(".chat-menu-icons .toogle-bar").on("click", function () {
    $(".chat-menu").toggleClass("show");
});


// Language
var tnum = 'en';

$(function () {

    if (localStorage.getItem("primary") != null) {
        var primary_val = localStorage.getItem("primary");
        $("#ColorPicker1").val(primary_val);
        var secondary_val = localStorage.getItem("secondary");
        $("#ColorPicker2").val(secondary_val);
    }


    $(document).click(function (e) {
        $('.translate_wrapper, .more_lang').removeClass('active');
    });
    $('.translate_wrapper .current_lang').click(function (e) {
        e.stopPropagation();
        $(this).parent().toggleClass('active');

        setTimeout(function () {
            $('.more_lang').toggleClass('active');
        }, 5);
    });


    /*TRANSLATE*/
    translate(tnum);

    $('.more_lang .lang').on("click", function () {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.more_lang').removeClass('active');

        var i = $(this).find('i').attr('class');
        var lang = $(this).attr('data-value');
        var tnum = lang;
        translate(tnum);

        $('.current_lang .lang-txt').text(lang);
        $('.current_lang i').attr('class', i);


    });
});

function translate(tnum) {
    $('.lan-1').text(trans[0][tnum]);
    $('.lan-2').text(trans[1][tnum]);
    $('.lan-3').text(trans[2][tnum]);
    $('.lan-4').text(trans[3][tnum]);
    $('.lan-5').text(trans[4][tnum]);
    $('.lan-6').text(trans[5][tnum]);
    $('.lan-7').text(trans[6][tnum]);
    $('.lan-8').text(trans[7][tnum]);
    $('.lan-9').text(trans[8][tnum]);
    $('.lan-10').text(trans[9][tnum]);
    $('.lan-11').text(trans[10][tnum]);
    $('.lan-12').text(trans[11][tnum]);
}

var trans = [{
    en: 'Black Quality',
    pt: 'Preto Qualidade',
    es: 'Nigra Kvalito',
    fr: 'Chất lượng màu đen',
    de: 'Sort kvalitet',
    cn: '黑色品质',
    am: 'Սև որակ'
}, {
    en: 'Dashboards,widgets.',
    pt: 'Painéis, widgets.',
    es: 'Paneloj, widgets.',
    fr: "Bảng điều khiển, widget.",
    de: 'Dashboards, widgets.',
    cn: '仪表板，小部件。',
    am: 'Վահանակներ, վիդջեթներ:'
}, {
    en: 'Applications',
    pt: 'Formulários',
    es: 'Aplikoj',
    fr: 'Các ứng dụng',
    de: 'Ansøgninger',
    cn: '应用',
    am: 'Դիմումներ'
}, {
    en: 'Ready To Use Apps',
    pt: 'Aplicativos prontos para usar',
    es: 'Pretaj Uzeblaj Aplikoj',
    fr: 'Sẵn sàng để sử dụng ứng dụng',
    de: 'Klar til brug Apps',
    cn: '即用型应用程序',
    am: 'Պատրաստ է օգտագործել հավելվածները'
}, {
    en: 'Forms & Table',
    pt: 'Formulários e Tabelas',
    es: 'Formoj & Tabelo',
    fr: 'biểu mẫu & bảng',
    de: 'Formularer og tabel',
    cn: '表格和表格',
    am: 'Ձևեր և աղյուսակ'
}, {
    en: 'Ready To Use Froms & Tables',
    pt: 'Pronto para usar Froms & Tables',
    es: 'Preta Uzebla Froms & Tabeloj',
    fr: 'Sẵn Sàng Sử Dụng Từ & Bàn',
    de: 'Klar til brug fra og tabeller',
    cn: '即用型表格和表格',
    am: 'Պատրաստ է օգտագործման Froms & Tables'
}, {
    en: 'Components',
    pt: 'Componentes',
    es: 'Komponentoj',
    fr: 'Các thành phần',
    de: 'Komponenter',
    cn: '成分',
    am: 'Բաղադրիչներ'
}, {
    en: 'Ui Components & Elements',
    pt: 'Componentes e elementos da interface do usuário',
    es: 'Ui Komponantoj & Elementoj',
    fr: 'Thành phần & thành phần giao diện người dùng',
    de: 'Ui-komponenter og -elementer',
    cn: '用户界面组件和元素',
    am: 'Ui բաղադրիչներ և տարրեր'
}, {
    en: 'Pages',
    pt: 'Páginas',
    es: 'Paĝoj',
    fr: ' trang',
    de: 'sider',
    cn: '页数',
    am: 'Էջեր'
}, {
    en: 'All Neccesory Pages Added',
    pt: 'Todas as páginas necessárias adicionadas',
    es: 'Ĉiuj Necesaj Paĝoj Aldonitaj',
    fr: 'Tất cả các trang cần thiết đã được thêm vào',
    de: 'Alle nødvendige sider tilføjet',
    cn: '添加了所有必要的页面',
    am: 'Ավելացվեցին բոլոր անհրաժեշտ էջերը'
}, {
    en: 'Miscellaneous',
    pt: 'Diversas',
    es: 'Diversaj',
    fr: ' Điều khoản khác',
    de: 'Diverse',
    cn: '各种各样的¿',
    am: 'Տարբեր'
},
{
    en: 'Bouns Pages & Apps',
    pt: 'Páginas e aplicativos Bounss',
    es: 'Bouns Paĝoj kaj Aplikoj',
    fr: 'Trang và ứng dụng tiền thưởng',
    de: 'Bouns sider og apps',
    cn: '奖励页面和应用程序',
    am: 'Բոնուսների էջեր և հավելվածներ'
},

];

$(".mobile-title svg").on("click", function () {
    $(".header-mega").toggleClass("d-block");
});

$(".onhover-dropdown").on("click", function () {
    $(this).children('.onhover-show-div').toggleClass("active");
});

$("#flip-btn").on("click", function () {
    $(".flip-card-inner").addClass("flipped")
});

$("#flip-back").on("click", function () {
    $(".flip-card-inner").removeClass("flipped")
})

$(".serchbox").on("click", function (e) {
    $(".search-form").toggleClass("open");
    e.preventDefault();
});

//landing header //
$(".toggle-menu").on('click', function () {
    $('.landing-menu').toggleClass('open');
});
$(".menu-back").on('click', function () {
    $('.landing-menu').toggleClass('open');
});

$('.product-size ul li ').on('click', function (e) {
    $(".product-size ul li ").removeClass("active");
    $(this).addClass("active");
});

$('.email-sidebar .email-aside-toggle ').on('click', function (e) {
    $(".email-sidebar .email-left-aside ").toggleClass("open");
});


$('.job-sidebar .job-toggle ').on('click', function (e) {
    $(".job-sidebar .job-left-aside ").toggleClass("open");
});
