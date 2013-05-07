//タイルサイズ指定
var layout;
var grid_size = 100;
var grid_margin = 5;
var block_params = {
    max_width: 6,
    max_height: 6
};
//なぞ。かわいさんHELP

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

	$("#add").click(function(){
		var tex = $('#my-form [name=my-text]').val();
		var url = $('#URL [name=my-url]').val();
		var pic = $('#pic [name=my-pic]').val();
		gridster.add_widget('<li class="layout_block" data-id='+i+' style="background-color: #D24999;"><a Href="'+url+'"><Img Src="'+pic+'" width=100% height=100%></a><div class="box"><div class="menu"><div class="deleteme"><a  href="JavaScript:void(0);">X</a></div></div></div><div class="texts">'+tex+'</div></li>', 1, 1, 1, 1);
		i++;

    });

    //位置情報を送る部分「追加」ボタンクリックに反応する
    $("#add").click(function(){

    	var jsonString =JSON.stringify(gridster.serialize());
    	//if (confirm("トップページに戻りますか？")==true)
    	//OKならTOPページにジャンプさせる
    	var String ="http://localhost/net3/gridstr.php";
    	String+="?data=";
    	String+=jsonString;

    	location.href = String;


    });

    //位置情報を送る部分「保存」ボタンクリックに反応する
    $("#jump").click(function(){

    	var jsonString =JSON.stringify(gridster.serialize());
    	//if (confirm("保存しますか？")==true)
    	//OKならTOPページにジャンプさせる
    	var String ="http://localhost/gridstar/gridstr.php";
    	String+="?data=";
    	String+=jsonString;

    	location.href = String;
    });
});

    // １秒間隔で繰り返し
setInterval ( 'clocknow()',1000 );

 //時計表示部分
function clocknow(){
    weeks = new Array("Sun","Mon","Thu","Wed","Thr","Fri","Sat") ;
    now = new Date() ;
    y = now.getFullYear() ;
    mo = now.getMonth() + 1 ;
    d = now.getDate() ;
    w = weeks[now.getDay()] ;
    h = now.getHours();
    mi = now.getMinutes();
    s = now.getSeconds();

    // 月、日、時、分、秒が一桁のとき、頭に0を付与
    if ( mo < 10 ) { mo = "0" + mo ; }
    if ( d < 10 ) { d = "0" + d ; }
    if ( h < 10 ) { h = "0" + h ; }
    if ( mi < 10 ) { mi = "0" + mi ; }
    if ( s < 10 ) { s = "0" + s ; }

    // HTML内に日付・日時を挿入
    document.getElementById("content").innerHTML = "<span id="+ "date" +">" + y + "/" + mo + "/" + d + "/(" + w + ")</span><span id=" + "time" + ">" + h + ":" + mi + ":" + s;
}