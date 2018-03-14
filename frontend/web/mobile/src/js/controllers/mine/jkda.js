'use strict';
app.controller('mineDocCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.daShow = 1;
    $scope.flagGrzl = true;
    $scope.flagShxg = false;
    $scope.flagTjjg = false;
    $scope.showGrzl = function () {
        $scope.goback = 0; //返回个人中心
        $scope.daShow = 1;
        $scope.flagGrzl = true;
        $scope.flagShxg = false;
        $scope.flagTjjg = false;
        $('.y-grzlbj').removeClass('active');
        $('.y-shxgbj').removeClass('active');
    };
    $scope.showShxg = function () {
        //生活习惯列表
        $scope.goback = 0; //返回个人中心
        $scope.daShow = 2;
        $scope.flagGrzl = false;
        $scope.flagShxg = true;
        $scope.flagTjjg = false;
        $('.y-grzlbj').removeClass('active');
        $('.y-shxgbj').removeClass('active');
    };

    $scope.reports = [];
    $scope.showTjjg = function () {
        $scope.goback = 0; //返回个人中心
        $scope.daShow = 3;
        $scope.flagGrzl = false;
        $scope.flagShxg = false;
        $scope.flagTjjg = true;
        $('.y-grzlbj').removeClass('active');
        $('.y-shxgbj').removeClass('active');

        $http.post('/family/family-api/report',{
            token:$sessionStorage.token,
            start_page:0,
            pages:5
        }).success(function (data) {
            if(data.errcode == 0){
                console.log(data);
                $scope.reports = data.data.list;
            }
        });
    };
    $scope.showReport = false;
    $scope.reportImg = '';
    $scope.showReportPic = function (id) {
        // console.log('对应的报告单' + id);
        $http.post('/family/family-api/view',{
            token:$sessionStorage.token,
            id:id
        }).success(function (res) {
            if(res.errcode == 0){
                // console.log(res);
                $('.y-tjjg').fadeOut(500);
                $('.y-r-nav').fadeOut(500);
                $scope.reportImg = res.data.report;
                $scope.showReport = true;
            }
        });
        $scope.isShowReport = function () {
            $scope.showReport=false;
            $('.y-tjjg').fadeIn(500);
            $('.y-r-nav').fadeIn(500);
            /*if($scope.isReadMore == true){
                $('.y-tjjg .y-items').find('.y-old').hide();
            }*/
        }
    };
    // 查看更多报告
    $scope.orderLimit = [];
    // $scope.isReadMore = false; // 是否点击查看更多
    $scope.readMore = function (id,index) {
        $http.post('/family/family-api/index-list',{
            token:$sessionStorage.token,
            start_page:0,
            pages:5,
            id:id
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.isReadMore = true;
                console.log(data);
                $scope.orderLimit = data.data.list[0].order;
            }
        });
    };
    //个人资料信息展示
    $scope.perData = {};//个人资料
    $scope.marriage = ''; //是否已婚

    //根据情况选择开启个人资料编辑或者生活习惯编辑
    //个人资料编辑
    $scope.goback = 0;
    $scope.bj1choose = 0;
    $scope.marriage = '';
    $scope.setBj1 = function (n) {
        $scope.bj1choose = n;
        if($scope.bj1choose == 1){
            $scope.marriage = '已婚';
        }else{
            $scope.marriage = '未婚';
        }
    };

    $scope.grzlDone = function () {
        $http.post('/health/health-api/add',{
            token:$sessionStorage.token,
            height:$('#height').val(),
            weight:$('#weight').val(),
            marriage:parseInt($scope.bj1choose)
        }).success(function () {
            $('.y-grzlbj').removeClass('active');
            $sessionStorage.perData = {};
            $sessionStorage.perData = {
                'height':$('#height').val(),
                'weight':$('#weight').val(),
                'marriage':$scope.marriage
            };
            $scope.perData = $sessionStorage.perData;
            $scope.flagGrzl = true;
        });

    };
    $scope.perData = $sessionStorage.perData;
    //生活习惯编辑
    $scope.bj2choose1 = $scope.bj2choose2 = $scope.bj2choose3 = $scope.bj2choose4 = $scope.bj2choose5 = $scope.bj2choose6 = 0;
    $scope.smoke = '';
    $scope.drunk = '';
    $scope.diet = '';
    $scope.sleep = '';
    $scope.defecation = '';
    $scope.anodyne = '';
    $scope.perHabits = {};
    $scope.setBj2_1 = function (n) {
        $scope.bj2choose1 = n;
        if($scope.bj2choose1 ==1){
            $scope.smoke = '是'
        }else{
            $scope.smoke = '否'
        }
    };
    $scope.setBj2_2 = function (n) {
        $scope.bj2choose2 = n;
        if($scope.bj2choose2 ==1){
            $scope.drunk = '是'
        }else{
            $scope.drunk = '否'
        }
    };
    $scope.setBj2_3 = function (n) {
        $scope.bj2choose3 = n;
        if($scope.bj2choose3 ==1){
            $scope.diet = '是'
        }else{
            $scope.diet = '否'
        }
    };
    $scope.setBj2_4 = function (n) {
        $scope.bj2choose4 = n;
        if($scope.bj2choose4 ==1){
            $scope.sleep = '是'
        }else{
            $scope.sleep = '否'
        }
    };
    $scope.setBj2_5 = function (n) {
        $scope.bj2choose5 = n;
        if($scope.bj2choose5 ==1){
            $scope.defecation = '是'
        }else{
            $scope.defecation = '否'
        }
    };
    $scope.setBj2_6 = function (n) {
        $scope.bj2choose6 = n;
        if($scope.bj2choose6 ==1){
            $scope.anodyne = '是'
        }else{
            $scope.anodyne = '否'
        }
    };
    $scope.shxgDone = function () {
        $http.post('/health/health-api/create',{
            token:$sessionStorage.token,
            smoke:$scope.smoke,
            drunk:$scope.drunk,
            diet:$scope.diet,
            sleep:$scope.sleep,
            defecation:$scope.defecation,
            anodyne:$scope.anodyne
        }).success(function () {
            $('.y-shxgbj').removeClass('active');
            $sessionStorage.perHabits = {};
            $sessionStorage.perHabits = {
                'smoke':$scope.smoke,
                'drunk':$scope.drunk,
                'diet':$scope.diet,
                'sleep':$scope.sleep,
                'defecation':$scope.defecation,
                'anodyne':$scope.anodyne
            };
            $scope.perHabits = $sessionStorage.perHabits;
            $scope.flagShxg = true;
        });
    };
    $scope.perHabits = $sessionStorage.perHabits;
    //选择性开启编辑页面
    $scope.reportBj = function () {
        $scope.flagGrzl = false;
        $scope.flagShxg = false;
        if($scope.daShow == 1){
            $scope.goback = 1;
            $('.y-grzlbj').addClass('active');
        }else if($scope.daShow == 2){
            $scope.goback = 2;
            $('.y-shxgbj').addClass('active');
        }else if($scope.daShow == 3){
            $scope.goback = 0;
        }
    };


    //选择性的返回
    $scope.goMine = function () {
        switch($scope.goback){
            case 0:history.back(); break;
            case 1:
                $('.y-grzlbj').removeClass('active');
                $scope.goback = 0;
                break;
            case 2:
                $('.y-shxgbj').removeClass('active');
                $scope.goback = 0;
                break;
        }
    };
}]);
