# Mini Program Shop

指尖上的零食是基于 ThinkPHP 5 开发的小程序零食商城，包含轮播 banner、精选主题、最近新品、分类商品、购物车、下单、收货地址、历史订单等功能。项目在采用 MVC 架构的基础上再分了一层处理业务逻辑的 Logic 层，并应用 AOP 思想构建全局异常处理层。接口采取 RESTful Api 设计，使用控制器前置操作完成 token 权限校验。项目涉及借助微信登录接口实现认证体系、微信小程序支付、借助收货地址组件完成收货地址管理、获取用户信息、借助框架 behavior 解决跨域问题等

## License

Think Sample 遵循Apache2开源协议发布，并提供免费使用。 版权所有 by WeiZeng weimingzhili@foxmail.com

Apache Licence 是著名的非盈利开源组织 Apache 采用的协议。 该协议和 BSD 类似，鼓励代码共享和尊重原作者的著作权， 允许代码修改，再作为开源或商业软件发布。需要满足 的条件：

1. 需要给代码的用户一份 Apache Licence ；
2. 如果你修改了代码，需要在被修改的文件中说明；
3. 在延伸的代码中（修改和有源代码衍生的代码中）需要 带有原来代码中的协议，商标，专利声明和其他原来作者规 定需要包含的说明；
4. 如果再发布的产品中包含一个 Notice 文件，则在 Notice 文件中需要带有本协议内容。你可以在 Notice 中增加自己的许可，但不可以表现为对 Apache Licence 构成更改。

具体的协议参考：http://www.apache.org/licenses/LICENSE-2.0
