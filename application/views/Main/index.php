<?php
$this->load->view('common/head');
?>
<?php $this->load->view('common/navbar');?>
       <div class="page-header">
        <h1>Tables</h1>
      </div>
      <div class="row">
        <div class="col-md-6">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-6">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td rowspan="2">1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <td>Mark</td>
                <td>Otto</td>
                <td>@TwBootstrap</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <td>3</td>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-6">
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <td>3</td>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
<nav class="text-right">
  <ul class="pagination">
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
<div class="row">
  <div class="col-xs-6 col-md-3">
    <a href="#" class="thumbnail">
      <img src="http://d.ifengimg.com/mw950_/y2.ifengimg.com/cmpp/2015/05/22/15/e370a8c8-b865-4500-98db-13930487e1fc_size150_w1000_h666.jpg" alt="...">
    </a>
  </div>
</div>
<span class="glyphicon glyphicon-save btn-lg" aria-hidden="true"></span>
<input type="button" name="test" id="test" value="测试" onclick="ajaxConfirmSubmit('确定删除？','index.php?c=Main&m=ajax')" />
		<div class="upload">
			<input class="ke-input-text" type="text" id="uploadButton1Url" value="" readonly="readonly" /> <input type="button" id="uploadButton1" value="上传" />
			<input class="ke-input-text" type="text" id="uploadButton2Url" value="" readonly="readonly" /> <input type="button" id="uploadButton2" value="上传" />
			<input class="ke-input-text" type="text" id="uploadButton3Url" value="" readonly="readonly" /> <input type="button" id="uploadButton3" value="上传" />
		</div>
		<p><input type="text" id="image1Value" value="" /> <input type="button" id="image1" value="选择图片" />（网络图片 + 本地上传）</p>
		<p><input type="text" id="image2Value" value="" /> <input type="button" id="image2" value="选择图片" />（网络图片）</p>
		<p><input type="text" id="image3Value" value="" /> <input type="button" id="image3" value="选择图片" />（本地上传）</p>
<?php
initUploadButtons(array('uploadButton1','uploadButton2','uploadButton3'),'index.php?c=Upload&m=uploadSave','imgFile');
initUploadImage(array('image1'),'index.php?c=Upload&m=uploadSave','local');
?>

<?php
$this->load->view('common/foot');
?>