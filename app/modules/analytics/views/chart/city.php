<div class="row">
    <div class="head-title">
        <div class="name">Thành viên của người hâm mộ trang</div>
        <div class="desc">Dữ liệu vị trí được tổng hợp trên Facebook, được sắp xếp theo quốc gia, về những người thích Trang của bạn.</div>
    </div>
    <div class="col-md-8">
        <div class="ajax_fans_city"></div>
    </div>
    <div class="col-md-4">
        <div class="table-responsive box-listcity">
            <table class="table table-striped table-hover listcity">
                <tbody>
                    <tr>
                        <th style="width: 10px">No.</th>
                        <th>city</th>
                        <th style="width: 40px">Total</th>
                     </tr>
                    <?php if(!empty($data_page_fans_city['result'])){
                        $count = 0;
                        $result = $data_page_fans_city['result'];
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
        <div class="name">Người kể về trang theo thành phố</div>
        <div class="desc">Số người nói về trang theo thành phố.</div>
    </div>
    <div class="col-md-8">
        <div class="ajax_page_storytellers_by_city"></div>
    </div>
    <div class="col-md-4">
        <div class="table-responsive box-listcity">
            <table class="table table-striped table-hover listcity">
                <tbody>
                    <tr>
                        <th style="width: 10px">No.</th>
                        <th>city</th>
                        <th style="width: 40px">Total</th>
                     </tr>
                    <?php if(!empty($data_page_storytellers_by_city['result'])){
                        $count = 0;
                        $result = $data_page_storytellers_by_city['result'];
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
        <div class="name">Lượt tương tác theo thành phố</div>
        <div class="desc">Số lượng người đã xem bất kỳ nội dung nào được liên kết với Trang của bạn theo thành phố.</div>
    </div>
    <div class="col-md-8">
        <div class="ajax_page_impressions_by_city_unique"></div>
    </div>
    <div class="col-md-4">
        <div class="table-responsive box-listcity">
            <table class="table table-striped table-hover listcity">
                <tbody>
                    <tr>
                        <th style="width: 10px">No.</th>
                        <th>city</th>
                        <th style="width: 40px">Total</th>
                     </tr>
                    <?php if(!empty($data_page_impressions_by_city_unique['result'])){
                        $count = 0;
                        $result = $data_page_impressions_by_city_unique['result'];
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
    data_page_fans_city  = [<?=!empty($data_page_fans_city)?$data_page_fans_city['top']:""?>];
    data_page_storytellers_by_city  = [<?=!empty($data_page_storytellers_by_city)?$data_page_storytellers_by_city['top']:""?>];
    data_page_impressions_by_city_unique  = [<?=!empty($data_page_impressions_by_city_unique)?$data_page_impressions_by_city_unique['top']:""?>];

    Analytics.Highcharts({
        element : '.ajax_fans_city',
        height  : 320,
        titlex  : 'datetime',
        colorx  : '#d73925',
        colory  : '#333',
        type    : 'bar',
        formatterx : 'text',
        name    : 'city',
        data    : data_page_fans_city,
        dataLabels : {
            formatter: function() {
                return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ Analytics.round(this.percentage,2) +'%'  : null;
            }
        }
    });

    Analytics.Highcharts({
        element : '.ajax_page_storytellers_by_city',
        height  : 320,
        titlex  : 'datetime',
        colorx  : '#d73925',
        colory  : '#333',
        type    : 'bar',
        formatterx : 'text',
        name    : 'city',
        data    : data_page_storytellers_by_city,
        dataLabels : {
            formatter: function() {
                return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ Analytics.round(this.percentage,2) +'%'  : null;
            }
        }
    });

    Analytics.Highcharts({
        element    : '.ajax_page_impressions_by_city_unique',
        height     : 320,
        titlex     : '',
        colorx     : '#d73925',
        colory     : '#333',
        type       : 'bar',
        formatterx : 'text',
        name       : 'City',
        data       : data_page_impressions_by_city_unique,
        dataLabels : {
            formatter: function() {
                return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ Analytics.round(this.percentage,2) +'%'  : null;
            }
        }
    });

    $('.box-listcity').slimScroll({
        height: '300px'
    });
});
</script>