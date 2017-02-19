<?php /**
* @package iCMS
* @copyright 2007-2017, iDreamSoft
* @license http://www.idreamsoft.com iDreamSoft
* @author coolmoo <idreamsoft@qq.com>
*/
defined('iPHP') OR exit('What are you doing?');
admincp::head();
?>
<script type="text/javascript">
$(function(){
$("#<?php echo APP_FORMID;?>").batch();
});
</script>
<div class="iCMS-container">
  <div class="widget-box">
    <div class="widget-title">
      <span class="icon"> <i class="fa fa-search"></i> </span>
      <h5>搜索</h5>
    </div>
    <div class="widget-content">
      <form action="<?php echo iPHP_SELF ; ?>" method="get" class="form-inline">
        <input type="hidden" name="app" value="<?php echo admincp::$APP_NAME;?>" />
        <div class="input-prepend input-append">
          <span class="add-on">栏目</span>
          <select name="cid" id="cid" class="chosen-select" style="width: 230px;">
            <option value="0">所有栏目</option>
            <?php echo $category_select = category::select('cs') ; ?>
          </select>
          <span class="add-on">
            <input type="checkbox" name="sub" id="sub"/> 子栏目
          </span>
        </div>
        <div class="input-prepend input-append">
          <span class="add-on">每页</span>
          <input type="text" name="perpage" id="perpage" value="<?php echo $maxperpage ; ?>" style="width:36px;"/>
          <span class="add-on">条记录</span>
        </div>
        <div class="input-prepend input-append">
          <span class="add-on">关键字</span>
          <input type="text" name="keywords" class="span2" id="keywords" value="<?php echo $_GET['keywords'] ; ?>" />
          <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> 搜 索</button>
        </div>
      </form>
    </div>
  </div>
  <div class="widget-box" id="<?php echo APP_BOXID;?>">
    <div class="widget-title">
      <span class="icon">
        <input type="checkbox" class="checkAll" data-target="#<?php echo APP_BOXID;?>" />
      </span>
      <h5>标记列表</h5>
    </div>
    <div class="widget-content nopadding">
      <form action="<?php echo APP_FURI; ?>&do=batch" method="post" class="form-inline" id="<?php echo APP_FORMID;?>" target="iPHP_FRAME">
        <table class="table table-bordered table-condensed table-hover">
          <thead>
            <tr>
              <th><i class="fa fa-arrows-v"></i></th>
              <th style="width:20px;"><?php echo strtoupper($primary); ?></th>
              <?php foreach ($list_fields as $fi => $fkey) {?>
                <th><?php echo $fields[$fkey]['label'] ; ?></th>
              <?php }?>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $cidArray = iSQL::values($rs,'cid','array',null);

            $cidArray && $category_data = (array) category::get($cidArray);

            for($i=0;$i<$_count;$i++){
              $id       = $rs[$i][$primary];
              $category = (array)$category_data[$rs[$i]['cid']];
          ?>
            <tr id="tr<?php echo $id; ?>">
              <td><input type="checkbox" name="id[]" value="<?php echo $id ; ?>" /></td>
              <td><?php echo $id ; ?></td>
              <?php foreach ($list_fields as $fi => $fkey) {?>
              <td><?php echo iFormer::de_value($rs[$i][$fkey],$fields[$fkey]); ?></td>
              <?php }?>
              <td>
                <?php if($rs[$i]['status']=="1"){ ?>
                <a href="<?php echo APP_FURI; ?>&do=update&id=<?php echo $id ; ?>&_args=status:0" class="btn btn-small" target="iPHP_FRAME"><i class="fa fa-power-off"></i> 禁用</a>
                <?php } ?>
                <?php if($rs[$i]['status']=="0"){ ?>
                <a href="<?php echo APP_FURI; ?>&do=update&id=<?php echo $id ; ?>&_args=status:1" class="btn btn-small" target="iPHP_FRAME"><i class="fa fa-play-circle"></i> 启用</a>
                <?php } ?>
                <a href="<?php echo APP_URI; ?>&do=add&id=<?php echo $id ; ?>" class="btn btn-small"><i class="fa fa-edit"></i> 编辑</a>
                <a href="<?php echo APP_FURI; ?>&do=del&id=<?php echo $id ; ?>" target="iPHP_FRAME" class="del btn btn-small btn-danger fr" title='永久删除'  onclick="return confirm('确定要删除?');"/><i class="fa fa-trash-o"></i> 删除</a>
              </td>
            </tr>
            <?php }  ?>
          </tbody>
          <tr>
            <td colspan="<?php echo count($list_fields)+3;?>">
              <div class="pagination pagination-right" style="float:right;"><?php echo iUI::$pagenav ; ?></div>
              <div class="input-prepend input-append mt20">
                <span class="add-on">全选
                  <input type="checkbox" class="checkAll checkbox" data-target="#<?php echo APP_BOXID;?>" />
                </span>
                <div class="btn-group dropup" id="iCMS-batch">
                  <a class="btn dropdown-toggle" data-toggle="dropdown" tabindex="-1"><i class="fa fa-wrench"></i> 批 量 操 作 </a>
                  <a class="btn dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="divider"></li>
                    <li><a data-toggle="batch" data-action="dels"><i class="fa fa-trash-o"></i> 删除</a></li>
                  </ul>
                </div>
              </div>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php admincp::foot();?>
