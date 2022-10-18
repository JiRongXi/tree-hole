// pages/message_report_table/message_report_table.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
        message_report_data: {},
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        var that = this
        that.get_all_message_report()
    },

    //获取被举报的树洞消息
    get_all_message_report: function () {
        var that = this
        wx.showLoading({
            title: '加载中',
        })
        //与服务器交互
        wx.request({
            url: getApp().globalData.server + '/Message_report/get_all_message_report',
            data: {},
            method: 'POST',
            header: {
                'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            success(res) {
                console.log(res)
                that.setData({
                    message_report_data: res.data.data
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

    //删除被举报的树洞消息
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
                            that.get_all_message_report()
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