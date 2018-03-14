'use strict';
app.controller('serveDetailDzCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.retainage = $stateParams.retainage;
    $scope.id = $stateParams.id;
    $scope.item = [];
    $scope.totalPrice = '';
    $http.post('/order/order-api/index',{
        token:$sessionStorage.token,
        start_page:0,
        pages:100,
        type:1
    }).success(function (data) {
        var arr = data.data.list;
        angular.forEach(arr,function (val) {
            if(val.id == $scope.id){
                $scope.item = val;
                // console.log(parseInt($scope.item.package.present_price));
                $scope.totalPrice = $sessionStorage.totalPrice = parseInt($scope.retainage) + parseInt($sessionStorage.guidePrice) + parseInt($sessionStorage.fare);
            }
        });
    });
//    选择地址
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
            isLstd:1,
            isDdxq:1
        })
    };


//    选择时间
    $scope.data = $sessionStorage.serveDate;
    // console.log($scope.data);
    $scope.goChooseData = function () {
        $state.go('choose-data',{
            id:$stateParams.id
        })
    };

//    选择体检人
    $scope.familyName = $sessionStorage.familyName;
    $scope.goChooseFamily = function () {
        $sessionStorage.ddxqFamily = true;
        $state.go('family');
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
            console.log(data.data.list)
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
        if($sessionStorage.isHascoupon == true){
            $scope.totalPrice = $sessionStorage.totalPrice = 0
        }else{
            $sessionStorage.totalPrice = parseInt($scope.retainage) + parseInt($sessionStorage.guidePrice) + parseInt($sessionStorage.fare);
            $scope.totalPrice = $sessionStorage.totalPrice;
        }

    };
    // 保存留言信息
    if($sessionStorage.textMsg){
        $scope.textMsg = $sessionStorage.textMsg;
    }else{
        $scope.textMsg = '';
    }
    $scope.saveMsg = function () {
        $sessionStorage.textMsg = $scope.textMsg;
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
    /*$scope.goInvoiceDdxq = function () {
        $scope.showInvoice = false;
        $('.y-serve-xq').show();
        if($sessionStorage.invoice =='有'){
            $sessionStorage.fare = '12.00';
            $scope.fare = $sessionStorage.fare;
        }else if($sessionStorage.invoice =='无'){
            $sessionStorage.fare = '0.00';
            $scope.fare = $sessionStorage.fare;
        }
        if($sessionStorage.isHascoupon == true){
            $scope.totalPrice = $sessionStorage.totalPrice = 0
        }else{
            $scope.totalPrice = $sessionStorage.totalPrice = parseInt($scope.item.package.present_price) + parseInt($scope.retainage) + parseInt($sessionStorage.guidePrice) + parseInt($sessionStorage.fare);
        }
    };*/
    // console.log(parseInt($scope.item.package.present_price));
    /*$scope.totalPrice = $sessionStorage.totalPrice = parseInt($scope.retainage) + parseInt($sessionStorage.guidePrice) + parseInt($sessionStorage.fare);*/
//    生成待付款订单
//     console.log($scope.fullAddress)
    $scope.goPay = function () {
        if($scope.fullAddress == '请选择地址'){
            $scope.mPop.err('请选择地址!')
        }else if($scope.data == '选择时间'){
            $scope.mPop.err('请选择时间!')
        }else if($scope.familyName == '请选择体检人'){
            $scope.mPop.err('请选择体检人!')
        }else if($scope.guideName == '选择导医'){
            $scope.mPop.err('请选择导医!')
        }else{
            $state.go('tjyyPay',{
                id:$stateParams.id,
                isServe:1,
                total_price:$scope.totalPrice
            })
        }
    };
}])
;
