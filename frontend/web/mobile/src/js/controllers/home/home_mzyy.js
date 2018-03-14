'use strict';
app.controller('homeMzyyCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    // 服务金额
    $scope.service_price = $sessionStorage.service_price;
    $http.post('/personal/customiz-api/index',{
        token:$sessionStorage.token,
        start_page:0,
        pages:5
    }).success(function (data) {
        if(data.errcode == 0){
            // console.log(data.data.list);
            $scope.service_price =$sessionStorage.service_price = data.data.list[0].service_price;
            $scope.sum_price = $sessionStorage.sum_price = parseInt($sessionStorage.famousDoctor) + parseInt($sessionStorage.service_price) + parseInt($sessionStorage.isRareDoctor);
        }
    });

    $scope.chooseSrc = 'img/home/circle.png';
    $scope.unchooseSrc = 'img/home/uncircle.png';
    $scope.famousDoctor = $sessionStorage.famousDoctor;
    console.log($sessionStorage.familyId + ' ' + $sessionStorage.mzyyName + ' ' + $sessionStorage.ill_describe);
    console.log($scope.sum_price);
    if($sessionStorage.famousDoctor == 0){
        $scope.chooseSrc = 'img/home/circle.png';
        $scope.unchooseSrc = 'img/home/uncircle.png';
        $scope.showDoctor = false;
        $sessionStorage.is_match = 1; //不匹配
    }else if($sessionStorage.famousDoctor == 500){
        $scope.chooseSrc = 'img/home/uncircle.png';
        $scope.unchooseSrc = 'img/home/circle.png';
        $scope.showDoctor = true;
        $sessionStorage.is_match = 2; //瑞梅精准匹配
    }
    $scope.choose1 = function () {
        $scope.showSearch = false; //搜索界面消失
        $scope.isRareDoctor = $sessionStorage.isRareDoctor = 0;
        $scope.chooseSrc = 'img/home/circle.png';
        $scope.unchooseSrc = 'img/home/uncircle.png';
        $scope.showDoctor = false;
        $sessionStorage.is_match = 1;
        $sessionStorage.famousDoctor = 0;
        $scope.famousDoctor = $sessionStorage.famousDoctor;
        $scope.sum_price = $sessionStorage.sum_price = parseInt($sessionStorage.famousDoctor) + parseInt($sessionStorage.service_price);
    };
    $scope.choose2= function () {
        $scope.chooseSrc = 'img/home/uncircle.png';
        $scope.unchooseSrc = 'img/home/circle.png';
        $scope.showDoctor = true;
        $sessionStorage.is_match = 2;
        $sessionStorage.famousDoctor = $sessionStorage.service_price;
        $scope.famousDoctor = $sessionStorage.famousDoctor;
        $scope.sum_price = $sessionStorage.sum_price = parseInt($sessionStorage.famousDoctor) + parseInt($sessionStorage.service_price) + parseInt($sessionStorage.isRareDoctor);
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
            // console.log( $scope.proHospital);
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
        $sessionStorage.h_id = $scope.detailHospital[index].id;
        //生成医院对应科室
        $http.post('/appoint/hospital-api/view',{
            start_page: 0,
            pages: 5,
            id:$scope.detailHospital[index].id
        }).success(function (data) {
            $scope.detailKs = [];
            $scope.detailDoctor = []; //更换医院时清空上一次选择的科室和医生
            $scope.detailKs = data.data.list[0].departments;
            // console.log($scope.detailKs)
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
            $sessionStorage.d_id = $scope.detailKs[index].id;
            //选择医生
            $http.post('/appoint/doctor-api/view',{
                start_page: 0,
                pages: 5,
                h_id:$sessionStorage.h_id,
                d_id:$scope.detailKs[index].id
            }).success(function (data) {
                // console.log(data.data.list);
                $scope.detailDoctor = data.data.list;
                $scope.doctorChoose = -1;
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

    //选择医生
    $scope.showDoctors = false;
    $scope.doctor = $sessionStorage.doctorVal;
    $scope.doctorOkFlag = false;
    $scope.doctorChoose = -1;
    $scope.isRareDoctor = $sessionStorage.isRareDoctor;
    $scope.showChooseDoctor = function () {
        $scope.showMask = true;
        $scope.showDoctors = true;
    };
    $scope.doctorCancle = function () {
        $scope.showMask = false;
        $scope.showDoctors = false;
    };
    $scope.chooseDoctor = function (index) {
        $scope.doctorChoose = index;
        $scope.doctorOkFlag = true;
        // console.log($scope.detailDoctor);
        angular.forEach($scope.detailDoctor,function (val) {
            if($('.y-m-choose-doctor .y-con .y-c-item').eq(index).text() == val.name){
                if(val.is_rare == 1){
                    $scope.isRareDoctor = $sessionStorage.isRareDoctor = 400;
                }else if(val.is_rare == 2){
                    $scope.isRareDoctor = $sessionStorage.isRareDoctor = 0;
                }
            }
        })
    };
    $scope.doctorOk = function () {
        if($scope.doctorOkFlag == true){
            for(var i=0;i<$('.y-m-choose-doctor .y-con .y-c-item').length;i++){
                if($('.y-m-choose-doctor .y-con .y-c-item').eq(i).hasClass('active')){
                    $sessionStorage.doctorVal = $('.y-m-choose-doctor .y-con .y-c-item').eq(i).text();
                }
            }
            $scope.doctor = $sessionStorage.doctorVal;
            $scope.showMask = false;
            $scope.showDoctors = false;
        }
        $scope.sum_price = $sessionStorage.sum_price = parseInt($sessionStorage.famousDoctor) + parseInt($sessionStorage.service_price) + parseInt($sessionStorage.isRareDoctor);
    };



    //名医搜索
    $scope.doctorLists = [];
    $scope.showSearch = false;
    function serchDoc() {
        $http.post('/appoint/doctor-api/search',{
            name:$('#searchDoc').val(),
            start_page:0,
            pages:5
        }).success(function (data) {
            console.log(data.data.list);
            $scope.doctorLists = data.data.list;
        })
    }
    $scope.searchDoctorAll = function () {
        serchDoc();
        $scope.showSearch = true;
    };
    $scope.searchDoctor = function () {
        serchDoc();
        $scope.showSearch = true;
    };
    $scope.chooseSearchDoctor = function (index) {
        $sessionStorage.hospitalVal = $scope.doctorLists[index].hospital.name;
        $scope.hospital = $sessionStorage.hospitalVal;
        $scope.ks = $sessionStorage.ksVal = $scope.doctorLists[index].department.name;
        $scope.doctor = $sessionStorage.doctorVal = $scope.doctorLists[index].name;
        if($scope.doctorLists[index].is_rare == 1){
            $sessionStorage.isRareDoctor = 400;
            $scope.isRareDoctor = $sessionStorage.isRareDoctor;
            $scope.sum_price = $sessionStorage.sum_price = parseInt($sessionStorage.famousDoctor) + parseInt($sessionStorage.service_price) + parseInt($sessionStorage.isRareDoctor);
        }else if($scope.doctorLists[index].is_rare == 2){
            $sessionStorage.isRareDoctor = 0;
            $scope.isRareDoctor = $sessionStorage.isRareDoctor;
            $scope.sum_price = $sessionStorage.sum_price = parseInt($sessionStorage.famousDoctor) + parseInt($sessionStorage.service_price) + parseInt($sessionStorage.isRareDoctor);
        }
        $scope.showSearch = false;

    };
    //去往确认订单
    $scope.goOutpatientPay = function () {
        console.log('is_match:' + $sessionStorage.is_match);
        if($sessionStorage.is_match == 1){
            if($sessionStorage.date == '选择时间'){
                $scope.mPop.err('请选择时间');
            }else{
                $state.go('outpatient_pay',{
                    hospital:'待定制',
                    department:'待定制',
                    doctor:'待定制',
                    hope_time:$scope.date,
                    sum_price:$scope.sum_price,
                    familyName:$sessionStorage.mzyyName
                })
            }
        }else if($sessionStorage.is_match == 2){
            if($sessionStorage.hospitalVal == '选择医院' || $sessionStorage.ksVal == '选择科室' || $sessionStorage.doctorVal == '选择医生' || $sessionStorage.date == '选择时间'){
                $scope.mPop.err('请选择完整再下单');
            }else{
                $state.go('outpatient_pay',{
                    hospital:$scope.hospital,
                    department:$scope.ks,
                    doctor:$scope.doctor,
                    hope_time:$scope.date,
                    sum_price:$scope.sum_price,
                    familyName:$sessionStorage.mzyyName
                })
            }
        }

    };
}])
;