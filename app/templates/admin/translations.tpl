{extends file="admin/admin.tpl"}

{block name=head}
<link href="/script/jquery-ui/jquery-ui-1.7.1.custom.css" rel="stylesheet" type="text/css">
<link href="/script/jqgrid/ui.jqgrid.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/script/jqgrid/i18n/grid.locale-en.js"></script>
<script type="text/javascript" src="/script/jqgrid/jquery.jqGrid.min.js"></script>

<script type="text/javascript">
{literal}
$(function() {
var lastsel2;

jQuery("#transTbl").jqGrid({
  url: '/admin/translation_list',
	datatype: 'json',
  loadonce: true,
	editurl: '/admin/translation_edit',
	height: 707,
	rowNum: 30,
	pager:'#transPager',
  viewrecords: true,

  sortname: 'id',
  colNames:['id','ru','en','lv'],
  colModel:[
    {name:'id',index:'id', width:250, sortable:true, editable: false},
    {name:'ru',index:'ru', width:250, sortable:true, editable:true, edittype:"textarea"},
    {name:'en',index:'en', width:250, sortable:true, editable:true, edittype:"textarea"},
    {name:'lv',index:'lv', width:250, sortable:true, editable:true, edittype:"textarea"}
  ],
	onSelectRow: function(id){
		if(id && id!==lastsel2){

			jQuery('#transTbl').jqGrid('saveRow', lastsel2);
			lastsel2=id;
		}
		jQuery('#transTbl').jqGrid('editRow', id, true);
	}
});
$("#bsdata").click(function(){
	jQuery("#transTbl").jqGrid('searchGrid', {sopt:['cn','bw',/*'eq','ne','lt','gt',*/'ew'], top:360, left:500});
});
});
{/literal}
</script>
{/block}

{block name=content}
<div><table id="transTbl" class="tbl2"></table><div id="transPager"></div>
<input type="BUTTON" id="bsdata" value="Search">
{/block}
