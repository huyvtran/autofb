<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <i class="fa fa-user" aria-hidden="true"></i> <?=l('Update user')?> 
                </h2>
            </div>
            <div class="body pt0">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="active"><a href="#home" data-toggle="tab" aria-expanded="true"><?=l('Profile')?></a></li>
                    <li role="presentation"><a href="#profile" data-toggle="tab"><?=l('Package')?></a></li>
                </ul>

                    <!-- Tab panes -->
                <form action="<?=cn('ajax_update')?>" data-redirect="<?=cn()?>">
                    <div class="tab-content pt15">
                        <div role="tabpanel" class="tab-pane fade active in" id="home">
                            <div class="row">
                                <div class="col-sm-12 mb0">
                                    <input type="hidden" class="form-control" name="id" value="<?=!empty($result)?$result->id:""?>">
                                    <b><?=l('Is Admin')?></b>
                                    <div class="form-group">
                                        <select name="admin" class="form-control">
                                            <option value="0" <?=(!empty($result) && $result->admin == 0)?"selected=''":""?>><?=l('No')?></option>
                                            <option value="1" <?=(!empty($result) && $result->admin == 1)?"selected=''":""?>><?=l('Yes')?></option>
                                        </select>
                                    </div>
                                    <b><?=l('Fullname')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="fullname" value="<?=!empty($result)?$result->fullname:""?>">
                                        </div>
                                    </div>
                                    <b><?=l('Email')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="email" value="<?=!empty($result)?$result->email:""?>">
                                        </div>
                                    </div>
                                    <b><?=l('Time zone')?></b>
                                    <div class="form-group">
                                        <select name="timezone" class="form-control">
                                        <?php foreach(tz_list() as $t) { ?>
                                            <option value="<?=$t['zone'] ?>" <?=(!empty($result) && $result->timezone == $t['zone'])?"selected":""?>>
                                                <?=$t['diff_from_GMT'] . ' - ' . $t['zone'] ?>
                                            </option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                    <b><?=l('Password')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                    </div>
                                    <b><?=l('Re-password')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" class="form-control" name="repassword">
                                        </div>
                                    </div>
                                    <b><?=l('Status')?></b>
                                    <div class="form-group demo-radio-button">
                                        <input name="status" type="radio" id="default_yes" class="radio-col-red" <?=(!empty($result) && $result->status == 1)?"checked=''":""?> value="1">
                                        <label for="default_yes"><?=l('Yes')?></label>

                                        <input name="status" type="radio" id="default_no" class="radio-col-red" <?=(!empty($result) && $result->status == 0)?"checked=''":""?> value="0">
                                        <label for="default_no"><?=l('No')?></label>

                                    </div>
                                
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <b><?=l('Chọn gói tài khoản')?></b>
                            <div class="form-group">
                                <select name="package-id" class="package_change form-control">
                                    <option value="0"><?=l('--- Chọn gói tài khoản ---')?></option>
                                    <?php if(!empty($package)){
                                        foreach ($package as $row) {
                                    ?>
                                        <option value='<?=$row->permission?>|<?=$row->id?>'><?=$row->name?></option>
                                    <?php }}?>
                                    <option value>Không sửa gói</option>
                                </select>
                            </div>
                            <b><?=l('Số tài khoản')?></b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="maximum_account" value="<?=!empty($result)?(int)$result->maximum_account:""?>">
                                </div>
                            </div>
                            <b><?=l('Số lượng groups')?> (<span class="col-red">*</span>)</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="maximum_groups" value="<?=!empty($result)?(int)$result->maximum_groups:""?>">
                                </div>
                            </div>
                            <b><?=l('Số lượng pages')?> (<span class="col-red">*</span>)</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="maximum_pages" value="<?=!empty($result)?(int)$result->maximum_pages:""?>">
                                </div>
                            </div>
                            <b><?=l('Số lượng friends')?> (<span class="col-red">*</span>)</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="maximum_friends" value="<?=!empty($result)?(int)$result->maximum_friends:""?>">
                                </div>
                            </div>
                            <b><?=l('Ngày hết hạn')?></b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control form-date" name="expiration_date" value="<?=!empty($result)?$result->expiration_date:""?>">
                                </div>
                            </div>
                            <b><?=l('Thanh toán')?></b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="paided">
                                </div>
                            </div>
                            <b><?=l('Tỉ lệ hoa hồng')?></b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="commission">
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

<script type="text/javascript">
    $(function(){
        $(".package_change").change(function(){
            _value = $(this).val();
            _value = _value.split("|");
            _permission = JSON.parse(_value[0]);
            $("[name='maximum_account']").val(_permission.maximum_account);
            $("[name='maximum_groups']").val(_permission.maximum_groups);
            $("[name='maximum_pages']").val(_permission.maximum_pages);
            $("[name='maximum_friends']").val(_permission.maximum_friends);
        });
    });
</script>