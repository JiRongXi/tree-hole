// pages/load/load.js

const app = getApp()

Page({

    /**
     * 页面的初始数据
     */
    data: {
        userInfo: {},
        hasUserInfo: false,
        canIUseGetUserProfile: false,
    },

    urllogin: function (e) {
        //跳转
        wx.redirectTo({
            url: "/pages/login/login",
        })
    },

    next: function (e) {
        console.log("userInfo", getApp().globaData.userInfo)
        wx.redirectTo({
            url: '/pages/login/login'
        })
    },

    onLoad: function (options) {
        var that = this
        if (wx.getUserProfile) {
            this.setData({
                canIUseGetUserProfile: true
            })

            wx.getUserInfo({
                success: function (res) {
                    console.log(res.userInfo.nickName);
                    console.log(res.userInfo);
                    getApp.globaData.userInfo = res.userInfo;
                    that.next();
                }
            })
        }
    },


    getUserInfo(e) {
        // 不推荐使用getUserInfo获取用户信息，预计自2021年4月13日起，getUserInfo将不再弹出弹窗，并直接返回匿名的用户个人信息
        this.setData({
            userInfo: e.detail.userInfo,
            hasUserInfo: true
        })
    },

    globalData: {
        user: {},
        userInfo: {},
    },

    bindGetUserInfo(e) {
        getApp().globaData.userInfo = e.detail.userInfo
        wx.redirectTo({
            url: '/pages/login/login'
        })
    },

    getUserProfile(e) {
        // 推荐使用wx.getUserProfile获取用户信息，开发者每次通过该接口获取用户个人信息均需用户确认
        // 开发者妥善保管用户快速填写的头像昵称，避免重复弹窗
        wx.getUserProfile({
            desc: '用于完善会员资料', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
            success: (res) => {
                this.setData({
                    userInfo: res.userInfo,
                    hasUserInfo: true
                })
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