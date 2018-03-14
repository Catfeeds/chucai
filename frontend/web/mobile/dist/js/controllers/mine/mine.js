'use strict';
app.controller('mineCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
    // 底部个人中心标志图标
    $rootScope.baseOption.active=4;
    //弹窗
    $scope.mPop={
        content:{
            type: 'success',
            title: '通知',
            text: 'Message',
            dataout:2000
        },
        launch:function () {
            toaster.pop($scope.mPop.content.type, $scope.mPop.content.title, $scope.mPop.content.text,$scope.mPop.content.dataout);
        },
        info:function (text) {
            $scope.mPop.content.type='success';
            $scope.mPop.content.text=text;
            $scope.mPop.launch();
        },
        err:function (text) {
            $scope.mPop.content.type='error';
            $scope.mPop.content.text=text;
            $scope.mPop.launch();
        }
    };
    $rootScope.changeNavH();
    // 是否有新消息
    $scope.isRead = false;
    $http.post('/notice/notice-api/all',{
        token:$sessionStorage.token,
        type:0
    }).success(function (res) {
        if(res.errcode==0){
            var arr = res.data.list;
            angular.forEach(arr,function (val) {
                if(val.is_read==1){
                    $scope.isRead = true;
                }else if(val.is_read==2){
                    $scope.isRead = false;
                }
            })
        }
    });
    //用户信息
    $scope.isLogin = true;
    if($sessionStorage.token){
        $scope.isLogin = false;
        $scope.userName = $sessionStorage.userName;
        $scope.userList = [];
        $scope.userVip = $sessionStorage.useVip; //用户积分等级
        $scope.userSex = $sessionStorage.userSex; //用户性别
        $scope.userPhoto = $sessionStorage.userPhoto; // 用户头像
        $http.post('/ruiuser/user-api/view',{
            token:$sessionStorage.token
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.userList = data.data;
                // 姓名显示
                if($scope.userList.name == null){
                    $scope.userName = $sessionStorage.userName = '请设置姓名';
                }else{
                    $scope.userName = $sessionStorage.userName = $scope.userList.name; // 用户名
                }
                $sessionStorage.userMobile = $scope.userList.mobile; // 用户登录号码
                // 头像显示
                if($scope.userList.headimg == null){
                    $scope.userPhoto = $sessionStorage.userPhoto = 'img/mine/uploadpic.png'
                }else{
                    $scope.userPhoto = $sessionStorage.userPhoto = $scope.userList.headimg; // 用户头像
                }
                // 有无企业绑定获取
                if(parseInt($scope.userList.company_id) != 0){
                    $sessionStorage.companyName = $scope.userList.company.name; // 企业绑定
                }
                // 身份证
                $sessionStorage.user_id_card = $scope.userList.id_card;
                // 性别
                switch(parseInt($scope.userList.sex)){
                    case 1:$scope.userSex = $sessionStorage.userSex = '男' ;
                        break;
                    case 2:$scope.userSex = $sessionStorage.userSex = '女' ;
                        break;
                    default:$scope.userSex = $sessionStorage.userSex = '请设置性别';
                }
                // 用户vip等级
                var s = data.data.vip;
                $scope.userVip = $sessionStorage.useVip = 'v' + s;

            }else if(data.errcode == 9999){
                $scope.mPop.err('该账号已在别处登录，请重新登录');
                $timeout(function () {
                    $state.go('login')
                },2000)
            }
        });
    }

//    去往家人管理
    $scope.goFamily = function () {
        if($sessionStorage.token){
            $sessionStorage.ddxqFamily = false;
            $state.go('family')
        }else {
            $scope.mPop.err('登录后再进行家人管理操作')
        }
    };
    //去往健康档案
    $scope.goJkda = function () {
        if($sessionStorage.token){
            $state.go('jkda')
        }else {
            $scope.mPop.err('登录后才能查看健康档案')
        }
    };
    //去往体验券
    if(!$sessionStorage.coupon){
        $sessionStorage.coupon=0;
    }
    $scope.coupon = $sessionStorage.coupon;
    if(!$sessionStorage.couponList){
        $sessionStorage.couponList=[];
    }
    $scope.couponList = $sessionStorage.couponList;
    if(!$sessionStorage.couponUsed){
        $sessionStorage.couponUsed=0;
    }
    $scope.couponUsed = $sessionStorage.couponUsed;
    if(!$sessionStorage.couponListUsed){
        $sessionStorage.couponListUsed=[];
    }
    $scope.couponListUsed = $sessionStorage.couponListUsed;
    $scope.goWdtyq = function () {
        if($sessionStorage.token){
            $http.post('/coupon/coupon-user-api/index',{
                token:$sessionStorage.token,
                start_page:0,
                pages:10
            }).success(function (res) {
                if(res.errcode==0){
                    $sessionStorage.couponList = [];
                    $sessionStorage.couponListUsed = [];
                    angular.forEach(res.data.list,function (val) {
                        if(val.status == '1'){
                            $sessionStorage.couponList.push(val);
                            $scope.couponList = $sessionStorage.couponList; // 体验券列表-未使用
                        }else if(val.status == '2'){
                            $sessionStorage.couponListUsed.push(val);
                            $scope.couponListUsed = $sessionStorage.couponListUsed; // 体验券列表-已使用
                        }
                    });
                    $scope.coupon = $sessionStorage.coupon = $scope.couponList.length; // 体验券总数-未使用
                    $scope.couponUsed = $sessionStorage.couponUsed = $scope.couponListUsed.length; // 体验券总数-已使用
                    console.log($scope.couponList,$scope.couponListUsed);
                    $state.go('wdtyq');
                }
            });
        }else {
            $scope.mPop.err('登录后才能查看体验券')
        }
    };
    $scope.showCoupon = true;
    $scope.showCoupons = function (boolean) {
        $scope.showCoupon = boolean;
    };
    // 使用体验券
    $scope.goTcxq = function (package_id,couponName,coupon_id,code) {
        $sessionStorage.isHascoupon = true;
        $sessionStorage.couponName = couponName; // 体验券名字
          $state.go('tcxq',{
              listId:parseInt(package_id),
              coupon_id:parseInt(coupon_id),
              code:code
          })
    };
    //去往企业绑定
    $scope.goQybd = function () {
        if($sessionStorage.token){
            $state.go('qybd')
        }else {
            $scope.mPop.err('登录后才能查看您绑定的企业')
        }
    };
    $scope.isUserLogin = function () {
        $scope.mPop.err('请登录再修改个人资料')
    };
}]);
