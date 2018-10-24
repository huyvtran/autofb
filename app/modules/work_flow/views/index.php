<form class="ScheduleList" action="<?=cn('ajax_post_now')?>" data-action="<?=cn('ajax_action_multiple')?>">
<div class="clearfix"></div>
<!-- <form class="ScheduleList" action="<?=cn('ajax_action_multiple')?>"> -->
    <div class="row">
        <div class="clearfix"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header"> 
                    <h2>
                        <i class="fa fa-bars" aria-hidden="true"></i> Quản lý campaign
                    </h2>
                </div>
                <div class="header">
                    <div class="form-inline">
                        <div class="btn-group" role="group">
                            <!-- <div class="btn-group" role="group">
                                <button type="button" class="btn bg-red waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?=l('Action')?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="btnActionModule" data-action="repeat" data-confirm="<?=l('Are you sure you want to repeat this items?')?>" href="javascript:void(0);"><?=l('Repost')?></a></li>
                                    <li><a class="btnActionModule" data-action="delete" data-confirm="<?=l('Are you sure you want to delete this items?')?>" href="javascript:void(0);"><?=l('Delete')?></a></li>
                                </ul>
                            </div> -->
                            <a href="<?=cn('manager_group')?>" class="btn bg-light-green waves-effect"><i class="fa fa-cogs" aria-hidden="true"></i> <?=l('Manager group')?></a>
                            <a href="<?=cn('add_campaign')?>" class="btn bg-red waves-effect"><i class="fa fa-plus" aria-hidden="true"></i> <?=l('Add campaign')?></a>

                        </div>
                       <!--  <div class="form-group wa mr15">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn bg-blue-grey waves-effect" data-type="post" data-toggle="tooltip" title="<?=l('Copy')?>" data-action="<?=cn('')?>"><?=l('Copy')?></button>
                                <button type="button" class="btn bg-blue-grey waves-effect btnUpdateCategory" data-type="post" data-toggle="tooltip" title="<?=l('CSV')?>" data-action="<?=cn('')?>"><?=l('CSV')?></i></button>
                                <button type="button" class="btn bg-blue-grey waves-effect btnDeleteCategory" data-toggle="tooltip" title="<?=l('Excel')?>"><?=l('Excel')?></button>
                            </div>
                        </div> -->
                        <div class="form-group wa right">
                            <select class="form-control mr5 filter_campaign_category">
                                <option><?=l('All Campaign category')?></option>
                                <?php if(!empty($campaign)){
                                foreach ($campaign as $row) {
                                ?>
                                <option value="<?=$row->name?>" <?=(session("campaign") == $row->id)?"selected":""?>><?=$row->name?></option>
                                <?php }}?>
                            </select>
                        </div>
                        <div class="form-group wa right">
                            <select class="form-control mr5 filter_campaign_group" name="account">
                                <option value=""><?=l('All Campaign Group')?></option>
                                <?php if(!empty($campaign_group)){
                                foreach ($campaign_group as $row) {
                                ?>
                                <option value="<?=$row->name?>"><?=$row->name?></option>
                                <?php }}?>
                            </select>
                        </div> 
                    </div>
                </div>

                <div class="body p0">
                    <table class="table table-bordered table-striped table-hover js-dataTableSchedule dataTable mb0">
                        <thead>
                            <tr>
                                <th style="width: 10px;">
                                    <input type="checkbox" id="md_checkbox_all" class="filled-in chk-col-red checkAll">
                                    <label class="p0 m0" for="md_checkbox_all">&nbsp;</label>
                                </th>
                                <th><?=l('Campaign Group')?></th>
                                <th><?=l('Campaign Category')?></th>
                                <th><?=l('Mô tả')?></th>
                                <th><?=l('Start date')?></th>
                                <th><?=l('End date')?></th>
                                <th><?=l('Option')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($result)){
                            foreach ($result as $key => $row) {
                            ?>
                            <tr class="post-pending" data-action="<?=cn('ajax_action_multiple')?>" data-id="<?=$row->campaign_id?>">
                                <td>
                                    <input type="checkbox" name="id[]" id="md_checkbox_<?=$key?>" class="filled-in chk-col-red checkItem" value="<?=$row->id?>">
                                    <label class="p0 m0" for="md_checkbox_<?=$key?>">&nbsp;</label>
                                </td>
                                <td><?=$row->name?></td>
                                <td><?=$row->campaign_name?></td>
                                <td><?=$row->campaign_desc?></td>
                                <td><?=$row->start_date?></td>
                                <td><?=$row->end_date?></td>
                            
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?=cn('schedule?campaign_id='.$row->campaign_id)?>" data-toggle="tooltip" title="<?=l('Thêm hoặc sửa event')?>" class="btn bg-light-green waves-effect"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                        <button type="button" class="btn bg-light-green waves-effect btnActionModuleItem" data-action="delete" data-toggle="tooltip" title="<?=l('Xóa')?>" data-confirm="<?=l('Are you sure you want to delete this item?')?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        <button type="button" class="btn bg-light-green waves-effect btnActionModuleItemCopy" data-action="copy" data-toggle="tooltip" title="<?=l('Copy campaign')?>" data-confirm="<?=l('Bạn muốn copy?')?>"><i class="fa fa-copy" aria-hidden="true"></i></button>
                                    </div>
                                </td>
                            </tr>
                                
                            <?php }}?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
