'use strict';
app.controller('homeOutpatientPayCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    console.log($sessionStorage.familyId + ' ' + $sessionStorage.mzyyName + ' ' + $sessionStorage.ill_describe);
    $scope.hospital = $stateParams.hospital; //医院
    $scope.department = $stateParams.department; //科室
    $scope.doctor = $stateParams.doctor; //医生
    $scope.hope_time = $stateParams.hope_time; //希望就诊时间
    $scope.sum_price = $stateParams.sum_price; //金额
    $scope.familyName = $stateParams.familyName; //一开始选择的就诊人
//    选择地址
//     if(!$sessionStorage.serve_consignee){
    if($sessionStorage.addressLength == 0){
        $scope.hasAddress = true;
    }else{
        $scope.hasAddress = false;
        if($sessionStorage.addressFlag == true){
            $scope.consignee = $sessionStorage.serve_consignee;
            $scope.tel = $sessionStorage.serve_tel;
            $scope.fullAddress = $sessionStorage.serve_fullAddress;
        }else if($sessionStorage.addressFlag == false){
            $http.post('/address/address-api/view',{
                token:$sessionStorage.token,
                start_page:0,
                pages:10
            }).success(function (data) {
                if(data.errcode == 0){
                    var address = data.data.list;
                    // console.log(address);
                    angular.forEach(address,function (val) {
                        if(val.status == 1){
                            $scope.consignee = $sessionStorage.serve_consignee = val.consignee;
                            $scope.tel = $sessionStorage.serve_tel = val.mobile;
                            $scope.fullAddress = $sessionStorage.serve_fullAddress = val.full_address;
                        }
                    })
                }
            });
        }
    }

    $scope.goChooseAddress = function () {
        $state.go('address',{
            isDdxq:1,
            isLstd:1 // 代表绿色通道
        })
    };

    //    选择导医
    $scope.showGuideDoctor = false;
    $scope.guideDoctor = [];
    $scope.showMask = false;
    $scope.guideName = $sessionStorage.guideName;
    $scope.guidePrice = $sessionStorage.guidePrice;
    $scope.guideIndex = '';
    $scope.chooseGuideDoctor = function () {
        $http.post('/order/exam-guide-api/index',{
            start_page:0,
            pages:5
        }).success(function (data) {
            $scope.guideDoctor = data.data.list;
            $scope.showGuideDoctor = true;
            $scope.showMask = true;
            // console.log(data.data.list)
        });
        $scope.isGuideDoctor = function (index) {
            $scope.guideIndex = index;
            $('.y-g-d-list .y-item').removeClass('active');
            $('.y-g-d-list .y-item').eq(index).addClass('active');
        }
    };
    $scope.closeGuideDoctor = function () {
        $scope.showGuideDoctor = false;
        $scope.showMask = false;
    };
    $scope.okGuideDoctor = function () {
        $sessionStorage.guidePrice = $scope.guideDoctor[$scope.guideIndex].price;
        $scope.guidePrice = $sessionStorage.guidePrice;
        for(var i=0;i<$('.y-g-d-list .y-item').length;i++){
            if($('.y-g-d-list .y-item').eq(i).hasClass('active')){
                $sessionStorage.guideName = $('.y-g-d-list .y-item').eq(i).find('span').eq(0).text();
                $scope.guideName = $sessionStorage.guideName;
            }
        }

        $scope.showGuideDoctor = false;
        $scope.showMask = false;
        $scope.totalPrice = parseInt($scope.sum_price) + parseInt($scope.guidePrice) + parseInt($scope.fare);
    };
    // 保存留言信息
    if($sessionStorage.textMsg){
        $scope.textMsg=$sessionStorage.textMsg;
    }else{
        $scope.textMsg='';
    }
    $scope.saveMsg = function () {
        $sessionStorage.textMsg=$scope.textMsg;
    };
    //发票
    $scope.invoice = $sessionStorage.invoice;
    $scope.fare = $sessionStorage.fare;
    if($sessionStorage.invoice =='有'){
        $sessionStorage.fare = '12.00';
        $scope.fare = $sessionStorage.fare;
    }else if($sessionStorage.invoice =='无'){
        $sessionStorage.fare = '0.00';
        $scope.fare = $sessionStorage.fare;
    }
    //返回订单页面
    $scope.goInvoiceDdxq = function () {
        $scope.showInvoice = false;
        $('.y-serve-xq').show();
        if($scope.invoice =='有'){
            $scope.fare = '12.00';
        }else{
            $scope.fare = '0.00';
        }
        $scope.totalPrice = parseInt($scope.sum_price) + parseInt($scope.guidePrice) + parseInt($scope.fare);
    };

    //总金额
    $scope.totalPrice = parseInt($scope.sum_price) + parseInt($scope.guidePrice) + parseInt($scope.fare);

    //生成待付款订单
    $scope.goPay = function () {
        if($scope.guideName == '选择导医'){
            $scope.mPop.info('请选择导医')
        }else{
            $http.post('/order/order-api/add',{
                token:$sessionStorage.token,
                name:$scope.consignee,
                full_address:$scope.fullAddress,
                tel:$scope.tel,
                is_invoice:$scope.invoice,
                type:1,
                message:$scope.textMsg,
                order_type:3,
                price:parseInt($scope.sum_price),
                fare:parseInt($scope.fare),
                sum_price:parseInt($scope.totalPrice),
                exam_time:$scope.hope_time,
                package_name:'门诊预约',
                exam_people:$scope.familyName,
                hospital:$scope.hospital,
                department:$scope.department,
                doctor:$scope.doctor,
                guider:$scope.guideName,
                guide_price:parseInt($scope.guidePrice),
                is_match:$sessionStorage.is_match,
                family_id:parseInt($sessionStorage.familyId)
            }).success(function (res) {
                if(res.errcode == 0){
                    console.log('订单生成成功');
                    $http.post('/order/order-api/index',{
                        token:$sessionStorage.token,
                        start_page:0,
                        pages:1,
                        type:1
                    }).success(function (data) {
                        if(data.errcode == 0){
                            $scope.dfkList = data;
                            // console.log(data.data.list[0].id);
                            $http.post('/order/order-api/index',{
                                token:$sessionStorage.token,
                                start_page:0,
                                pages:20,
                                type:0
                            }).success(function (data) {
                                if(data.errcode == 0){
                                    $scope.allTotal_pages = data.data.total_pages;
                                    $sessionStorage.serveList = data.data.list;
                                }
                            });
                            $state.go('tjyyPay',{
                                id:data.data.list[0].id
                            });
                        }
                    });
                }
            });
        }
    };
}])
;