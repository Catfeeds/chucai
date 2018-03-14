'use strict';
app.controller('homeOutpatientPay1Ctrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.hospital = $stateParams.hospital; //医院
    $scope.department = $stateParams.department; //科室
    $scope.hope_time = $stateParams.date; //希望就诊时间
    $scope.sum_price = $stateParams.sum_price; //金额
    $scope.familyName = $stateParams.familyName; //一开始选择的就诊人
    $scope.totalPrice = parseInt($sessionStorage.sum_price) + parseInt($sessionStorage.guidePrice) + parseInt($sessionStorage.fare);
    console.log( '服务金额：' + $scope.servePrice);
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
            isDdxq:1
        })
    };

    //    选择导医
    $scope.showGuideDoctor = false;
    $scope.guideDoctor = [];
    $scope.showMask = false;
    $scope.guideName = $sessionStorage.guideName;
    $scope.guideIndex = '';
    $scope.guidePrice = $sessionStorage.guidePrice; //导医价格
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
            }
        }
        $scope.guideName = $sessionStorage.guideName;
        $scope.showGuideDoctor = false;
        $scope.showMask = false;
        $scope.totalPrice = parseInt($stateParams.sum_price) + parseInt($sessionStorage.guidePrice) + parseInt($scope.fare);
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
        $scope.totalPrice = parseInt($stateParams.sum_price) + parseInt($sessionStorage.guidePrice) + parseInt($scope.fare);
    };

    //总金额

    $scope.totalPrice = parseInt($stateParams.sum_price) + parseInt($sessionStorage.guidePrice) + parseInt($scope.fare);

    //生成待付款订单
    $scope.packageName = '';
    if($sessionStorage.shap == true){
        $scope.packageName = '手术安排'
    }else if($sessionStorage.shap == false){
        $scope.packageName = '住院安排'
    }
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
                price:parseInt($scope.servePrice),
                fare:parseInt($scope.fare),
                sum_price:parseInt($scope.totalPrice),
                exam_time:$scope.hope_time,
                package_name:$scope.packageName,
                exam_people:$scope.familyName,
                hospital:$scope.hospital,
                department:$scope.department,
                doctor:$scope.doctor,
                guider:$scope.guideName,
                guide_price:parseInt($scope.guidePrice),
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
                        $scope.dfkList = data;
                        // console.log(data.data.list[0].id);
                        $state.go('tjyyPay',{
                            id:data.data.list[0].id
                        });
                    });
                }
            });
        }
    };
}])