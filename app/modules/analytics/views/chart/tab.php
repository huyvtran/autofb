<div class="row">
    <div class="col-md-12">
        <div class="head-title">
            <div class="name">Tần suất phân bố trang</div>
            <div class="desc">Phân bố tần suất trang Số lượng người mà Trang của bạn đã được chia nhỏ theo số lần mọi người xem bất kỳ nội dung nào về Trang của bạn.</div>
        </div>
        <div class="ajax_page_impressions_frequency_distribution"></div>
    </div>

    <div class="col-md-12 mt40">
        <div class="head-title">
            <div class="name">Người kể chuyện trên trang theo loại câu chuyện</div>
            <div class="desc">Số lượng người nói về câu chuyện trên Trang của bạn, theo loại câu chuyện Trang</div>
        </div>
        <div class="ajax_page_storytellers_by_story_type"></div>
        <div class="row">
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_story_fan"></h5>
                    <span class="description-text">Người hâm mộ</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_story_page_post"></h5>
                    <span class="description-text">Bài đăng trên trang</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_story_user_post"></h5>
                    <span class="description-text">Bài đăng người dùng</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_story_coupon"></h5>
                        <span class="description-text">Mã giảm giá</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_story_mention"></h5>
                    <span class="description-text">Đề cập</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_story_checkin"></h5>
                    <span class="description-text">Checkin</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_story_question"></h5>
                    <span class="description-text">Câu hỏi</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_story_event"></h5>
                    <span class="description-text">Sự kiện</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_story_other"></h5>
                    <span class="description-text">Khác</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt40">
        <div class="head-title">
            <div class="name">Tab hiển thị</div>
            <div class="desc">Số lượng người dùng đã đăng nhập vào Facebook đã nhìn thấy các tab trên Trang của bạn.</div>
        </div>
        <div class="ajax_tab"></div>
        <div class="row">
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_timeline"></h5>
                    <span class="description-text">Dòng thời gian</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_photos"></h5>
                    <span class="description-text">Hình Ảnh</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_photos_albums"></h5>
                    <span class="description-text">Albums ảnh</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_profile"></h5>
                        <span class="description-text">Profile</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_profile_photos"></h5>
                    <span class="description-text">Profile Photos</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_likes"></h5>
                    <span class="description-text">Likes</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_videos"></h5>
                    <span class="description-text">Videos</span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-red total_photos_stream"></h5>
                    <span class="description-text">Photostream</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var data_timeline         = [<?=!empty($data_tab)?$data_tab['timeline']:""?>];
        var data_photos           = [<?=!empty($data_tab)?$data_tab['photos']:""?>];
        var data_photos_albums    = [<?=!empty($data_tab)?$data_tab['photos_albums']:""?>];
        var data_profile          = [<?=!empty($data_tab)?$data_tab['profile']:""?>];
        var data_profile_photos   = [<?=!empty($data_tab)?$data_tab['profile_photos']:""?>];
        var data_likes            = [<?=!empty($data_tab)?$data_tab['likes']:""?>];
        var data_videos           = [<?=!empty($data_tab)?$data_tab['videos']:""?>];
        var data_photos_stream    = [<?=!empty($data_tab)?$data_tab['photos_stream']:""?>];

        var data_fan       = [<?=!empty($data_page_storytellers_by_story_type)?$data_page_storytellers_by_story_type['fan']:""?>];
        var data_page_post = [<?=!empty($data_page_storytellers_by_story_type)?$data_page_storytellers_by_story_type['page_post']:""?>];
        var data_user_post = [<?=!empty($data_page_storytellers_by_story_type)?$data_page_storytellers_by_story_type['user_post']:""?>];
        var data_coupon    = [<?=!empty($data_page_storytellers_by_story_type)?$data_page_storytellers_by_story_type['coupon']:""?>];
        var data_mention   = [<?=!empty($data_page_storytellers_by_story_type)?$data_page_storytellers_by_story_type['mention']:""?>];
        var data_checkin   = [<?=!empty($data_page_storytellers_by_story_type)?$data_page_storytellers_by_story_type['checkin']:""?>];
        var data_question  = [<?=!empty($data_page_storytellers_by_story_type)?$data_page_storytellers_by_story_type['question']:""?>];
        var data_event     = [<?=!empty($data_page_storytellers_by_story_type)?$data_page_storytellers_by_story_type['event']:""?>];
        var data_other     = [<?=!empty($data_page_storytellers_by_story_type)?$data_page_storytellers_by_story_type['other']:""?>];

        var data_page_impressions_frequency_distribution = [<?=!empty($data_page_impressions_frequency_distribution)?$data_page_impressions_frequency_distribution:""?>];
        
        Analytics.Highcharts({
            element : '.ajax_page_impressions_frequency_distribution',
            titlex  : 'nummber',
            titley  : '',
            colorx  : '#fff600',
            colory  : '#fff600',
            type    : 'column',
            formatterx: 'text',
            name    : 'Frequency Distribution',
            tick    : 1,
            data    : data_page_impressions_frequency_distribution
        });

        Analytics.Highcharts({
            element : '.ajax_page_storytellers_by_story_type',
            titlex  : 'datetime',
            crosshairs : true,
            multi   : true,
            data    : [{
                type   : 'spline',
                color  : '#00c5d7',
                name   : "Fan",
                data   : data_fan
            },{
                type   : 'spline',
                color  : '#D91E18',
                name   : "Page Post",
                data   : data_page_post
            },{
                type   : 'spline',
                color  : '#9A12B3',
                name   : "User Post",
                data   : data_user_post
            },{
                type   : 'spline',
                color  : '#2ECC71',
                name   : "Coupon",
                data   : data_coupon
            },{
                type   : 'spline',
                color  : '#F89406',
                name   : "Mention",
                data   : data_mention
            },{
                type   : 'spline',
                color  : '#4f4f4f',
                name   : "Checkin",
                data   : data_checkin
            },{
                type   : 'spline',
                color  : '#1e73f3',
                name   : "Question",
                data   : data_question
            },{
                type   : 'spline',
                color  : '#ff3c00',
                name   : "Event",
                data   : data_event
            },{
                type   : 'spline',
                color  : '#202020',
                name   : "Other",
                data   : data_other
            }]
        });

        Analytics.Highcharts({
            element : '.ajax_tab',
            titlex  : 'datetime',
            crosshairs : true,
            multi   : true,
            data    : [{
                type   : 'spline',
                color  : '#F62459',
                name   : "Timeline",
                data   : data_timeline
            },{
                type   : 'spline',
                color  : '#D91E18',
                name   : "Photos",
                data   : data_photos
            },{
                type   : 'spline',
                color  : '#9A12B3',
                name   : "Photos albums",
                data   : data_photos_albums
            },{
                type   : 'spline',
                color  : '#2ECC71',
                name   : "Profile",
                data   : data_profile
            },{
                type   : 'spline',
                color  : '#F89406',
                name   : "Profile Photos",
                data   : data_profile_photos
            },{
                type   : 'spline',
                color  : '#4f4f4f',
                name   : "Likes",
                data   : data_likes
            },{
                type   : 'spline',
                color  : '#1e73f3',
                name   : "Videos",
                data   : data_videos
            },{
                type   : 'spline',
                color  : '#ff3c00',
                name   : "Photos Stream",
                data   : data_photos_stream
            }]
        });

        Analytics.CountValue("total_story_fan", data_fan);
        Analytics.CountValue("total_story_page_post", data_page_post);
        Analytics.CountValue("total_story_user_post", data_user_post);
        Analytics.CountValue("total_story_coupon", data_coupon);
        Analytics.CountValue("total_story_mention", data_mention);
        Analytics.CountValue("total_story_checkin", data_checkin);
        Analytics.CountValue("total_story_question", data_question);
        Analytics.CountValue("total_story_event", data_event);
        Analytics.CountValue("total_story_other", data_other);

        Analytics.CountValue("total_timeline", data_timeline);
        Analytics.CountValue("total_photos", data_photos);
        Analytics.CountValue("total_photos_albums", data_photos_albums);
        Analytics.CountValue("total_profile", data_profile);
        Analytics.CountValue("total_profile_photos", data_profile_photos);
        Analytics.CountValue("total_likes", data_likes);
        Analytics.CountValue("total_videos", data_videos);
        Analytics.CountValue("total_photos_stream", data_photos_stream);
    });
</script>