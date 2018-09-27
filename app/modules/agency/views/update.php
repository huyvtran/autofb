<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <i class="fa fa-user" aria-hidden="true"></i> <?=l('Nâng cấp tài khoản')?> 
                </h2>
            </div>
            <div class="body pt0">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                 <!--   <li role="presentation" class="active"><a href="#home" data-toggle="tab" aria-expanded="true"><?=l('Profile')?></a></li> -->
                    <li role="presentation" class="active><a href="#profile" data-toggle="tab"><?=l('Chọn gói tài khoản')?></a></li>
                </ul>

                    <!-- Tab panes -->
                <form action="<?=cn('ajax_update')?>" data-redirect="<?=cn()?>">
                    <div class="tab-content pt15">
                        <div role="tabpanel" class="tab-pane fade active in" id="profile">
                            <b><?=l('Chọn gói tài khoản')?></b>
                            <div class="form-group">
                                <select name="package-id" class="package_change form-control">
                                    <option value="0"><?=l('--- Chọn gói tài khoản ---')?></option>
                                 
                                        <option value="<?php echo $package[0]->name ?>"> <?php echo ( $package[0]->name. " - " );  echo $package[0]->price?> </option>
                                        <option value="<?php echo $package[2]->name ?>"> <?php echo ( $package[2]->name. " - " );  echo $package[2]->price?> </option>
                                        <option value="<?php echo $package[6]->name ?>"> <?php echo ( $package[6]->name. " - " );  echo $package[6]->price?> </option>
                                    
                                </select>
                            </div>
   
                        </div>
                    </div>
                    <button type="submit" class="btn bg-red waves-effect btnActionUpdate"><?=l('Submit')?></button>
                </form>
            </div>
        </div>
    </div>
</div>
