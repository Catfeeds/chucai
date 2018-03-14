'use strict';
app.controller('homeZyapCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.chooseSrc = 'img/home/circle.png';
    $scope.unchooseSrc = 'img/home/uncircle.png';
    $scope.famousDoctor = $sessionStorage.famousDoctor;
    $sessionStorage.sum_price = $sessionStorage.famousDoctor + 400;
    $scope.sum_price = $sessionStorage.sum_price;
    console.log($sessionStorage.familyId + ' ' + $sessionStorage.mzyyName + ' ' + $sessionStorage.ill_describe);
    if($sessionStorage.famousDoctor == 0){
        $scope.chooseSrc = 'img/home/circle.png';
        $scope.unchooseSrc = 'img/home/uncircle.png';
        $scope.showDoctor = false;
        $sessionStorage.is_match = 1; //不匹配
    }else if($sessionStorage.famousDoctor == 400){
        $scope.chooseSrc = 'img/home/uncircle.png';
        $scope.unchooseSrc = 'img/home/circle.png';
        $scope.showDoctor = true;
        $sessionStorage.is_match = 2; //瑞梅精准匹配
    }
    $scope.sum_price = $sessionStorage.sum_price; //总价
    $scope.choose1 = function () {
        $scope.chooseSrc = 'img/home/circle.png';
        $scope.unchooseSrc = 'img/home/uncircle.png';
        $scope.showDoctor = false;
        $sessionStorage.is_match = 1;
        $sessionStorage.famousDoctor = 0;
        $scope.famousDoctor = $sessionStorage.famousDoctor;
        $sessionStorage.sum_price = $sessionStorage.famousDoctor + 400;
        $scope.sum_price = $sessionStorage.sum_price;
    };
    $scope.choose2= function () {
        $scope.chooseSrc = 'img/home/uncircle.png';
        $scope.unchooseSrc = 'img/home/circle.png';
        $scope.showDoctor = true;
        $sessionStorage.is_match = 2;
        $sessionStorage.famousDoctor = 400;
        $scope.famousDoctor = $sessionStorage.famousDoctor;
        $sessionStorage.sum_price = $sessionStorage.famousDoctor + 400;
        $scope.sum_price = $sessionStorage.sum_price;
    };
    //选择就诊时间
    $scope.date = $sessionStorage.date;
    $scope.showChooseTime = function () {
        $scope.showMask = true;
    };
    $scope.setChoose = function (n) {
        $scope.choose = n;
    };
    $('.y-m-choose-time').find('.y-c-item').click(function () {
        $sessionStorage.date = $(this).text();
        $scope.date = $sessionStorage.date;
    });
    $scope.cancle = function () {
        $scope.showMask = false;
    };
    $scope.ok = function () {
        $scope.showMask = false;
    };


    //选择医院
    $scope.showHospital = false;
    $scope.hospital = $sessionStorage.hospitalVal;
    $scope.hospitalOkFlag = false;
    $scope.proHospital = []; //医院所在市
    $scope.detailHospital = []; //市对应的医院
    $scope.detailKs = []; //医院对应的科室

    $scope.showChooseHospital = function () {
        $scope.chooseColor = 0;
        //选择医院所在市
        $http.post('/appoint/hospital-api/index',{
            start_page: 0,
            pages: 10
        }).success(function (data) {
            $scope.proHospital = data.data;
            console.log( $scope.proHospital);
            $scope.chooseColor1 = -1;
            //默认显示第一个市的医院列表
            $('.y-m-choose-hospital').find('.y-c-detail').show();
            $http.post('/base/district-option-api/hospital',{
                start_page: 0,
                pages: 50,
                id:$scope.proHospital[0].id
            }).success(function (data) {
                $scope.detailHospital = data.data.list[0].hospital;
            });
        });
        $scope.showMask = true;
        $scope.showHospital = true;
    };

    //选择市
    $scope.chooseDetailHospital = function (index) {
        $scope.chooseColor = index;
        $scope.chooseColor1 = -1;
        $http.post('/base/district-option-api/hospital',{
            start_page: 0,
            pages: 50,
            id:$scope.proHospital[index].id
        }).success(function (data) {
            $scope.detailHospital = data.data.list[0].hospital;
            console.log($scope.detailHospital)
        });
    };
    //选择市所对应的特定医院
    $scope.chooseDetailHospitalColor = function (index) {
        $scope.ks = '选择科室';
        $scope.doctor = '选择医生';
        $scope.hospitalOkFlag = true;
        $scope.chooseColor1 = index;
        //生成医院对应科室
        $http.post('/appoint/hospital-api/view',{
            start_page: 0,
            pages: 5,
            id:$scope.detailHospital[index].id
        }).success(function (data) {
            $scope.detailKs = [];
            $scope.detailDoctor = []; //更换医院时清空上一次选择的科室和医生
            $scope.detailKs = data.data.list[0].departments;
            console.log($scope.detailKs)
        });
    };

    $scope.hospitalCancle = function () {
        $scope.showMask = false;
        $scope.showHospital = false;
    };
    $scope.hospitalOk = function () {
        if($scope.hospitalOkFlag == true){
            for(var i=0;i<$('.y-c-detail span').length;i++){
                if($('.y-c-detail span').eq(i).hasClass('active')){
                    $sessionStorage.hospitalVal = $('.y-c-detail span').eq(i).text()
                }
            }
            $scope.hospital = $sessionStorage.hospitalVal;
            $scope.showMask = false;
            $scope.showHospital = false;
        }
    };
    //选择科室
    $scope.showKs = false;
    $scope.ks = $sessionStorage.ksVal;
    $scope.ksOkFlag = false;
    $scope.detailDoctor = []; //科室对应的医生列表
    $scope.showChooseKs = function () {
        $scope.ksChoose = -1;
        $scope.showMask = true;
        $scope.showKs = true;
        //科室选择
        $scope.chooseKs = function (index) {
            $scope.doctor = '选择医生';
            $scope.ksOkFlag = true;
            $scope.ksChoose = index;
            //选择医生
            $http.post('/appoint/appoint-doctor-api/view',{
                start_page: 0,
                pages: 5,
                upid:$scope.detailKs[index].id
            }).success(function (data) {
                // console.log(data.data)
                $scope.detailDoctor = data.data;
            });
        }
    };
    $scope.ksCancle = function () {
        $scope.showMask = false;
        $scope.showKs = false;
    };
    $scope.ksOk = function () {
        if($scope.ksOkFlag == true){
            for(var i=0;i<$('.y-m-choose-ks .y-con .y-c-item').length;i++){
                if($('.y-m-choose-ks .y-con .y-c-item').eq(i).hasClass('active')){
                    $sessionStorage.ksVal = $('.y-m-choose-ks .y-con .y-c-item').eq(i).text();
                }
            }
            $scope.ks = $sessionStorage.ksVal;
            $scope.showMask = false;
            $scope.showKs = false;
        }
    };

    //去往确认订单
    $scope.goOutpatientPay = function () {
        console.log('is_match:' + $sessionStorage.is_match);
        if($sessionStorage.is_match == 1){
            if($sessionStorage.date == '选择时间'){
                $scope.mPop.err('请选择时间');
            }else{
                $state.go('outpatient_pay_zyap',{
                    hospital:'带定制',
                    department:'带定制',
                    doctor:'带定制',
                    hope_time:$scope.date,
                    sum_price:$scope.sum_price,
                    familyName:$sessionStorage.mzyyName
                })
            }
        }else if($sessionStorage.is_match == 2){
            if($sessionStorage.hospitalVal == '选择医院' || $sessionStorage.ksVal == '选择科室' || $sessionStorage.date == '选择时间'){
                $scope.mPop.err('请选择完整再下单');
            }else{
                $sessionStorage.guideName = '选择导医';
                $sessionStorage.guidePrice = 0;
                $sessionStorage.invoice = '无';
                $state.go('outpatient_pay_zyap',{
                    sum_price:$scope.sum_price,
                    familyName:$sessionStorage.mzyyName,
                    hospital:$scope.hospital,
                    department:$scope.ks,
                    date:$scope.date
                })
            }

        }
    };
}]);
