<?php
//uri模式下设置此参数可以获取分页数值
$config['uri_segment'] = 3;
$config['num_links'] = 2;
//每页条数
$config['per_page'] = 10;
//查询字符串重写
$config['page_query_string'] = TRUE;
//分页参数字段
$config['query_string_segment'] = 'page';

//添加封装标签
$config['full_tag_open'] = '<nav class="text-right"><ul class="pagination">';
$config['full_tag_close'] = '</ul></nav>';

//自定义起始链接
$config['first_link'] = '首页';
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';

//自定义结束链接
$config['last_link'] = '末页';
$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';

//自定义“下一页”链接
$config['next_link'] = '下一页';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

//自定义“上一页”链接
$config['prev_link'] = '上一页';
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';

//自定义“当前页”链接
$config['cur_tag_open'] = '<li class="active"><a href="#">';
$config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';

//自定义“数字”链接
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';