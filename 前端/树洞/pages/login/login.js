// pages/login/login.js
Page({
  /**
   * 页面的初始数据
   */
  data: {
    phonenumber: "",
    password: "",
  },

  login: function () {
    var that = this;
    if (that.data.phonenumber == "admin") {
      if (that.data.password == "888888") {
        wx.redirectTo({
          url: "/pages/admin/admin",
        })
      } else {
        wx.showModal({
          title: '提示',
          content: '密码错误请重新输入!',
          showCancel: false,
          success(res) {}
        })
      }
    } else {
      var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
      if (that.data.phonenumber == "") {
        wx.showModal({
          title: '提示',
          content: '请输入手机号!',
          showCancel: false,
          success(res) {}
        })
      } else if (that.data.phonenumber.length != 11 || !myreg.test(that.data.phonenumber)) {
        wx.showModal({
          title: '提示',
          content: '请输入正确的手机号!',
          showCancel: false,
          success(res) {}
        })
      } else if (that.data.password == "") {
        wx.showModal({
          title: '提示',
          content: '请输入密码!',
          showCancel: false,
          success(res) {}
        })
      } else {
        console.log("success");
        wx.request({
          url: getApp().globalData.server + '/User/login',
          data: {
            phone: that.data.phonenumber,
            password: that.data.password,
          },
          method: 'POST',
          header: {
            'content-type': 'application/x-www-form-urlencoded' // 默认值
          },
          success(res) {
            if (res.data.error_code == 1) {
              wx.showModal({
                title: '提示!',
                content: '参数不足',
                showCancel: false,
                success(res) {}
              })
            } else if (res.data.error_code == 2 || res.data.error_code == 3) {
              wx.showModal({
                title: '提示!',
                content: res.data.msg,
                showCancel: false,
                success(res) {}
              })
            } else {
              getApp().globalData.user = res.data.data
              //跳转reLaunch
              wx.redirectTo({
                url: "/pages/mine/mine",
              })
            }
          }
        })
      }
    }
  },

  register: function () {
    wx.redirectTo({
      url: "/pages/enroll/enroll",
    })
  },


  phonenumberInput: function (e) {
    this.data.phonenumber = e.detail.value
  },

  passwordInput: function (e) {
    this.data.password = e.detail.value
  },


  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})