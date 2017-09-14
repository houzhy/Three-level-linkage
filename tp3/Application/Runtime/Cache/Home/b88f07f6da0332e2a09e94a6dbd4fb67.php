<?php if (!defined('THINK_PATH')) exit();?><html> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/php05/mianshi/sanjiliandong/tp3/Public/Home/bootstrap/css/bootstrap.min.css">
<body> 
<label for="select_city">城市</label> 
	<div class="form-group required">
	    <label for="input-region-level-1" class="col-sm-1 control-label">省/直辖市</label>
	    <div class="col-sm-2">
	        <select class="form-control" id="input-region-level-0" name="region_state_id" data-level="0">
	        	<option value="-1"> --- 请选择国家 --- </option>
	        </select>
	    </div>
	    <div class="col-sm-2">
	        <select class="form-control" id="input-region-level-1" name="region_one_id" data-level="1">
	        </select>
	    </div>
	    <div class="col-sm-2">
	        <select class="form-control" id="input-region-level-2" name="region_two_id" data-level="2"></select>
	    </div>

	    <div class="col-sm-2">
	        <select class="form-control" id="input-region-level-3" name="region_three_id" data-level="3"></select>
	    </div>
	    <div class="col-sm-2">
	        <input type="text" class="form-control" id="input-address" placeholder="地址" value="" name="address">
	    </div>
	</div>
<script src="/php05/mianshi/sanjiliandong/tp3/Public/Home/jquery-3.2.1.min.js"></script> 
</body> 
</html> 
<script>
    /**
     * 查找某个父地区下所有的子地区
     * @param parent_id
     * @return 地区列表数组
     */
    function childRegion(parent_id)
    {
        var url = "<?php echo U('CityLian/city_lian');?>";
        var data = {
            parent_id: parent_id,
        };
        var list = [];
        $.ajax({
            async: false, // 非异步--同步阻塞
            url: url,
            type: 'get',
            data: data,
            dataType: 'json',
            success: function (resp) {
                if (resp.error != 0) {
                    console.log(resp.errorInfo);
                    list = [];
                } else {
                    list = resp.data;
                }
            }
        });

        return list;
    }
    // 以那个为paernt_id获取数据, 以此填充level为几的下拉列表
    function setRegion(parent_id, level) {
        // 一: 利用parent_id获取子地区
        var regionList = childRegion(parent_id);

        // 二: 利用子地区, 填充地区选择下拉列表
        // var html = '<option value="-1"> --- 请选择 --- </option>';
        var html = $('#input-region-level-'+level).html();
        $.each(regionList, function(i, region) {
            html += '<option value="' + region.region_id + '">' + region.title + '</option>' + '\n';
        });
        console.log(html);
        $('#input-region-level-'+level).empty().append(html);

        // 三: 重置后边的级别
        for(var l=level+1, t=3; l<=t; ++l) {
        	switch(l){
				case 1:
				  $('#input-region-level-'+l).empty().append('<option value="-1"> --- 请选择省份 --- </option>');
				  break;
				case 2:
				  $('#input-region-level-'+l).empty().append('<option value="-1"> --- 请选择城市 --- </option>');
				  break;
				case 3:
				  $('#input-region-level-'+l).empty().append('<option value="-1"> --- 请选择县区 --- </option>');
				  break;
				default:
				  break;
        	}
		}
            
    }
    // c初始化时, 填充1级地区, 使用1为parent_id
    $(function() {
        // 初始化1级地区
        setRegion(0, 0);

        // 绑定列表的change事件
        $('select[id^=input-region-level-]').change(function(evt) {
            // 如果切换到请选择, 不做任何操作
            if ($(this).val() == "-1") {
                return ;
            }
            // 利用当前选择的ID, 获取子地区, 填充下个level的列表
            setRegion($(this).val(), parseInt($(this).data('level'))+1);
        });
    });
</script>
</body> 
</html>