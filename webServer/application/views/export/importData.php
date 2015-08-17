<div class="row">
	<div class="col-lg-12">
		<h3>有错数据(如果有错误数据，不可提交！）</h3>
        <table class="table table-striped">
        	<thead>
        		<tr>
        			<th>行号</th>
        			<th width="40%">错误描述</th>
        			<th>错误详情</th>
        		</tr>
        	</thead>
        	<tbody>
        	<?
        	foreach ($this->lineCheckerError as $lineId => $value) {
        	?>
        		<tr>
        			<td>
        			<?=$lineId?>
        			</td>
        			<td>
        			<?=$value['msg']?>
        			</td>
        			<td>
        			<pre>

        			<?
        			print_r($value['info']);
        			?>
        			</pre>
        			</td>
        		</tr>

        	<?
        	}
        	?>
        	</tbody>
        </table>
    </div>
	<div class="col-lg-12">
		<h3>新增数据</h3>
        <table class="table table-striped">
        	<thead>
        		<tr>
        			<th>行号</th>
        			<th>新增条目</th>
        		</tr>
        	</thead>
        	<tbody>
        	<?
        	foreach ($this->lineCheckerInsert as $lineId => $value) {
        	?>
        		<tr>
        			<td>
        			<?=$lineId?>
        			</td>
        			<td>
        			<?=$value['msg']?>
        			</td>
        		</tr>
        	<?
        	}
        	?>
        	</tbody>
        </table>
    </div>
    <div class="col-lg-12">
		<h3>更新数据</h3>
        <table class="table table-striped">
        	<thead>
        		<tr>
        			<th>行号</th>
        			<th width="40%">内容</th>
        			<th>更新内容</th>
        		</tr>
        	</thead>
        	<tbody>
        	<?
        	foreach ($this->lineCheckerUpdate as $lineId => $value) {
        	?>
        		<tr>
        			<td>
        			<?=$lineId?>
        			</td>
        			<td width="40%">
        			<?=$value['msg']?>
        			</td>
        			<td width="50%">
        			<pre>
        			<?
        			print_r($value['info']);
        			?>
        			</pre>
					<div class="clear"></div>
        			</td>
        		</tr>

        	<?
        	}
        	?>
        	</tbody>
        </table>
    </div>
    <div class="col-lg-12">
        <h3>删除数据</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>行号</th>
                    <th>内容</th>
                </tr>
            </thead>
            <tbody>
            <?
            foreach ($this->lineCheckerDelete as $lineId => $value) {
            ?>
                <tr>
                    <td>
                    <?=$lineId?>
                    </td>
                    <td>
                    <?=$value['msg']?>
                    </td>

                </tr>

            <?
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
