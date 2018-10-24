<link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/fullcalendar/fullcalendar.min.css" />
<script src="<?php echo base_url() ?>assets/plugins/fullcalendar/lib/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/fullcalendar/gcal.js"></script>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="body pt0"> 
                <div id="calendar"></div>
                <input type="hidden" name="campaign_id" id="campaign_id" value="<?php echo $this->input->get("campaign_id", true);?>" />
            </div>
        </div>
    </div>
</div>

<!-- form -->
<form class="form-horizontal" action="<?=cn('ajax_post_now')?>" data-action="<?=cn('ajax_save_schedules')?>">
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Calendar Event</h4>
      </div>
      <div class="modal-body">
      <?php //echo form_open(site_url("work_flow/add"), array("class" => "form-horizontal")) ?>
      
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb0">
        <!-- Tab panes -->
        <div class="row mt15">
            <div class="body">
                <b>Chọn danh mục bài post</b>
                <select name ="select_data_cat" class="form-control mr5 input">
                    <?php foreach($categories_user as $cate){ ?>
                        <option value="<?=$cate->id?>"><?=$cate->name?> (Danh mục của bạn)</option>
                    <?php } ?>
                    <option value="Động lực sống">Động lực sống</option>
                    <option value="Kinh doanh">Kinh doanh</option>
                    <option value="Cuộc sống">Cuộc sống</option>
                    <option value="Bảo hiểm">Bảo hiểm</option>
                    <option value="Làm đẹp">Làm đẹp</option>
                    <option value="Tăng cân">Tăng cân</option>
                    <option value="Giảm cân">Giảm cân</option>
                    <option value="Bài đăng tuyển đại lý">Bài đăng tuyển đại lý</option>
                    <option value="Bài đăng chia sẻ hay">Bài đăng chia sẻ hay</option>
                </select>                     
            </div>
        </div>
        <div class="row mt15">
            <div class="body">
                <b>Chọn Pages/Groups/Profiles</b>
                <select name ="id[]" class="form-control mr5 input">
                    <?php foreach($result as $row){ ?>
                        <option value="<?="profile{-}".$row->id."{-}".$row->username."{-}".$row->fid."{-}".$row->fullname."{-}0"?>"><?=$row->username?>---<?=$row->fullname?>---profile</option>
                        <?php if(!empty($row->groups)){
                          foreach ($row->groups as $key => $group) {
                            $type = ($group->privacy == "CLOSED" || $group->privacy == "SECRET")?1:0;
                        ?>
                          <option value="<?=$group->type."{-}".$row->id."{-}".$row->fullname."{-}".$group->pid."{-}".$group->name."{-}".$type?>"><?=$row->username?>---<?=$group->name?>---<?=$group->type?></option>
                        <?php }}?>
                    <?php } ?>
                </select>                     
            </div>
        </div>
        <div class="row mt15">
            <div class="body">
                <label><?=l('Chữ ký của bạn')?></label>
                <div class="form-group" style="margin-left: 0px;margin-right: 0px;">
                    <div class="form-line p5">
                        <textarea rows="4" class="form-control post-message" name="chu_ky" placeholder="<?=l('Thêm chữ ký của bạn ở đây... xuống mỗi dùng dòng 1 chữ ký để thêm nhiều chữ ký')?>"></textarea>
                    </div>
                </div>
            </div>
        </div>
                            
        <div class="row mt15">
          <div class="body">
              <div class="row">
                  <div class="col-md-6">
                      <b><i class="fa fa-clock-o" aria-hidden="true"></i> <?=l('Time post')?></b>
                      <div class="input-group mb0">
                          <div class="form-line">
                              <input type="text" name="time_post" class="form-control form-datetime">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 col-xs-6">
                      <b><i class="fa fa-bullseye" aria-hidden="true"></i> <?=l('Delay (minutes)')?></b>
                      <div class="input-group mb0">
                          <select name="deplay" class="form-control">
                              <?php for ($i = 1; $i <= 720; $i++) {
                                  if(MINIMUM_DEPLAY <= $i){
                              ?>
                                  <option value="<?=$i?>" <?=(DEFAULT_DEPLAY == $i)?"selected":""?>><?=$i." ".l('minutes')?></option>
                              <?php }} ?>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <b><i class="fa fa-repeat" aria-hidden="true"></i> <?=l('Repeat post')?></b>
                      <div class="input-group mb0">
                          <select name="auto_repeat" class="form-control">
                              <option value="0"><?=l('No')?></option>
                              <?php for ($i = 1; $i <= 23; $i++) {
                              ?>
                                  <option value="<?=$i*60*60?>"><?=$i." ".l('hours')?></option>
                              <?php } ?>
                              <?php for ($i = 1; $i <= 365; $i++) {
                              ?>
                                  <option value="<?=$i*86400?>"><?=$i." ".l('days')?></option>
                              <?php } ?>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <b><i class="fa fa-calendar" aria-hidden="true"></i> <?=l('End day')?></b>
                      <div class="input-group mb0">
                          <div class="form-line">
                              <input type="text" name="repeat_end" class="form-control form-date">
                          </div>
                      </div>
                  </div>
                  <input type="hidden" name="campaign_id" id="campaign_id" value="<?php echo $this->input->get("campaign_id", true);?>" />
              </div>
          </div>
        </div>
      </div><!--END OF MODAL-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!-- <input type="submit" class="btn btn-primary" value="Add Event"> -->
        <button type="button" class="btn bg-light-blue waves-effect btnSaveSchedules"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> <?=l('Bắt đầu')?></button>
        <?php //echo form_close() ?>
      </div>
    
    </div>
  </div>
</div>
</form>
<!-- END FORM ADD NEW -->
<!-- BEGIN EDIT FORM -->
<form class="form-horizontal" action="<?=cn('ajax_post_now')?>" data-action="<?=cn('update_schedules')?>">
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Calendar Event</h4>
      </div>
      <div class="modal-body">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb0">
        <!-- Tab panes -->
        <div class="row mt15">
            <div class="body">
                <b>Chọn danh mục bài post</b>
                <select name ="select_data_cat" id="select_data_cat" class="form-control mr5 input">
                    <?php foreach($categories_user as $cate){ ?>
                        <option value="<?=$cate->id?>"><?=$cate->name?> (Danh mục của bạn)</option>
                    <?php } ?>
                    <option value="Động lực sống">Động lực sống</option>
                    <option value="Kinh doanh">Kinh doanh</option>
                    <option value="Cuộc sống">Cuộc sống</option>
                    <option value="Bảo hiểm">Bảo hiểm</option>
                    <option value="Làm đẹp">Làm đẹp</option>
                    <option value="Tăng cân">Tăng cân</option>
                    <option value="Giảm cân">Giảm cân</option>
                    <option value="Bài đăng tuyển đại lý">Bài đăng tuyển đại lý</option>
                    <option value="Bài đăng chia sẻ hay">Bài đăng chia sẻ hay</option>
                </select>                     
            </div>
        </div>
        <div class="row mt15">
            <div class="body">
                <b>Chọn Pages/Groups/Profiles</b>
                <select name ="id[]" id="select_group_page" class="form-control mr5 input">
                    <?php foreach($result as $row){ ?>
                        <option value="<?="profile{-}".$row->id."{-}".$row->username."{-}".$row->fid."{-}".$row->fullname."{-}0"?>"><?=$row->username?>---<?=$row->fullname?>---profile</option>
                        <?php if(!empty($row->groups)){
                          foreach ($row->groups as $key => $group) {
                            $type = ($group->privacy == "CLOSED" || $group->privacy == "SECRET")?1:0;
                        ?>
                          <option value="<?=$group->type."{-}".$row->id."{-}".$row->fullname."{-}".$group->pid."{-}".$group->name."{-}".$type?>"><?=$row->username?>---<?=$group->name?>---<?=$group->type?></option>
                        <?php }}?>
                    <?php } ?>
                </select>                     
            </div>
        </div>
        <div class="row mt15">
            <div class="body">
                <label><?=l('Chữ ký của bạn')?></label>
                <div class="form-group" style="margin-left: 0px;margin-right: 0px;">
                    <div class="form-line p5">
                        <textarea rows="4" class="form-control post-message" id="chu_ky" name="chu_ky" placeholder="<?=l('Thêm chữ ký của bạn ở đây... xuống mỗi dùng dòng 1 chữ ký để thêm nhiều chữ ký')?>"></textarea>
                    </div>
                </div>
            </div>
        </div>
                            
        <div class="row mt15">
          <div class="body">
              <div class="row">
                  <div class="col-md-6">
                      <b><i class="fa fa-clock-o" aria-hidden="true"></i> <?=l('Time post')?></b>
                      <div class="input-group mb0">
                          <div class="form-line">
                              <input type="text" id="time_post" name="time_post" class="form-control form-datetime">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 col-xs-6">
                      <b><i class="fa fa-bullseye" aria-hidden="true"></i> <?=l('Delay (minutes)')?></b>
                      <div class="input-group mb0">
                          <select name="deplay" id="deplay" class="form-control">
                              <?php for ($i = 1; $i <= 720; $i++) {
                                  if(MINIMUM_DEPLAY <= $i){
                              ?>
                                  <option value="<?=$i?>" <?=(DEFAULT_DEPLAY == $i)?"selected":""?>><?=$i." ".l('minutes')?></option>
                              <?php }} ?>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <b><i class="fa fa-repeat" aria-hidden="true"></i> <?=l('Repeat post')?></b>
                      <div class="input-group mb0">
                          <select name="auto_repeat" id="auto_repeat" class="form-control">
                              <option value="0"><?=l('No')?></option>
                              <?php for ($i = 1; $i <= 23; $i++) {
                              ?>
                                  <option value="<?=$i*60*60?>"><?=$i." ".l('hours')?></option>
                              <?php } ?>
                              <?php for ($i = 1; $i <= 365; $i++) {
                              ?>
                                  <option value="<?=$i*86400?>"><?=$i." ".l('days')?></option>
                              <?php } ?>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <b><i class="fa fa-calendar" aria-hidden="true"></i> <?=l('End day')?></b>
                      <div class="input-group mb0">
                          <div class="form-line">
                              <input type="text" name="repeat_end" class="form-control form-date">
                          </div>
                      </div>
                  </div>
                  <input type="hidden" name="eventid" id="event_id" value="0" />
                  <input type="hidden" name="campaign_id" id="campaign_id" value="<?php echo $this->input->get("campaign_id", true);?>" />
              </div>
          </div>
        </div>
      </div><!--END OF MODAL-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-light-blue waves-effect btnSaveSchedules"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> <?=l('Update')?></button>
      </div>
    
    </div>
  </div>
</div>
</form>
<!-- END EDIT FORM -->
<script type="text/javascript">
$(document).ready(function(){
  var date_last_clicked = null;
  var campaign_id = $('#campaign_id').val();

  $('#calendar').fullCalendar({
      selectable: true,
      header: {
        center: 'month,agendaWeek,agendaDay,timelineFourDays'
      },
      views: {
        timelineFourDays: {
          type: 'timeline',
          duration: { days: 4 }
        }
      },
      eventSources: [
       {
          events: function(start, end, timezone, callback) {
                $.ajax({
                  url: '<?php echo base_url() ?>work_flow/get_events',
                  dataType: 'json',
                  data: {
                    start: start.unix(),
                    end: end.unix(),
                    campaign_id: campaign_id
                  },
                  success: function(msg) {
                    var events = msg.events;
                    callback(events);
                  }
               });
          }
       },
      ],
      dayClick: function(date, jsEvent, view) {
        date_last_clicked = $(this);
        $('#addModal').modal();
      },
      eventClick: function(event, jsEvent, view) {
        $('#select_data_cat').val(event.title).find('option[value=" + event.title +"]').attr('selected', true);
        $('#select_group_page').val(event.selectPGP).find('option[value=" + event.selectPGP +"]').attr('selected', true);
        $('#deplay').val(event.deplay).find('option[value=" + event.deplay +"]').attr('selected', true);
        $('#auto_repeat').val(event.auto_repeat).find('option[value=" + event.auto_repeat +"]').attr('selected', true);
        $('#description').val(event.description);
        $('#chu_ky').val(event.chu_ky);
        $('#time_post').val(moment(event.start).format('YYYY-MM-DD HH:mm'));
        if(event.end) {
          $('#end_date').val(moment(event.end).format('YYYY-MM-DD HH:mm'));
        } else {
          $('#end_date').val(moment(event.start).format('YYYY-MM-DD HH:mm'));
        }
        $('#event_id').val(event.id);
        $('#editModal').modal();
     },
   });
});
</script>
