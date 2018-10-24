<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i> <?=l('Update Calendar Event')?> 
                </h2>
            </div>
            <div class="body pt0">
                <form action="<?=cn('update_schedules')?>" data-redirect="<?=cn('manager')?>">
                    <div class="tab-content pt15">
                        <div role="tabpanel" class="tab-pane fade active in" id="home">
                            <div class="row">
                                <div class="col-sm-12 mb0">
                                    <input type="hidden" class="form-control" name="eventid" value="<?=!empty($event)?$event->id:""?>">
                                    <b>Chọn danh mục bài post</b>
                                    <select name ="select_data_cat" class="form-control mr5 input">
                                        <?php foreach($categories_user as $cate){ ?>
                                            <option value="<?=$cate->id?>"><?=$cate->name?> (Danh mục của bạn)</option>
                                        <?php } ?>
                                        <option value="Động lực sống" <?=(!empty($event) && $event->cat_data == 'Động lực sống')?"selected=''":""?>>Động lực sống</option>
                                        <option value="Kinh doanh" <?=(!empty($event) && $event->cat_data == 'Kinh doanh')?"selected=''":""?>>Kinh doanh</option>
                                        <option value="Cuộc sống" <?=(!empty($event) && $event->cat_data == 'Cuộc sống')?"selected=''":""?>>Cuộc sống</option>
                                        <option value="Bảo hiểm" <?=(!empty($event) && $event->cat_data == 'Bảo hiểm')?"selected=''":""?>>Bảo hiểm</option>
                                        <option value="Làm đẹp" <?=(!empty($event) && $event->cat_data == 'Làm đẹp')?"selected=''":""?>>Làm đẹp</option>
                                        <option value="Tăng cân" <?=(!empty($event) && $event->cat_data == 'Tăng cân')?"selected=''":""?>>Tăng cân</option>
                                        <option value="Giảm cân" <?=(!empty($event) && $event->cat_data == 'Giảm cân')?"selected=''":""?>>Giảm cân</option>
                                        <option value="Bài đăng tuyển đại lý" <?=(!empty($event) && $event->cat_data == 'Bài đăng tuyển đại lý')?"selected=''":""?>>Bài đăng tuyển đại lý</option>
                                        <option value="Bài đăng chia sẻ hay" <?=(!empty($event) && $event->cat_data == 'Bài đăng chia sẻ hay')?"selected=''":""?>>Bài đăng chia sẻ hay</option>
                                    </select>
                                    <b>Chọn Pages/Groups/Profiles</b>
                                    <select name ="id[]" class="form-control mr5 input">
                                        <?php 
                                          // $type = ($event->privacy == "CLOSED" || $event->privacy == "SECRET") ? 1 : 0;
                                          $selectPGP = $event->group_type.'{-}'.$event->account_id.'{-}'.$event->account_name.'{-}'.$event->group_id.'{-}'.$event->name.'{-}'.$type;
                                        ?>
                                        <?php foreach($result as $row){ 
                                          $option = 'profile{-}'.$row->account_id.'{-}'.$row->account_name.'{-}'.$row->group_id.'{-}'.$row->name.'{-}0';
                                        ?>
                                            <option value="<?="profile{-}".$row->id."{-}".$row->username."{-}".$row->fid."{-}".$row->fullname."{-}0"?>" <?=(!empty($event) && $selectPGP == $option)?"selected=''":""?>><?=$row->username?>---<?=$row->fullname?>---profile</option>
                                            <?php if(!empty($row->groups)){
                                              foreach ($row->groups as $key => $group) {
                                                $type = ($group->privacy == "CLOSED" || $group->privacy == "SECRET")?1:0;
                                                $optionG = $group->type."{-}".$row->id."{-}".$row->fullname."{-}".$group->pid."{-}".$group->name."{-}".$type;
                                            ?>
                                              <option value="<?=$group->type."{-}".$row->id."{-}".$row->fullname."{-}".$group->pid."{-}".$group->name."{-}".$type?>" <?=(!empty($event) && $selectPGP == $optionG)?"selected=''":""?>><?=$row->username?>---<?=$group->name?>---<?=$group->type?></option>
                                            <?php }}?>
                                        <?php } ?>
                                    </select>
                                    <label><?=l('Chữ ký của bạn')?></label>
                                    <div class="form-group" style="margin-left: 0px;margin-right: 0px;">
                                        <div class="form-line p5">
                                            <textarea rows="4" class="form-control post-message" value="<?=!empty($event)?$event->chu_ky:""?>" name="chu_ky" placeholder="<?=l('Thêm chữ ký của bạn ở đây... xuống mỗi dùng dòng 1 chữ ký để thêm nhiều chữ ký')?>"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                          <b><i class="fa fa-clock-o" aria-hidden="true"></i> <?=l('Time post')?></b>
                                          <div class="input-group mb0">
                                              <div class="form-line">
                                                  <input type="text" name="time_post" value="<?=!empty($event)?$event->time_post:""?>" class="form-control form-datetime">
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
                                                  <input type="text" name="repeat_end" value="<?=!empty($event)?$event->repeat_end:""?>" class="form-control form-date">
                                              </div>
                                          </div>
                                      </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div> 
                    <button type="submit" class="btn bg-red waves-effect btnActionUpdate"><?=l('Submit')?></button>
                </form>
            </div>
        </div>
    </div>
</div>