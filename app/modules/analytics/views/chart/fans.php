<div class="row">
	<div class="col-md-12">
        <div class="head-title">
            <div class="name">Người hâm mộ theo giờ</div>
            <div class="desc">Số lượng người hâm mộ của bạn đã xem bất kỳ bài đăng nào trên Facebook vào một ngày cụ thể, được chia nhỏ theo giờ trong ngày theo giờ PST.</div>
        </div>
		<div class="ajax_fanshour"></div>
        <div class="foot-title">
            <span class="total_most_hour"></span><span>:00</span> Thời gian online nhiều nhất
        </div>
	</div>
	<div class="col-md-12">
        <div class="head-title">
            <div class="name">Người hâm mộ theo ngày</div>
            <div class="desc">Số lượng người hâm mộ của bạn đã xem bất kỳ bài đăng nào trên Facebook vào một ngày cụ thể.</div>
        </div>
        <div class="ajax_fansday"></div>
        <div class="foot-title">
            <span class="total_fans_day"></span> Người hâm mộ online
        </div>
	</div>
</div>

<script type="text/javascript">
$(function(){
    var data_fanshour = [<?=!empty($data_fanshour)?$data_fanshour:""?>];
    var data_fansday  = [<?=!empty($data_fansday)?$data_fansday:""?>];
    Analytics.Highcharts({
        element : '.ajax_fanshour',
        titlex  : 'nummber',
        titley  : '',
        colorx  : '#00a65a',
        colory  : '#00a65a',
        type    : 'column',
        formatterx: 'text',
        name    : 'Hour',
        tick    : 1,
        data    : data_fanshour
    });

    Analytics.Highcharts({
        element : '.ajax_fansday',
        titlex  : 'datetime',
        titley  : '',
        colorx  : '#00a65a',
        colory  : '#00a65a',
        type    : 'line',
        name    : 'Hour',
        data    : data_fansday
    });

    Analytics.MostValue("total_most_hour", data_fanshour);
    Analytics.CountValue("total_fans_day", data_fanshour);
});
</script>