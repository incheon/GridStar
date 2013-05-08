var layout;
var grid_size = 100;
var grid_margin = 5;
var block_params = {
    max_width: 6,
    max_height: 6
};
$(function() {

    layout = $('.layouts_grid ul').gridster({
        widget_margins: [grid_margin, grid_margin],
        widget_base_dimensions: [grid_size, grid_size],
        serialize_params: function($w, wgd) {
            return {
                x: wgd.col,
                y: wgd.row,
                width: wgd.size_x,
                height: wgd.size_y,
                id: $($w).attr('data-id'),
                name: $($w).find('.block_name').html(),
            };
        },
        min_rows: block_params.max_height
    }).data('gridster');

    $('.layout_block').resizable({
        grid: [grid_size + (grid_margin * 2), grid_size + (grid_margin * 2)],
        animate: false,
        minWidth: grid_size,
        minHeight: grid_size,
        containment: '#layouts_grid ul',
        autoHide: true,
        stop: function(event, ui) {
            var resized = $(this);
            setTimeout(function() {
                resizeBlock(resized);
            }, 300);
        }
    });

    $('.ui-resizable-handle').hover(function() {
        layout.disable();
    }, function() {
        layout.enable();
    });

    function resizeBlock(elmObj) {
        var elmObj = $(elmObj);
        var w = elmObj.width() - grid_size;
        var h = elmObj.height() - grid_size;
        for (var grid_w = 1; w > 0; w -= (grid_size + (grid_margin * 2))) {
            grid_w++;
        }
        for (var grid_h = 1; h > 0; h -= (grid_size + (grid_margin * 2))) {
            grid_h++;
        }
        layout.resize_widget(elmObj, grid_w, grid_h);
    }

    var gridster = $(".layouts_grid ul").gridster().data('gridster');

    //remove box
    $(".deleteme").click(function() {
        $(this).parents().eq(2).addClass("activ");
        gridster.remove_widget($('.activ'));
        $(this).parents().eq(2).removeClass("activ");

    });

    $("#delete").click(function(){
        gridster.remove_widget( $('.layouts_grid li').eq(0) );
    });

//インクリメント
    i=10;

    $("#add").click(function(){
        var tex = $('#my-form [name=my-text]').val();
        var url = $('#URL [name=my-url]').val();
        var pic = $('#pic [name=my-pic]').val();
        gridster.add_widget('<li class="layout_block" data-id='+i+' style="background-color: #D24999;"><A Href="'+url+'"><Img Src="'+pic+'" width=100% height=100%></a><div class="box"><div class="menu"><div class="deleteme"><a  href="JavaScript:void(0);">X</a></div></div></div><div class="texts">'+tex+'</div></li>', 1, 1, 1, 1);
        i++;
    });

});