<table class="content_list">
  <?php foreach((array)$attrModel as $key=>$row):?>
  <tr >
    <td ><div class="custom_title"><?php echo $row['attr_name']?>：</div>
      <div class="custom_content">
        <input type="hidden" name="attr[<?php echo $key?>][id]" value="<?php echo $row['id']?>" />
        <input type="hidden" name="attr[<?php echo $key?>][name]" value="_<?php echo $row['attr_name_alias']?>" />
        <?php switch($row['attr_type']):?><?php case'input':?>
        <input type="text" class="txt" name="attr[<?php echo $key?>][val]" value="<?php echo $attrData['_'.$row['attr_name_alias']]?>" />
        <?php break;case 'select':  ;?>
        <select id="select" name="attr[<?php echo $key?>][val]">
          <?php foreach(explode('|',$row['data_default']) as $v):?>
          <?php $val = @explode('=', $v)?>
          <option value="<?php echo $val[1]?>" <?php XUtils::selected($val[1], $attrData['_'.$row['attr_name_alias']])?>><?php echo $val[0]?></option>
          <?php endforeach?>
        </select>
        <?php break;case 'file':  ;?>
        <input name="attr[<?php echo $key?>][val]" type="file" />
        <?php break;case 'checkbox':  ;?>
        <?php foreach(explode('|',$row['data_default']) as $v):?>
        <?php $val = @explode('=', $v)?>
        <input name="attr[<?php echo $key?>][val][]" type="checkbox" id="checkbox" value="<?php echo $val[1]?>" <?php if(in_array($val[1], explode(',', $attrData['_'.$row['attr_name_alias']]))):?>checked="checked"<?php endif?>/>
        <?php echo $val[0]?>
        <?php endforeach?>
        <?php break;case 'textarea':  ;?>
        <textarea name="attr[<?php echo $key?>][val]" cols="50" rows="4" ><?php echo $attrData['_'.$row['attr_name_alias']]?></textarea>
        <?php break;case 'radio':  ;?>
        <?php foreach(explode('|',$row['data_default']) as $v):?>
        <?php $val = @explode('=', $v)?>
        <input name="attr[<?php echo $key?>][val]" type="radio" value="<?php echo $val[1]?>" <?php XUtils::selected($val[1], $attrData['_'.$row['attr_name_alias']],'checked')?>/>
        <?php echo $val[0]?>
        <?php endforeach?>
        <?php endswitch?>
        <br />
        标识：_<?php echo $row['attr_name_alias']?>
        <?php if($row['tips']):?>
        说明:<?php echo $row['tips']?>
        <?php endif?>
      </div></td>
  </tr>
  <?php endforeach?>
</table>
