'use strict';
app.controller('homeCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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

    $rootScope.changeNavH(); // 是否有ios状态栏
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
                    return 0;
                }else if(val.is_read==2){
                    $scope.isRead = false;
                }
            })
        }
    });
    $rootScope.baseOption.active=1;
    $scope.myInterval = 2000;
    //药店推荐列表
    $scope.pharmacyRecommend = [];
    $http.post('/drugstore/drugstore-api/view',{
        start_page: 0,
        pages: 5
    }).success(function (data) {
        $scope.pharmacyRecommend = data.data.list;
    });
    //banner图
    $scope.bannerList = [];
    $http.post('/banner/banner-api/index',{
        start_page:0,
        pages:10
    })
        .success(function (data) {
            if(data.errcode==0){
                $scope.bannerList = data.data.list;
                // console.log($scope.bannerList)
            }
        });
    // 体检预约
    $scope.goTjyy = function () {
        $http.post('/institution/institution-api/index',{
            start_page: 0,
            pages: 20
        }).success(function (data) {
            if(data.errcode == 0){
                $sessionStorage.institutionList = data.data.list;
                $state.go('tjyy');
            }
        });
    };
    //绿色通道
    //    门诊预约
    $scope.goChooseFamily = function () {
        $sessionStorage.famousDoctor = 0; //默认不选择指定名医
        $sessionStorage.ill_describe = '';
        $sessionStorage.ddxqFamily = false;
        $sessionStorage.isRareDoctor = 0; //稀有名医为空
        $sessionStorage.service_price = 0;
        $sessionStorage.date = '选择时间';
        $sessionStorage.hospitalVal = '选择医院';
        $sessionStorage.invoice = '无';
        $sessionStorage.ksVal = '选择科室';
        $sessionStorage.doctorVal = '选择医生';
        $sessionStorage.guideName = '选择导医';
        //登录验证
        $sessionStorage.toState.name='family';
        $sessionStorage.toState.type=1;
        if(!$sessionStorage.token){
            $state.go('login',{from:$state.current.name,w:JSON.stringify($stateParams)});
        }else{
            $state.go($sessionStorage.toState.name,{'chooseFamily':1});
        }
    };
    //住院安排
    $scope.goChooseFamily1 = function () {
        $sessionStorage.famousDoctor = 0; //默认不选择指定名医
        $sessionStorage.shap = false; //是否是手术安排
        $sessionStorage.ill_describe = '';
        $sessionStorage.guideName = '';
        $sessionStorage.guidePrice = 0;
        $sessionStorage.invoice = '无';
        $sessionStorage.doctorVal = '';
        $sessionStorage.ddxqFamily = false;
        $sessionStorage.date = '选择时间';
        $sessionStorage.hospitalVal = '选择医院';
        $sessionStorage.ksVal = '选择科室';
        $sessionStorage.guideName = '选择导医';
        //登录验证
        $sessionStorage.toState.name='family';
        $sessionStorage.toState.type=2;
        if(!$sessionStorage.token){
            $state.go('login');
        }else{
            $state.go($sessionStorage.toState.name,{'chooseFamily':2});
        }
    };
    //手术安排
    $scope.goChooseFamily2 = function () {
        $sessionStorage.famousDoctor = 0; //默认不选择指定名医
        $sessionStorage.shap = true; //是否是手术安排
        $sessionStorage.ill_describe = '';
        $sessionStorage.guideName = '';
        $sessionStorage.guidePrice = 0;
        $sessionStorage.invoice = '无';
        $sessionStorage.doctorVal = '';
        $sessionStorage.ddxqFamily = false;
        $sessionStorage.date = '选择时间';
        $sessionStorage.hospitalVal = '选择医院';
        $sessionStorage.ksVal = '选择科室';
        //登录验证
        $sessionStorage.toState.name='family';
        $sessionStorage.toState.type=2;
        if(!$sessionStorage.token){
            $state.go('login');
        }else{
            $state.go($sessionStorage.toState.name,{'chooseFamily':3});
        }
    };
    //    去往个性化
    $scope.goGxh = function () {
        $sessionStorage.toState.name='gxh';
        //登录验证
        if(!$sessionStorage.token){
            $state.go('login');
        }else{
            $state.go($sessionStorage.toState.name);
        }
    };
    //    去往在线咨询
    $scope.goQuestion = function () {
        $sessionStorage.toState.name='online_question';
        if(!$sessionStorage.token){
            $state.go('login');
        }else{
            $state.go($sessionStorage.toState.name);
        }
    };

//    滚动监听
    $scope.isScroll = false;
    $('.scroll-content').scroll(function () {
        if($('.scroll-content').scrollTop() > 20 ){
            $scope.isScroll = true;
        }else if($('.scroll-content').scrollTop() < 20 ){
            $scope.isScroll = false;
        }
    })
}])
;