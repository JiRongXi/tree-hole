// pages/select_data/select_data.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
        showdata: {},
        show_cdata: {},
        u_id: "",
        m_id: "",
        detail: "",
        more_m_id: "",
        more_c_id: "",
        select_text: "",
    },

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
        wx.redirectTo({
          url: "/pages/mine/mine",
        })
      },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        var that = this
        that.setData({
            u_id: getApp().globalData.user.u_id
        })

        wx.showLoading({
            title: '加载中',
        })

        //获取查找到的树洞信息
        that.select_message()

        //获取所有评论消息
        that.get_all_comments()

        setTimeout(function () {
            wx.hideLoading()
        }, 2000)
    },

    //查找消息
    select_message: function () {
        var that = this
        wx.showLoading({
            title: '加载中',
        })
        //与服务器交互
        wx.request({
            url: getApp().globalData.server + '/Message/select_message',
            data: {
                m_content: getApp().globalData.select_text
            },
            method: 'POST',
            header: {
                'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            success(res) {
                that.setData({
                    showdata: res.data.data
                })
            },
            complete: function (res) {
                wx.hideLoading()
            }
        })
        setTimeout(function () {
            wx.hideLoading()
        }, 2000)
    },

    //查找输入
    selectInput: function (e) {
        this.data.select_text = e.detail.value
    },

    //点击查找
    select: function (e) {
        var that = this

        if (that.data.select_text == "") {
            wx.showLoading({
                title: '不能为空',
            })
            setTimeout(function () {
                wx.hideLoading()
            }, 1000)
        } else {
            getApp().globalData.select_text = that.data.select_text
            that.setData({
                select_text: ""
            })
            wx.navigateTo({
                url: "/pages/select_data/select_data",
            })
        }
    },

    
  //获取所有评论消息
  get_all_comments: function () {
    var that = this
    //与服务器交互
    wx.request({
      url: getApp().globalData.server + '/Comment/get_all_comments',
      data: {},
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded' // 默认值
      },
      success(res) {
        that.setData({
          show_cdata: res.data.data
        })
      },
      complete: function (res) {
        wx.hideLoading()
      }
    })
  },

  //点赞
  like: function (e) {
    var that = this
    var showdata = that.data.showdata
    for (var i = 0; i < showdata.length; i++) {
      if (showdata[i].m_id == e.target.dataset.m_id) {
        if (showdata[i].islike == 1) {
          showdata[i].likes--
          showdata[i].islike = 0

          //与服务器交互
          wx.request({
            url: getApp().globalData.server + '/Message/donot_likes',
            data: {
              m_id: e.target.dataset.m_id,
              username: getApp().globalData.user.username,
            },
            method: 'POST',
            header: {
              'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            success(res) {
              if (res.data.error_code == 1 || res.data.error_code == 3) {
                wx.showModal({
                  title: '提示!',
                  content: res.data.msg,
                  showCancel: false,
                  success(res) {}
                })
              } else {
                that.setData({
                  showdata: showdata
                })
              }
            },
          })
        } else {
          showdata[i].likes++
          showdata[i].islike = 1

          //与服务器交互
          wx.request({
            url: getApp().globalData.server + '/Message/do_likes',
            data: {
              m_id: e.target.dataset.m_id,
              username: getApp().globalData.user.username,
            },
            method: 'POST',
            header: {
              'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            success(res) {
              if (res.data.error_code == 1 || res.data.error_code == 3) {
                wx.showModal({
                  title: '提示!',
                  content: res.data.msg,
                  showCancel: false,
                  success(res) {}
                })
              } else {
                that.setData({
                  showdata: showdata
                })
              }
            },
          })
        }
      }
    }
  },

  //评论点赞
  c_like: function (e) {
    var that = this
    var show_cdata = that.data.show_cdata
    for (var i = 0; i < show_cdata.length; i++) {
      if (show_cdata[i].c_id == e.target.dataset.c_id) {
        if (show_cdata[i].islike == 1) {
          show_cdata[i].likes--
          show_cdata[i].islike = 0

          //与服务器交互
          wx.request({
            url: getApp().globalData.server + '/Comment/donot_likes',
            data: {
              c_id: e.target.dataset.c_id,
              username: getApp().globalData.user.username,
            },
            method: 'POST',
            header: {
              'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            success(res) {
              if (res.data.error_code == 1 || res.data.error_code == 3) {
                wx.showModal({
                  title: '提示!',
                  content: res.data.msg,
                  showCancel: false,
                  success(res) {}
                })
              } else {
                that.setData({
                  show_cdata: show_cdata
                })
              }
            },
          })
        } else {
          show_cdata[i].likes++
          show_cdata[i].islike = 1

          //与服务器交互
          wx.request({
            url: getApp().globalData.server + '/Comment/do_likes',
            data: {
              c_id: e.target.dataset.c_id,
              username: getApp().globalData.user.username,
            },
            method: 'POST',
            header: {
              'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            success(res) {
              if (res.data.error_code == 1 || res.data.error_code == 3) {
                wx.showModal({
                  title: '提示!',
                  content: res.data.msg,
                  showCancel: false,
                  success(res) {}
                })
              } else {
                that.setData({
                  show_cdata: show_cdata
                })
              }
            },
          })
        }
      }
    }
  },

  //评论栏
  comment1: function (e) {
    var that = this
    if (that.data.m_id != e.target.dataset.m_id) {
      that.setData({
        m_id: e.target.dataset.m_id,
        detail: ""
      })
    } else {
      that.setData({
        m_id: "",
        detail: ""
      })
    }
  },

  //评论提交
  comment2: function (e) {
    var that = this

    if (that.data.detail == "") {
      wx.showModal({
        title: '提示',
        content: '评论不能为空!',
        showCancel: false,
        success(res) {}
      })
    } else {
      //与服务器交互
      wx.request({
        url: getApp().globalData.server + '/Comment/new_comment',
        data: {
          u_id: getApp().globalData.user.u_id,
          m_id: e.target.dataset.m_id,
          c_content: that.data.detail
        },
        method: 'POST',
        header: {
          'content-type': 'application/x-www-form-urlencoded' // 默认值
        },
        success(res) {
          if (res.data.error_code == 1) {
            wx.showModal({
              title: '提示!',
              content: res.data.msg,
              showCancel: false,
              success(res) {}
            })
          } else {
            that.setData({
              detail: "",
              m_id: -1,

            })
            that.get_all_comments()
          }
        }
      })
    }
  },

  //更多栏
  more: function (e) {
    var that = this
    if (that.data.more_m_id != e.target.dataset.more_m_id) {
      that.setData({
        more_m_id: e.target.dataset.more_m_id,
      })
    } else {
      that.setData({
        more_m_id: ""
      })
    }

  },

  //评论区更多栏
  c_more: function (e) {
    var that = this
    if (that.data.more_c_id != e.target.dataset.more_c_id) {
      that.setData({
        more_c_id: e.target.dataset.more_c_id,
      })
    } else {
      that.setData({
        more_c_id: ""
      })
    }

  },

  //树洞消息举报
  report: function (e) {
    var that = this
    getApp().globalData.m_id = e.target.dataset.m_id
    getApp().globalData.m_u_id = e.target.dataset.m_u_id
    that.setData({
      more_m_id: ""
    })
    wx.navigateTo({
      url: "/pages/message_report/message_report",
    })
  },

  //树洞评论举报
  c_report: function (e) {
    getApp().globalData.c_id = e.target.dataset.c_id
    getApp().globalData.c_u_id = e.target.dataset.c_u_id

    wx.navigateTo({
      url: "/pages/comment_report/comment_report",
    })
  },

  //删除自己的树洞消息
  delete: function (e) {
    var that = this
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
              that.setData({
                more_m_id: ""
              })
              that.get_all_messages()
            },
          })
        }
      }
    })
  },

  //删除自己的树洞评论
  c_delete: function (e) {
    var that = this
    //提示是否删除
    wx.showModal({
      title: '提示',
      content: '是否删除',
      success(res) {
        if (res.confirm) {
          //与服务器交互
          wx.request({
            url: getApp().globalData.server + '/Comment/delete_comment',
            data: {
              c_id: e.target.dataset.c_id,
            },
            method: 'POST',
            header: {
              'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            success(res) {
              that.get_all_comments()
            },
          })
        }
      }
    })

  },


  bindTextArea: function (e) {
    this.data.detail = e.detail.value
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