// app.js
App({
  onLaunch() {
    // 展示本地存储能力
    const logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)

    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
      }
    })

    //获取用户信息
    wx.getSetting({
      success:res=>{
        if(res.authSetting['scope.address.userInfo']){
            //已经授权，可以直接调用getUserInfo获取头像昵称，不会弹出
            wx.getUserInfo({
              success:res=>{
                //可以将res发送给后台解码出unionId
                this.globalData.userInfo = res.userInfo

                if(this.userInfoReadyCallback){
                  this.userInfoReadyCallback(rese)
                }
              }
            })
        }
      }
    })
  },
  globalData: {
    message:{},
    user:{},
    userInfo: {},
    showdata:{},
    m_id:"",
    m_u_id:"",
    c_id:"",
    c_u_id:"",
    select_text:"",
   
    // server:'http://treehole2test.saelinzi.com/treehole/index.php/Home'
    server:'http://localhost:8081/treehole/index.php/Home',
  }
})
