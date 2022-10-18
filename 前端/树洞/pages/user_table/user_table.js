// pages/user_table/user_table.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
        userdata: {},
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        var that = this
        that.get_all_user()
    },


    //获取所有用户数据
    get_all_user: function () {
        var that = this
        wx.showLoading({
            title: '加载中',
        })
        //与服务器交互
        wx.request({
            url: getApp().globalData.server + '/Admin/get_all_user',
            data: {},
            method: 'POST',
            header: {
                'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            success(res) {
                that.setData({
                    userdata: res.data.data
                })
                // //跳转
                // wx.reLaunch({
                //     url: "/pages/user_table/user_table",
                // })
            },
            complete: function (res) {
                wx.hideLoading()
            }
        })

        setTimeout(function () {
            wx.hideLoading()
        }, 2000)
    },

    //删除用户
    delete: function (e) {
        var that = this
        var userdata = that.data.userdata
        //提示是否删除
        wx.showModal({
            title: '提示',
            content: '是否删除',
            success(res) {
                if (res.confirm) {
                    //与服务器交互
                    wx.request({
                        url: getApp().globalData.server + '/admin/delete_user',
                        data: {
                            u_id: e.target.dataset.u_id,
                        },
                        method: 'POST',
                        header: {
                            'content-type': 'application/x-www-form-urlencoded' // 默认值
                        },
                        success(res) {
                            that.get_all_user()
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