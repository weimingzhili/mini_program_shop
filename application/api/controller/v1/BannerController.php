<?php

namespace app\api\controller\v1;

use app\common\exception\NotFoundException;
use app\common\exception\ParameterException;
use app\common\model\BannerItem;
use think\Request;

/**
 * Banner
 * User: Wei Zeng
 */
class BannerController extends Base
{
    /**
     * 获取 bannerItem
     *
     * @url /banners/:id 访问url
     * @http Get 访问方式
     * @param Request $request
     * @return \think\response\Json
     * @throws NotFoundException
     * @throws ParameterException
     * @throws \think\exception\DbException
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
        $bannerItems = BannerItem::getBannerItemByBannerId($param['id']);
        if ($bannerItems->isEmpty())
        {
            throw new NotFoundException('Banner Items Not Found');
        }

        return $this->restResponse($bannerItems);
    }
}
