<div class="row">
	<div class="col-md-12">
        <div class="head-title">
            <div class="name">Tiếp cận và hiển thị</div>
            <div class="desc">Số lượng người đã xem tất cả các bài đăng của bạn</div>
        </div>
		<div class="ajax_rearchchart"></div>
        <div class="foot-title">
            <span class="total_reach"></span> Tương tác | <span class="total_impressions"></span> Số lần hiển thị
        </div>
	</div>
    <div class="col-md-12">
        <div class="head-title">
            <div class="name">Phân tích phạm vi tiếp cận theo loại</div>
            <div class="desc">Số người đã xem câu chuyện được tài trợ hoặc Quảng cáo về Trang của bạn và những người đã truy cập vào Trang của bạn hoặc xem Trang của bạn hoặc một trong các bài đăng của nó trong Nguồn cấp tin tức hoặc Ticker. Những lần hiển thị này có thể là Người hâm mộ hoặc không phải người hâm mộ.</div>
        </div>
        <div class="ajax_rearchpaidchart"></div>
        <div class="foot-title">
            <span class="total_reach_paid"></span> Tương tác trả phí | <span class="total_reach_organic"></span> Tương tác tự nhiên
        </div>
    </div>
    <div class="col-md-12">
        <div class="head-title">
            <div class="name">Số lần hiển thị trang theo loại</div>
            <div class="desc">Số lần hiển thị của Câu chuyện được Tài trợ hoặc Quảng cáo trỏ đến Trang của bạn và Số lần các bài đăng của bạn được nhìn thấy trong Nguồn cấp tin tức hoặc Ticker hoặc trên các lượt truy cập vào Trang của bạn.</div>
        </div>
        <div class="ajax_impressionspaidchart"></div>
        <div class="foot-title">
            <span class="total_impressions_paid"></span> Lượt hiển thị trả phí | <span class="total_impressions_organic"></span> Hiển thị tự nhiên
        </div>
    </div>
</div>

<script type="text/javascript">
	$(function(){
        var data_reach               = [<?=!empty($data_reach)?$data_reach:""?>];
        var data_impressions         = [<?=!empty($data_impressions)?$data_impressions:""?>];
        var data_reach_paid          = [<?=!empty($data_reach_paid)?$data_reach_paid:""?>];
        var data_reach_organic       = [<?=!empty($data_reach_organic)?$data_reach_organic:""?>];
        var data_impressions_paid    = [<?=!empty($data_impressions_paid)?$data_impressions_paid:""?>];
        var data_impressions_organic = [<?=!empty($data_impressions_organic)?$data_impressions_organic:""?>];

    	Analytics.Highcharts({
            element : '.ajax_rearchchart',
            titlex  : 'datetime',
            crosshairs : true,
            multi   : true,
            data    : [{
                type   : 'spline',
                color  : '#00a65a',
                name   : "Reach",
                data   : data_reach
            },{
                type   : 'spline',
                color  : '#dd4b39',
                name   : "Impressions",
                data   : data_impressions
            }]
        });

        Analytics.Highcharts({
            element : '.ajax_rearchpaidchart',
            titlex  : 'datetime',
            crosshairs : true,
            multi   : true,
            data    : [{
                type   : 'spline',
                color  : '#0066ff',
                name   : "Paid Reach",
                data   : data_reach_paid
            },{
                type   : 'spline',
                color  : '#ff8a00',
                name   : "Organic Reach",
                data   : data_reach_organic
            }]
        });

        Analytics.Highcharts({
            element : '.ajax_impressionspaidchart',
            titlex  : 'datetime',
            crosshairs : true,
            multi   : true,
            data    : [{
                type   : 'spline',
                color  : '#333333',
                name   : "Paid Impressions",
                data   : data_impressions_paid
            },{
                type   : 'spline',
                color  : '#ff006c',
                name   : "Organic Impressions",
                data   : data_impressions_organic
            }]
        });

        Analytics.CountValue("total_reach",data_reach);
        Analytics.CountValue("total_impressions",data_impressions);
        Analytics.CountValue("total_reach_paid",data_reach_paid);
        Analytics.CountValue("total_reach_organic",data_reach_organic);
        Analytics.CountValue("total_impressions_paid",data_impressions_paid);
        Analytics.CountValue("total_impressions_organic",data_impressions_organic);
	});
</script>