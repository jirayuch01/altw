$(window).load(function () {

    //.css('border-radius', '15px')
    //.css('border-radius', '')
    
    //mouse over the option
    $('select[id=opts]').on('mouseenter', 'option', function (e) {
        //console.log("+ option Synonym : purple");
        $(this).css('background-color', '#99ddff').css('font-weight','bold');
    });
    $('select[id=opts]').on('mouseleave', 'option', function (e) {
        //console.log("   - option Synonym : white");
        $(this).css('background-color', 'white').css('font-weight','');
    });

    //mouse over the option of toActive opts2active
    $('select[id=opts2active]').on('mouseenter', 'option', function (e) {
        //console.log("+ option toActive : yellow");
        $(this).css('background-color', '#ffffcc').css('font-weight','bold');
    });
    $('select[id=opts2active]').on('mouseleave', 'option', function (e) {
        //console.log("   - option toActive : white");
        $(this).css('background-color', 'white').css('font-weight','');
    });

    //mouse over the option of toPassive opts2passive
    $('select[id=opts2passive]').on('mouseenter', 'option', function (e) {
        //console.log("+ option toPassive : blue");
        $(this).css('background-color', '#d6f5d6').css('font-weight','bold');
    });
    $('select[id=opts2passive]').on('mouseleave', 'option', function (e) {
        //console.log("   - option toPassive : white");
        $(this).css('background-color', 'white').css('font-weight','');
    }); 

    //high light on each sentence
    $('.mark').hover(
        function () {                                         
            var id = $(this).attr('id');    
            var name = $(this).attr('name');                       
            if(name=='2pas')
            {
                //console.log("+ mark 2pas : blue");
                $("[id=" + id + "").css('background-color', '#66ff66');
            }
            else if(name=='2act')
            { 
                //console.log("+ mark 2act : yellow");
                $("[id=" + id + "").css('background-color', 'yellow');                
            }
        },
        function () {                                            
            var id = $(this).attr('id');        
            var name = $(this).attr('name');    
            if(name=='2pas')
            {
                //console.log("   - mark 2pas : blue");
                $("[id=" + id + "").css('background-color', '#d6f5d6');
            }
            else if(name=='2act') 
            {
                //console.log("   - mark 2act : yellow");
                $("[id=" + id + "").css('background-color', '#ffffcc');
            }
    });


    //high light on each word
    var w = "";
    $('.dropdown').hover(
        function () {            
            var el = this.querySelector("mark");
            var id = $(el).attr('id');                       
            var cla = $(el).attr('class');                   
            if(cla == 'mark2passive')
            {
                //console.log("+ mark 2passive : blue");
                $("[id=" + id + "").css('background-color', '#66ff66');
            }
            else if(cla == 'mark2active')
            {
                //console.log("+ mark 2active : yellow");
                $("[id=" + id + "").css('background-color', 'yellow');
            }
            else
            {
                //console.log("+ mark synonym : purple");
                $("[id=" + id + "").css('background-color', '#1a8cff');                     
            }
                         
        },
        function () {            
            
            var el = this.querySelector("mark");
            var id = $(el).attr('id');
            var cla = $(el).attr('class');                                         
            if(cla == 'mark2passive')
            {
                //console.log("   - mark 2passive : blue");
                $("[id=" + id + "").css('background-color', '#d6f5d6');              
            }
            else if(cla == 'mark2active')
            {
                //console.log("   - mark 2act : yellow");
                $("[id=" + id + "").css('background-color', '#ffffcc');                
            }
            else 
            {
                //console.log("   - mark synonym : purple");
                $("[id=" + id + "").css('background-color', '#99ddff');
            }
    });

    var $cont = $('.portfolio-group');
    $cont.isotope({
        itemSelector: '.portfolio-group .portfolio-item',
        masonry: { columnWidth: $('.isotope-item:first').width(), gutterWidth: 20, isFitWidth: true },
        filter: '*',
    });
    $('.portfolio-filter-container a').click(function () {
        $cont.isotope({
            filter: this.getAttribute('data-filter')
        });
        return false;
    });
    var lastClickFilter = null;
    $('.portfolio-filter a').click(function () {
        if (lastClickFilter === null) {
            $('.portfolio-filter a').removeClass('portfolio-selected');
        } else {
            $(lastClickFilter).removeClass('portfolio-selected');
        }
        lastClickFilter = this;
        $(this).addClass('portfolio-selected');
    });
});
$(function () {
    $('#hornavmenu').slicknav();
});
