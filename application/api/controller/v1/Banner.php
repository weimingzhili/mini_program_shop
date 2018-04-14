<?php

namespace app\api\controller\v1;

use app\common\exception\ParameterException;
use app\common\model\BannerItem;
use think\Controller;
use think\Request;

/**
 * Banner
 * User: Wei Zeng
 */
class Banner extends Controller
{
    /**
     * 获取 bannerItem
     * @url   /banners/:id            访问url
     * @http  Get                     访问方式
     * @param \think\Request $request Request实例
     * @throws \Exception
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function read(Request $request)
    {
        // 获取参数
        $param       = [];
        $param['id'] = $request->param('id');

        // 校验参数
        $checkRet = $this->validate($param, 'Banner.read');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        // 获取
        $banner = BannerItem::getBannerItemByBannerId($param['id']);

        return $banner;
    }
}
