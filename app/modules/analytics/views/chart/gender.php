<div class="row">
    <div class="col-md-12">
        <div class="head-title">
            <div class="name">Người hâm mộ trang theo Giới tính và độ tuổi</div>
            <div class="desc">Biểu đồ nhân khẩu học tổng hợp về những người thích Trang của bạn dựa trên thông tin về độ tuổi và giới tính họ cung cấp trong hồ sơ người dùng của họ.</div>
        </div>
        <div id="chart-age-1"></div>
    </div>
    <div class="col-md-12 mt40">
        <div class="head-title">
            <div class="name">Số lượng nói về trang theo tuổi và giới tính</div>
            <div class="desc">Biểu đồ số của Mọi người nói về trang theo độ tuổi và giới tính của người dùng.</div>
        </div>
        <div id="chart-age-2"></div>
    </div>
    <div class="col-md-12 mt40">
        <div class="head-title">
            <div class="name">Lượt tương tác trang theo tuổi và giới tínhr</div>
            <div class="desc">Số lượng người đã xem bất kỳ nội dung nào được liên kết với Trang của bạn theo độ tuổi và nhóm giới tính.</div>
        </div>
        <div id="chart-age-3"></div>
    </div>
</div>
<script type="text/javascript">
$(function() {    
    data_fans_gender_age_male  = [<?=!empty($data_fans_gender_age)?$data_fans_gender_age['male']:""?>];
    data_fans_gender_age_female  = [<?=!empty($data_fans_gender_age)?$data_fans_gender_age['female']:""?>];
    data_fans_storytellers_gender_age_male    = [<?=!empty($data_fans_storytellers_gender_age)?$data_fans_storytellers_gender_age['male']:""?>];
    data_fans_storytellers_gender_age_female  = [<?=!empty($data_fans_storytellers_gender_age)?$data_fans_storytellers_gender_age['female']:""?>];
    data_page_impressions_by_age_gender_unique_male    = [<?=!empty($data_page_impressions_by_age_gender_unique)?$data_page_impressions_by_age_gender_unique['male']:""?>];
    data_page_impressions_by_age_gender_unique_female  = [<?=!empty($data_page_impressions_by_age_gender_unique)?$data_page_impressions_by_age_gender_unique['female']:""?>];

    $('#chart-age-1').highcharts({
        credits: {
            enabled: false
        },
        chart: {
            backgroundColor: '#fff',
            type: 'column',
            height:250
        },
        title: {
            text: ''
        },
        xAxis: {
            type: "category"
        },
        yAxis: {
            min: 0,
            title: {
                text: '.'
            },
           
        },
        tooltip: {
            formatter: function () {
                return this.series.name + ': ' + Highcharts.numberFormat(this.y,0) + '<br/>'
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
               
            }
        },
       
        series: [{
            name: 'Male',
            color : '#F89406',
            data: data_fans_gender_age_male
        }, {
            name: 'Female',
            color : '#52B3D9',
            data: data_fans_gender_age_female
        }]
    });

    $('#chart-age-2').highcharts({
        credits: {
            enabled: false
        },
        chart: {
            backgroundColor: '#fff',
            type: 'column',
            height:250
        },
        title: {
            text: ''
        },
        xAxis: {
            type: "category"
        },
        yAxis: {
            min: 0,
            title: {
                text: '.'
            },
           
        },
        tooltip: {
            formatter: function () {
                return this.series.name + ': ' + Highcharts.numberFormat(this.y,0) + '<br/>'
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
               
            }
        },
       
        series: [{
            name: 'Male',
            color : '#F89406',
            data: data_fans_storytellers_gender_age_male
        }, {
            name: 'Female',
            color : '#52B3D9',
            data: data_fans_storytellers_gender_age_female
        }]
    });

    $('#chart-age-3').highcharts({
        credits: {
            enabled: false
        },
        chart: {
            backgroundColor: '#fff',
            type: 'column',
            height:250
        },
        title: {
            text: ''
        },
        xAxis: {
            type: "category"
        },
        yAxis: {
            min: 0,
            title: {
                text: '.'
            },
           
        },
        tooltip: {
            formatter: function () {
                return this.series.name + ': ' + Highcharts.numberFormat(this.y,0) + '<br/>'
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
               
            }
        },
       
        series: [{
            name: 'Male',
            color : '#F89406',
            data: data_page_impressions_by_age_gender_unique_male
        }, {
            name: 'Female',
            color : '#52B3D9',
            data: data_page_impressions_by_age_gender_unique_female
        }]
    });
});
</script>