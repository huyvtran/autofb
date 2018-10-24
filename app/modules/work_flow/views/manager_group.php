<form class="ScheduleList" action="<?=cn('ajax_action_multiple')?>">
    <div class="row">
        <div class="clearfix"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header"> 
                    <h2>
                        <i class="fa fa-bars" aria-hidden="true"></i> Quản lý campaign group
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
                            <a href="<?=cn('add_group_campaign')?>" class="btn bg-light-green waves-effect"><i class="fa fa-plus" aria-hidden="true"></i> <?=l('Add new')?></a>
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
                                <th><?=l('Campaign name')?></th>
                                <th><?=l('Mô tả')?></th>
                                <th><?=l('Ngày bắt đầu')?></th>
                                <th><?=l('Ngày kết thúc')?></th>
                                <th><?=l('Option')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($result)){
                            foreach ($result as $key => $row) {
                            ?>
                            <tr class="post-pending" data-action="<?=cn('ajax_action_multiple')?>" data-id="<?=$row->id?>">
                                <td>
                                    <input type="checkbox" name="id[]" id="md_checkbox_<?=$key?>" class="filled-in chk-col-red checkItem" value="<?=$row->id?>">
                                    <label class="p0 m0" for="md_checkbox_<?=$key?>">&nbsp;</label>
                                </td>
                                <td><?=$row->name?></td>
                                <td><?=$row->description?></td>
                                <td><?=$row->start_date?></td>
                                <td><?=$row->end_date?></td>
                                <td style="width: 80px;">
                                    <div class="btn-group" role="group">
                                        <a href="<?=cn('edit_group_campaign?id='.$row->id)?>" class="btn bg-light-green waves-effect"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <button type="button" class="btn bg-light-green waves-effect btnActionModuleItem" data-action="delete_campaign_group" data-confirm="<?=l('Are you sure you want to delete this item?')?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
