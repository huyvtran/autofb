<div class="row">
    <div class="col-md-12">
        <div class="ajax_likes"></div>
    </div>
    <div class="col-md-12">
        <ul class="nav nav-stacked">
            <li><a href="javascript:void(0);">Số lượt thích mới trung bình mỗi ngày <span class="pull-right badge bg-blue avg_likes"></span></a></li>
            <li><a href="javascript:void(0);">Số lần bỏ thích trung bình mỗi ngày <span class="pull-right badge bg-aqua avg_unlikes"></span></a></li>
            <li><a href="javascript:void(0);">Tổng số lượt thích mới <span class="pull-right badge bg-green total_new_likes"></span></a></li>
            <li><a href="javascript:void(0);">Tổng số lượt bỏ thích <span class="pull-right badge bg-red total_unlikes"></span></a></li>
        </ul>
    </div>
</div>

<script type="text/javascript">
$(function(){
    var data_fans         = [<?=!empty($data_fans)?$data_fans:""?>];
    var data_fan_adds     = [<?=!empty($data_fan_adds)?$data_fan_adds:""?>];
    var data_fan_removes  = [<?=!empty($data_fan_removes)?$data_fan_removes:""?>];

    $('.ajax_likes').highcharts({
        credits: {
            enabled: false
        },
        chart: {
            backgroundColor: '#fff',
            height:350
        },
        title: {
            text:'.',
            style:{
                color: "#F8F6F6"
            },   
            align  :'left'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                day: '%b %e'
            }
        },
        yAxis: [{
            title: {
                text: 'Page Fans',
            }
        }, {
            title: {
                text: 'Page Fan Adds & Removes'
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        series: [{
            name: 'Page Fan Adds',
            type: 'column',
            yAxis: 1,
            data: data_fan_adds,
            tooltip: {
                valueSuffix: ' '
            }

        },{
            name: 'Page Fan Removes',
            type: 'column',
            yAxis: 1,
            data: data_fan_removes,
        },{
            name: 'Page Fans',
            type: 'spline',
            data: data_fans,
        }]
    });

    Analytics.AvgValue("avg_likes",data_fan_adds);
    Analytics.AvgValue("avg_unlikes",data_fan_removes);
    Analytics.CountValue("total_new_likes",data_fan_adds);
    Analytics.CountValue("total_unlikes",data_fan_removes);
});
</script>