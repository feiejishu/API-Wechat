var app = getApp()
Page({
  data: {
    hidden: false,
  },
  onLoad() {
    //XXXXXXXXXX
  },
  
  /**小程序前端下单成功触发这个函数，然后请求小程序后台，后台调用打印接口进行打印 */
  requestPrint: function (event) {
    var cid = this.data.menu;//客户点的商品id及数量
    if (cid) {
      wx.request({
        url: 'http://XXX.XXX.com/Wechat/api',//小程序后台地址
        data: {
          cid: num,//客户点的商品id及数量等各种信息传到后台
        },
        method: 'POST', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
        header: {
          "Content-Type": "application/x-www-form-urlencoded"
        }, // 设置请求的 header
        success: function (res) {
          // console.log(res);
          var str = res.data;
          if (str == 'ok') {
            wx.showToast({
              title: '成功',
              icon: 'success',
              duration: 2000
            })
          } else {
            wx.showToast({
              title: str,
              icon: 'loading',
              duration: 3000
            })
          }
        },
        fail: function () {
          wx.showToast({
            title: '请求失败',
            icon: 'loading',
            duration: 3000
          })
        },
        complete: function () {
          // console.log('complete');
          // complete
        }
      })
    }else{
      wx.showToast({
        title: '请点商品',
        icon: 'warn',
        duration: 1000
      })
    }
  },
  onShareAppMessage: function () {
    return {
      title: 'XXX系统',
      desc: '最具人气的小程序系统!',
      path: '/page/index/index'
    }
  }
})