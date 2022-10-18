// pages/comment_report/comment_report.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
        detail: "",
    },

    bindTextAreaBlur: function (e) {
        this.data.detail = e.detail.value
    },

    send: function (e) {
        var that = this
        wx.showLoading({
            title: '加载中',
        })

        //与服务器交互
        wx.request({
            url: getApp().globalData.server + '/Comment_report/new_comment_report',
            data: {
                c_id: getApp().globalData.c_id,
                u_id1: getApp().globalData.user.u_id,
                u_id2: getApp().globalData.c_u_id,
                cr_content: that.data.detail
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
                    wx.showModal({
                        title: '提示',
                        content: '举报成功',
                        showCancel: false,
                        success(res) {
                            if (res.confirm) {
                                //跳转
                                wx.reLaunch({
                                    url: "/pages/square/square",
                                })
                            }
                        }
                    })
                }
            },
            complete: function (res) {
                wx.hideLoading()
            }
        })

        setTimeout(function () {
            wx.hideLoading()
        }, 2000)
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