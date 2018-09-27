<div class="row">
    <div class="col-md-12">
        <div class="head-title">
            <div class="name">Người hâm mộ trang theo nguồn</div>
            <div class="desc">Đây là phân tích về số lượt thích Trang từ những nơi phổ biến nhất mà mọi người có thể thích Trang của bạn.</div>
        </div>
        <div class="col-md-8">
            <div class="ajax_page_fans_by_like_source"></div>
        </div>

        <div class="col-md-4">
            <div class="table-responsive box-listSource">
                <table class="table table-striped table-hover listSource">
                    <tbody>
                        <tr>
                            <th style="width: 10px">No.</th>
                            <th>Source</th>
                            <th style="width: 40px">Total</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row mt40">
    <div class="col-md-12">
        <div class="head-title">
            <div class="name">Số lần xem trang bên ngoài</div>
            <div class="desc">Top giới thiệu các miền bên ngoài gửi lưu lượng truy cập đến trang của bạn.</div>
        </div>
        <div class="ajax_page_views_external_referrals"></div>
        <div class="row">
        <?php if(!empty($data_page_views_external_referrals)){
            foreach ($data_page_views_external_referrals as $key => $row) {
        ?>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_referrers_<?=str_replace('.','',$key)?>"></h5>
                    <span class="description-text"><?=$key?></span>
                </div>
            </div>
        <?php }}?>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {    
    data_page_fans_by_like_source  = [<?=!empty($data_page_fans_by_like_source)?$data_page_fans_by_like_source:""?>];

    Analytics.Highcharts({
        element : '.ajax_page_fans_by_like_source',
        height  : 300,
        titlex  : 'datetime',
        colorx  : '#d73925',
        colory  : '#333',
        type    : 'pie',
        name    : 'Country',
        data    : data_page_fans_by_like_source,
        dataLabels : {
            formatter: function() {
                return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ Analytics.round(this.percentage,2) +'%'  : null;
            }
        }
    });

    <?php if(!empty($data_page_views_external_referrals)){?>
    Analytics.Highcharts({
        element : '.ajax_page_views_external_referrals',
        titlex  : 'datetime',
        crosshairs : true,
        multi   : true,
        data    : [
        <?php foreach ($data_page_views_external_referrals as $key => $row) {?>
            {
                type   : 'spline',
                name   : "<?=$key?>",
                data   : [<?=$row?>]
            },
        <?php }?>
        ]
    });
    <?php foreach ($data_page_views_external_referrals as $key => $row) {?>
        Analytics.CountValue("total_referrers_<?=str_replace('.','',$key)?>", [<?=$row?>]);
    <?php }?>

    <?php }?>

    $.each(data_page_fans_by_like_source, function(index,value){
        _html = '<tr><td>'+(index+1)+'.</td><td>'+value[0]+'</td><td><span class="badge bg-'+Analytics.colorTop(2)+'">'+Analytics.formatNumber(value[1])+'</span></td></tr>';
        $(".listSource tbody").append(_html);
    });

    $('.box-listSource').slimScroll({
        height: '300px'
    });
});
</script>