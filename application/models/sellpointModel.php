<?php
/**
 * 用户模型
 * @author Administrator
 *
 */
class sellpointModel extends MY_Model{
    var $colum = '';
    /**
     * 构造函数
     */
    function sellpointModel(){
        parent::MY_Model();
        $this->table='pvSellPoint';
        $this->colum = 'Area_2015 area,Region_2015 region,SpSArea_2015 spsarea,Province province,County city,CountyLevel cityLevel,SellPointID userId,SellPointName storeName,Coding coding,Email email,Account userName,Password password';
        $this->load->library('Cache');
    }
    /**
     * 查找指定专营店信息
     * @param int $id
     * @return array
     */
    function getNewData($where){
        //更改数据库链接配置
        $this->db = $this->load->database('dflpvmkt', true);
        //isset($where['SpState_sys']) || $where['SpState_sys'] = 1;
        //isset($where['isOpen']) || $where['isOpen'] = 1;
        $findData   = parent::getData($where, $this->colum);
        //查完之后将数据库链接设置回默认设置
        $this->db = $this->load->database('', true);
        return $this->gbkToUtf8($findData);
    }
    /**
     * 获取专营店列表
     * @param array $where
     * @return array
     */
    function getNewList($where){
        //更改数据库链接配置
        $this->db = $this->load->database('dflpvmkt', true);
        //isset($where['SpState_sys']) || $where['SpState_sys'] = 1;
        //isset($where['isOpen']) || $where['isOpen'] = 1;
        $findList = parent::getList($where, NULL, NULL, $this->colum);
        //查完之后将数据库链接设置回默认设置
        $this->db = $this->load->database('', true);
        $list = array();
        foreach ($findList as $v){
            $list[(int)$v['userId']] = $this->gbkToUtf8($v);
        }
        return $list;
    }
    /**
     * 转换编码
     * @param array $storeData
     * @return multitype:string
     */
    function gbkToUtf8($storeData){
        $data = array();
        foreach ($storeData as $k => $v){
            $data[$k] = gbk2utf8($v);
        }
        return $data;
    }
    /**
     * 根据专营店ID获取专营店数据
     * @param int $storeId
     * @return array
     */
    function getStoreIdData($storeId){
        return $this->getNewData(array('SellPointID'=>$storeId));
        /* $allStoreList = $this->getCacheData('allStoreList');
        return isset($allStoreList[$storeId]) ? $allStoreList[$storeId] : array(); */
    }
    /**
     * 根据专营店编码获取专营店数据
     * @param string $code 专营店编码
     * @return array
     */
    function getStoreDataByCode($code){
        return $this->getNewData(array('Coding'=>$code,'SpState_sys'=>1,'isOpen'=>1));
    }
    /**
     * 创建专营店相关缓存
     */
    function createStoreCache(){
        $areaList = array();//地区列表
        $areaToRegionList = array();//地区对应大区列表
        $regionToProvinceList = array();//大区对应省份列表
        $provinceToCityList = array();//省份对应城市列表
        $cityToStoreList = array();//城市对应专营店列表
        $placeTree = array();//地区树结构列表
        $areaToStoreList = array();//地区对应专营店列表
        $regionToStoreList = array();//大区对应专营店列表
        $spsareaToStoreList = array();//小区对应专营店列表
        $allStoreList = array();//所有专营店列表
        //查询数据库数据
        $where['SpState_sys'] = 1;//账号类别，nissan账号
        $where['isOpen'] = 1;//未停用的账号
        $findAllList = $this->getNewList($where);
        foreach ($findAllList as $v){
            if ($v['area'] && $v['region'] && $v['spsarea'] && $v['province'] && $v['city'] && $v['userId'] && $v['storeName']){
                //地区列表
                in_array($v['area'], $areaList) || $areaList[] = $v['area'];
                //地区对应大区列表
                isset($areaToRegionList[$v['area']]) || $areaToRegionList[$v['area']] = array();
                in_array($v['region'], $areaToRegionList[$v['area']]) || $areaToRegionList[$v['area']] [] = $v['region'];
                //大区对应省份列表
                isset($regionToProvinceList[$v['region']]) || $regionToProvinceList[$v['region']] = array();
                in_array($v['province'], $regionToProvinceList[$v['region']]) || $regionToProvinceList[$v['region']][] = $v['province'];
                //省份对应城市列表
                isset($provinceToCityList[$v['province']]) || $provinceToCityList[$v['province']] = array();
                in_array($v['city'], $provinceToCityList[$v['province']]) || $provinceToCityList[$v['province']][] = $v['city'];
                //城市对应专营店列表
                isset($cityToStoreList[$v['city']]) || $cityToStoreList[$v['city']] = array();
                $cityToStoreList[$v['city']][] = array('userId'=>(int)$v['userId'], 'storeName'=>$v['storeName']);
                //地区树结构列表
                isset($placeTree[$v['area']][$v['region']][$v['spsarea']]) || $placeTree[$v['area']][$v['region']][$v['spsarea']] = array();
                $placeTree[$v['area']][$v['region']][$v['spsarea']][] = (int)$v['userId'];
                //地区对应专营店列表
                $areaToStoreList[$v['area']][(int)$v['userId']] = $v['storeName'];
                //大区对应专营店列表
                $regionToStoreList[$v['region']][(int)$v['userId']] = $v['storeName'];
                //小区对应专营店列表
                $spsareaToStoreList[$v['spsarea']][(int)$v['userId']] = $v['storeName'];
                //所有专营店列表
                $allStoreList[(int)$v['userId']] = $v;
            }
        }
        //保存缓存
        $this->cache->set('areaList', $areaList);//缓存地区列表
        $this->cache->set('areaToRegionList', $areaToRegionList);//缓存地区对应大区列表
        $this->cache->set('regionToProvinceList', $regionToProvinceList);//缓存大区对应省份列表
        $this->cache->set('provinceToCityList', $provinceToCityList);//缓存省份对应城市列表
        $this->cache->set('cityToStoreList', $cityToStoreList);//缓存城市对应专营店列表
        $this->cache->set('placeTree', $placeTree);//缓存地区树结构列表
        $this->cache->set('areaToStoreList', $areaToStoreList);//缓存地区对应专营店列表
        $this->cache->set('regionToStoreList', $regionToStoreList);//缓存大区对应专营店列表
        $this->cache->set('spsareaToStoreList', $spsareaToStoreList);//缓存小区对应专营店列表
        $this->cache->set('allStoreList', $allStoreList);//缓存全部专营店列表
    }
    /**
     * 获取专营店相关的缓存数据
     * @param string $type
     *              areaList：地区列表
     *              areaToRegionList：地区对应大区列表
     *              regionToProvinceList：大区对应省份列表
     *              provinceToCityList：省份对应城市列表
     *              cityToStoreList：城市对应专营店列表
     *              placeTree：地区树结构列表
     *              areaToStoreList：地区对应专营店列表
     *              regionToStoreList：大区对应专营店列表
     *              spsareaToStoreList：小区对应专营店列表
     *              allStoreList：全部专营店列表
     * @return mix
     */
    function getCacheData($type){
        $this->cache->expire = 86400;//设置过期时间为一天
        $data = $this->cache->get($type);
        if (!$data){
            //创建缓存
            $this->createStoreCache();
            $data = $this->cache->get($type);
        }
        return $data;
    }
    /**
     * 查询指定参数条件列表
     * @param string $area 地区
     * @param string $region 大区
     * @param string $spsarea 小区
     * @param string $province 省份
     * @param string $city 城市
     * @param number $storeId 专营店ID
     * @param string $keyword 关键字
     * @return array
     */
    function searchStore($area='', $region='', $spsarea='', $province='', $city='', $storeId = 0, $keyword=''){
        $where = array('SpState_sys'=>1,'isOpen'=>1);
        $area && $where['Area_2015'] = utf82gbk($area);
        $region && $where['Region_2015'] = utf82gbk($region);
        $spsarea && $where['SpSArea_2015'] = utf82gbk($spsarea);
        $province && $where['Province'] = utf82gbk($province);
        $city && $where['County'] = utf82gbk($city);
        if($storeId){
            if (is_int($storeId)){
                $where['SellPointID'] = $storeId;
            }
            if (is_array($storeId)){
                $where['SellPointID'] = array('in', (array)$storeId);
            }
        }
        $keyword && $where['SellPointName'] = array('like', utf82gbk($keyword));
        $findList = $this->getNewList($where);
        return $findList;
    }
}