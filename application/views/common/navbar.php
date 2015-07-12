<!-- Static navbar -->
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- <a class="navbar-brand" href="#">百县强基</a> -->
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
        <?php foreach ($this->navbarList as $key => $value):?>
          <?php if (isset($value['child'])):?>
          <li class="dropdown">
            <a href="<?php echo printUrl($value[0], $value[1]) ?>" class="dropdown-toggle <?php echo $this->navbarFocus == $value[0] ? 'class="active"' : '' ?>" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $value['title']; ?><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <?php foreach ($value['child'] as $childK => $childV):?>
                  <?php if ($childV == 'line'):?>
                    <li class="divider"></li>
                  <?php else:?>
                  <li><a href="<?php echo printUrl($childV[0], $childV[1]); ?>"><?php echo $childV['title'];?></a></li>
                  <?php endif;?>
              <?php endforeach;?>
            </ul>
          </li>
          <?php else: ?>
            <li <?php echo $this->navbarFocus == $value[0] ? 'class="active"' : '' ?>><a href="<?php echo printUrl($value[0], $value[1]) ?>"><?php echo $value['title']; ?></a></li>
          <?php endif;?>
        <?php endforeach; ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/">返回营销网</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
  </nav>
  <!-- 面包靴 -->
  <?php if ($this->viewData['breadcrumb']) {?>
    <ol class="breadcrumb">
      <?php foreach ($this->viewData['breadcrumb'] as $k => $v) {?>
        <?php if ($k+1 != count($this->viewData['breadcrumb'])) {?>
        <li><a href="<?=$v['url']?$v['url']:'#'?>"><?=$v['title']?></a></li>
        <?php }else{ ?>
        <li class="active"><?=$v['title']?></li>
        <?php }?>
      <?php } ?>
    </ol>
  <?php } ?>