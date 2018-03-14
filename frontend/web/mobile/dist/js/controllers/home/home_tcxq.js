'use strict';
app.controller('homeTcxqCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.package = [];
    $scope.sex = '';
    $scope.tjList = [];
    $scope.maskShow = false;
    $scope.list_id = '';//套餐id
    $http.post('/package/package-api/view',{
        id: $stateParams.listId
    }).success(function (data) {
        switch (parseInt(data.data[0].sex)){ //// 套餐适用性别
            case 1:$sessionStorage.adaptSex = '男';break;
            case 2:$sessionStorage.adaptSex = '女';break;
            case 3:$sessionStorage.adaptSex = '不限';break;
        }
        $sessionStorage.adaptPeople = data.data[0].adapt_people; // 套餐适用人群
        $sessionStorage.adaptAddress = data.data[0].adapt_region; // 套餐适用地区
        $scope.list_id = $stateParams.listId;
        $scope.package = data.data[0];
        // console.log($scope.package);
        if($scope.package.sex == 1){
            $scope.sex = '仅限男士使用';
        }else if($scope.package.sex == 2){
            $scope.sex = '仅限女士使用';
        }else if($scope.package.sex == 3){
            $scope.sex = '不限';
        }
        $scope.tjList = $scope.package.content;
        console.log($scope.tjList);
    });
    // 是否可以预约打电话
    $scope.serveFlag = $stateParams.serveFlag;
    //电话咨询
    $scope.showTel = function () {
        $scope.maskShow = true;
    };
    $scope.cancle = function () {
        $scope.maskShow = false;
    };
    $scope.telTo = function () {
        location.href = 'tel://' + $scope.package.tel;
    };

    // 是否使用体验券
    $scope.isHascoupon = $sessionStorage.isHascoupon;
    $scope.couponName = $sessionStorage.couponName;
    //    前往订单详情
    $scope.goDdxq = function () {
        $sessionStorage.familyName = '请选择体检人'; //清空订单详情页的体检人名字
        $sessionStorage.invoice = '无'; //默认没有发票
        $sessionStorage.fare = '0.00'; //默认无发票
        $sessionStorage.guideName = '选择导医'; //默认无导医
        $sessionStorage.guidePrice = '0.00'; //默认无导医
        $sessionStorage.serveDate = '选择时间'; //默认无时间
        $sessionStorage.addressFlag = false; //默认地址
        //登录验证
        $sessionStorage.toState.name='ddxq';
        $sessionStorage.toState.type=3;
        $sessionStorage.toState.id=$scope.list_id;
        if(!$sessionStorage.token){
            $state.go('login');
        }else{
            $state.go($sessionStorage.toState.name,{id:$scope.list_id,coupon_id:$stateParams.coupon_id,code:$stateParams.code});
        }
    }
}]);
