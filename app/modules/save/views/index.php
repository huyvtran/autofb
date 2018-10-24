<form class="ScheduleList" action="<?=cn('ajax_action_multiple')?>">
    <div class="row">
        <div class="clearfix"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="active"><a href="#tab-1" data-toggle="tab" aria-expanded="true">Bài viết</a></li>
                    <li role="presentation" class=""><a href="#tab-2" data-toggle="tab" aria-expanded="false">Danh mục</a></li>
            </ul>
            <div class="tab-content">
	            <div role="tabpanel" class="tab-pane card" id="tab-2">
	            	<div class="header">
	            		<label>Danh mục bài viết</label>	
	            	</div>
	            	<div class="body">	            		
		            		<div class="input-group">
				                <div class="form-line">
				                    <input type="text" id="cate_post" name="cat_data" class="form-control">
				                </div>
				                <span class="input-group-btn">
				                  <a class="btn bg-red btnAddPostCate"><i class="fa fa-plus" aria-hidden="true" type="button"></i> Thêm</a>
				                </span>
			            	</div>		            	
	            	</div><!-- body -->
	            	<div class="body">
	            		<table class="table table-bordered table-striped table-hover js-dataTable dataTable mb0">
		                        <thead>
		                            <tr>
		                                <th style="width: 10px;">
		                                    <input type="checkbox" id="md_checkbox_211" class="filled-in chk-col-red checkAll">
		                                    <label class="p0 m0" for="md_checkbox_211">&nbsp;</label>
		                                </th>
		                                <th><?=l('Name')?></th>		
		                                <th>Xóa</th>                                
		                            </tr>
		                        </thead>
		                        <tbody>
		                            <?php 
		                            if(!empty($categories)){
		                            foreach ($categories as $key => $row) {
		                            ?>
		                            <tr id="cate-item-<?=$row->id?>" class="pending" data-id="<?=$row->id?>">
		                                <td>
		                                    <input type="checkbox" name="id[]" id="md_checkbox_<?=$key?>" class="filled-in chk-col-red checkItem" value="<?=$row->id?>">
		                                    <label class="p0 m0" for="md_checkbox_<?=$key?>">&nbsp;</label>
		                                </td>
		                                <td><?=$row->name?></td>
		                             	 <td style="width: 80px;">
		                                    <div class="btn-group" role="group">
		                                        <button type="button" data-action="<?=cn('ajax_delete_user_categories')?>" class="btn bg-light-green waves-effect btnDeleteUserCategories" data-action="delete" data-id="<?=$row->id?>" data-table="user_categories" data-confirm="<?=l('Bạn có muốn xóa danh mục này?')?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
		                                    </div>
		                                </td>
		                            </tr>
		                            <?php }}?>
		                        </tbody>
		                    </table>
	            	</div> <!-- body -->
	            	
	            </div>
	            <div role="tabpanel" class="tab-pane fade active in" id="tab-1">
		            <div class="card" id="tab-1">
		                <div class="header">
		                    <h2>
		                        <i class="fa fa-floppy-o" aria-hidden="true"></i> <?=l('Save management')?>
		                    </h2>
		                </div>
		                <div class="header">
		                    <div class="form-inline">
		                        <div class="btn-group" role="group">
		                            <div class="btn-group" role="group">
		                                <button type="button" class="btn bg-red waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                                    <?=l('Action')?>
		                                    <span class="caret"></span>
		                                </button>
		                                <ul class="dropdown-menu">
		                                    <li><a class="btnActionModule" data-action="active" href="javascript:void(0);"><?=l('Active')?></a></li>
		                                    <li><a class="btnActionModule" data-action="disable" href="javascript:void(0);"><?=l('Deactive')?></a></li>
		                                    <li><a class="btnActionModule" data-action="delete" data-confirm="<?=l('Are you sure you want to delete this items?')?>" href="javascript:void(0);"><?=l('Delete')?></a></li>
		                                </ul>
		                            </div>
		                        </div>
		                    </div> 
		                </div>
		                <div class="body p0">
		                    <table class="table table-bordered table-striped table-hover js-dataTable dataTable mb0">
		                        <thead>
		                            <tr>
		                                <th style="width: 10px;">
		                                    <input type="checkbox" id="md_checkbox_211" class="filled-in chk-col-red checkAll">
		                                    <label class="p0 m0" for="md_checkbox_211">&nbsp;</label>
		                                </th>
		                                <th><?=l('Name')?></th>
		                                <th class="col-md-2"><?=l('Danh mục bài viết')?></th>		                                
		                                <th><?=l('Category')?></th>
		                                <th><?=l('Type')?></th>
		                                <th><?=l('Status')?></th>
		                                <th><?=l('Option')?></th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                            <?php 
		                            if(!empty($result)){
		                            foreach ($result as $key => $row) {
		                            ?>
		                            <tr class="pending" data-action="<?=cn('ajax_action_item')?>" data-id="<?=$row->id?>">
		                                <td>
		                                    <input type="checkbox" name="id[]" id="md_checkbox_<?=$key?>" class="filled-in chk-col-red checkItem" value="<?=$row->id?>">
		                                    <label class="p0 m0" for="md_checkbox_<?=$key?>">&nbsp;</label>
		                                </td>
		                                <td><?=$row->name?></td>
		                                <td><?=$row->user_category_name?></td>
		                                <td><?=$row->category?></td>
		                                <td><?=$row->type?></td>
		                                <td style="width: 60px;">
		                                    <div class="switch">
		                                        <label><input type="checkbox" class="btnActionModuleItem" <?=$row->status==1?"checked":""?>><span class="lever switch-col-light-blue"></span></label>
		                                    </div>
		                                </td>
		                                <td style="width: 80px;">
		                                    <div class="btn-group" role="group">
		                                        <button type="button" class="btn bg-light-green waves-effect btnActionModuleItem" data-action="delete" data-confirm="<?=l('Are you sure you want to delete this item?')?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
		                                    </div>
		                                </td>
		                            </tr>
		                            <?php }}?>
		                        </tbody>
		                    </table>   
		                </div>
		            </div><!-- tab-1 -->
	        	</div>
        	</div><!-- tab content -->
        </div>
    </div>
</form>