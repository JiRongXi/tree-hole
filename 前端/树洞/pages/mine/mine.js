// pages/mine/mine.js
Page({
  go1: function () {
    wx.redirectTo({
      url: "/pages/square/square",
    })
  },

  goadd: function () {
    wx.navigateTo({
      url: "/pages/commit/commit",
    })
  },

  go2: function () {
    // wx.redirectTo({
    //   url: "/pages/mine/mine",
    // })
  },

  /**
   * 页面的初始数据
   */
  data: {
    face_url: "",
    username: "",
    up_username: "",
    showdata: {},
    showModal: false,
    is_up_username: false,
    is_chose_up_username: false
  },


  //换用户名
  changeUsername: function (e) {
    var that = this
    //第一次点击传递upUsername为1，第二次点击则为0
    if (e.target.dataset.upusername == 1) {
      that.setData({
        is_chose_up_username: !that.data.is_chose_up_username,
      })
    }

    if (e.target.dataset.upusername == 0) {
      that.setData({
        is_up_username: !that.data.is_up_username,
      })
    }

    if (e.target.dataset.upusername == -1) {
      that.setData({
        is_chose_up_username: !that.data.is_chose_up_username,
      })
      wx.redirectTo({
        url: "/pages/mine/mine",
      })
    }

    if (that.data.is_up_username) {
      if (that.data.up_username == "") {
        wx.showModal({
          title: '提示',
          content: '请输入用户名!',
          showCancel: false,
          success(res) {}
        })
      } else {
        wx.request({
          url: getApp().globalData.server + '/User/changUsername',
          data: {
            u_id: getApp().globalData.user.u_id,
            username: that.data.up_username,
          },
          method: 'POST',
          header: {
            'content-type': 'application/x-www-form-urlencoded' // 默认值
          },
          success(res) {
            if (res.data.error_code == 1 || res.data.error_code == 2 || res.data.error_code == 4) {
              console.log(res)
              console.log(e)
              console.log(res.data)
              wx.showModal({
                title: '提示!',
                content: res.data.msg,
                showCancel: false,
                success(res) {}
              })
            } else {
              console.log(res.data.data)
              console.log(that.data.face_url)

              wx.showModal({
                title: '提示!',
                content: '更改用户名成功！',
                showCancel: false,
                success(res) {},
                complete: function (res) {
                  that.setData({
                    username: that.data.up_username,
                    up_username: "",
                    is_up_username: !that.data.is_up_username,
                    is_chose_up_username: !that.data.is_chose_up_username,
                  })

                  getApp().globalData.user.username = that.data.username
                  //跳转
                  wx.redirectTo({
                    url: "/pages/mine/mine",
                  })
                }
              })
            }
          }
        })
      }
    }
  },

  upUsernameInput: function (e) {
    this.data.up_username = e.detail.value
  },

  //换头像
  changeFace_url: function () {
    var that = this;
    wx.chooseImage({
      count: 1, // 默认9      
      sizeType: ['original', 'compressed'],
      // 指定是原图还是压缩图，默认两个都有      
      sourceType: ['album', 'camera'],
      // 指定来源是相册还是相机，默认两个都有    
      success: function (res) {
        wx.request({
          url: getApp().globalData.server + '/User/changeFace_url',
          data: {
            u_id: getApp().globalData.user.u_id,
            face_url: res.tempFilePaths
          },
          method: 'POST',
          header: {
            'content-type': 'application/x-www-form-urlencoded' // 默认值
          },
          success(res) {
            console.log(res)
            that.setData({
              face_url: res.data.data.face_url
            })
            getApp().globalData.user.face_url = that.data.face_url
            wx.redirectTo({
              url: "/pages/mine/mine",
            })
          },
        })

        console.log(res.tempFilePaths)
        console.log(getApp().globalData.user.face_url)
      }
    })
  },


  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    that.get_one_user_all_messages()
  },

  //获取个人树洞消息
  get_one_user_all_messages: function () {
    var that = this
    //与服务器交互
    wx.request({
      url: getApp().globalData.server + '/Message/get_one_user_all_messages',
      data: {
        u_id: getApp().globalData.user.u_id
      },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded' // 默认值
      },
      success(res) {
        that.setData({
          showdata: res.data.data,
          username: getApp().globalData.user.username,
          face_url: getApp().globalData.user.face_url
        })
      },
      complete: function (res) {
        wx.hideLoading()
      }
    })
  },
  
  delete: function (e) {
    var that = this
    var showdata = that.data.showdata
    //提示是否删除
    wx.showModal({
      title: '提示',
      content: '是否删除',
      success(res) {
        if (res.confirm) {
          //与服务器交互
          wx.request({
            url: getApp().globalData.server + '/Message/delete_message',
            data: {
              m_id: e.target.dataset.m_id,
            },
            method: 'POST',
            header: {
              'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            success(res) {
              wx.reLaunch({
                url: "/pages/mine/mine",
              })
            },
          })
        }
      }
    })
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