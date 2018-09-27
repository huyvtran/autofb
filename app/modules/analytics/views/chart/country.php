<div class="row">
    <div class="head-title">
        <div class="name">Người hâm mộ theo quốc gia</div>
        <div class="desc">Dữ liệu vị trí Facebook tổng hợp, được sắp xếp theo quốc gia, về những người thích Trang của bạn.</div>
    </div>
    <div class="col-md-8">
        <div class="ajax_fans_country"></div>
    </div>
    <div class="col-md-4">
        <div class="table-responsive box-listcountry">
            <table class="table table-striped table-hover listcountry">
                <tbody>
                    <tr>
                        <th style="width: 10px">No.</th>
                        <th>Country</th>
                        <th style="width: 40px">Total</th>
                     </tr>
                    <?php if(!empty($data_page_fans_country['result'])){
                        $count = 0;
                        $result = $data_page_fans_country['result'];
                        foreach ($result as $key => $row) {
                            switch ($count) {
                                case 0:
                                    $color = "text-red";
                                    break;
                                case 1:
                                    $color = "text-green";
                                    break;
                                case 2:
                                    $color = "text-blue";
                                    break;
                                default:
                                    $color = "";
                                    break;
                            }
                    ?>
                    <tr>
                        <td style="width: 10px"><?=$count+1?></td>
                        <td><?=$key?></td>
                        <td style="width: 40px" class="<?=$color?>"><?=format_number($row)?></td>
                    </tr>
                    <?php $count++; }}?>
                    
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row mt40">
    <div class="head-title">
        <div class="name">Số người dùng theo quốc gia</div>
        <div class="desc">Số người nói về trang theo quốc gia của người dùng.</div>
    </div>
    <div class="col-md-8">
        <div class="ajax_page_storytellers_by_country"></div>
    </div>
    <div class="col-md-4">
        <div class="table-responsive box-listcountry">
            <table class="table table-striped table-hover listcountry">
                <tbody>
                    <tr>
                        <th style="width: 10px">No.</th>
                        <th>Country</th>
                        <th style="width: 40px">Total</th>
                     </tr>
                    <?php if(!empty($data_page_storytellers_by_country['result'])){
                        $count = 0;
                        $result = $data_page_storytellers_by_country['result'];
                        foreach ($result as $key => $row) {
                            switch ($count) {
                                case 0:
                                    $color = "text-red";
                                    break;
                                case 1:
                                    $color = "text-green";
                                    break;
                                case 2:
                                    $color = "text-blue";
                                    break;
                                default:
                                    $color = "";
                                    break;
                            }
                    ?>
                    <tr>
                        <td style="width: 10px"><?=$count+1?></td>
                        <td><?=$key?></td>
                        <td style="width: 40px" class="<?=$color?>"><?=format_number($row)?></td>
                    </tr>
                    <?php $count++; }}?>
                    
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row mt40">
    <div class="head-title">
        <div class="name">Lươt tương tác theo quốc gia</div>
        <div class="desc">Số lượng người đã xem bất kỳ nội dung nào được liên kết với Trang của bạn theo quốc gia.</div>
    </div>
    <div class="col-md-8">
        <div class="ajax_page_impressions_by_country_unique"></div>
    </div>
    <div class="col-md-4">
        <div class="table-responsive box-listcountry">
            <table class="table table-striped table-hover listcountry">
                <tbody>
                    <tr>
                        <th style="width: 10px">No.</th>
                        <th>Country</th>
                        <th style="width: 40px">Total</th>
                     </tr>
                    <?php if(!empty($data_page_impressions_by_country_unique['result'])){
                        $count = 0;
                        $result = $data_page_impressions_by_country_unique['result'];
                        foreach ($result as $key => $row) {
                            switch ($count) {
                                case 0:
                                    $color = "text-red";
                                    break;
                                case 1:
                                    $color = "text-green";
                                    break;
                                case 2:
                                    $color = "text-blue";
                                    break;
                                default:
                                    $color = "";
                                    break;
                            }
                    ?>
                    <tr>
                        <td style="width: 10px"><?=$count+1?></td>
                        <td><?=$key?></td>
                        <td style="width: 40px" class="<?=$color?>"><?=format_number($row)?></td>
                    </tr>
                    <?php $count++; }}?>
                    
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {    
    data_page_fans_country  = [<?=!empty($data_page_fans_country)?$data_page_fans_country['top']:""?>];
    data_page_storytellers_by_country  = [<?=!empty($data_page_storytellers_by_country)?$data_page_storytellers_by_country['top']:""?>];
    data_page_impressions_by_country_unique  = [<?=!empty($data_page_impressions_by_country_unique)?$data_page_impressions_by_country_unique['top']:""?>];

    Analytics.Highcharts({
        element : '.ajax_fans_country',
        height  : 300,
        titlex  : 'datetime',
        colorx  : '#d73925',
        colory  : '#333',
        type    : 'pie',
        name    : 'Country',
        data    : data_page_fans_country,
        dataLabels : {
            formatter: function() {
                return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ Analytics.round(this.percentage,2) +'%'  : null;
            }
        }
    });

    Analytics.Highcharts({
        element : '.ajax_page_storytellers_by_country',
        height  : 300,
        titlex  : 'datetime',
        colorx  : '#d73925',
        colory  : '#333',
        type    : 'pie',
        name    : 'Country',
        data    : data_page_storytellers_by_country,
        dataLabels : {
            formatter: function() {
                return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ Analytics.round(this.percentage,2) +'%'  : null;
            }
        }
    });

    Analytics.Highcharts({
        element : '.ajax_page_impressions_by_country_unique',
        height  : 300,
        titlex  : 'datetime',
        colorx  : '#d73925',
        colory  : '#333',
        type    : 'pie',
        name    : 'Country',
        data    : data_page_impressions_by_country_unique,
        dataLabels : {
            formatter: function() {
                return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ Analytics.round(this.percentage,2) +'%'  : null;
            }
        }
    });

    $('.box-listcountry').slimScroll({
        height: '300px'
    });
});
</script>