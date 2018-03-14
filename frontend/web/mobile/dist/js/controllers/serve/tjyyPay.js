'use strict';
app.controller('tjyyPayCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.total_price = $stateParams.total_price; // 个性化配置总价
    $scope.payDetail = []; //收银台简要
    $http.post('/order/order-api/show',{
        token:$sessionStorage.token,
        id:$stateParams.id
    }).success(function (data) {
        $scope.payDetail = data.data[0];
        // console.log($scope.payDetail)
    });



    $scope.goPay = function () {
        console.log($stateParams.code);
        if(!$stateParams.code){
            $http.post('/wechat/pay-api/make-pay',{
                token:$sessionStorage.token,
                order_number:$scope.payDetail.order_number,
                family_id:parseInt($sessionStorage.familyId),
                name:$sessionStorage.serve_consignee,
                full_address:$sessionStorage.serve_fullAddress,
                tel:$sessionStorage.serve_tel,
                exam_time:$sessionStorage.serveDate,
                exam_people:$sessionStorage.familyName,
                guide_price:parseInt($sessionStorage.guidePrice),
                fare:parseInt($sessionStorage.fare),
                sum_price:parseInt($stateParams.total_price),
                guider:$sessionStorage.guideName,
                message:$sessionStorage.textMsg,
                is_invoice:$sessionStorage.invoice
            }).success(function (res) {
                if(res.errcode == 0){
                    $scope.payMsg = {
                        appid:res.data.jsApiConfig.appid,
                        noncestr:res.data.jsApiConfig.noncestr,
                        package:res.data.jsApiConfig.package,
                        partnerid:res.data.jsApiConfig.partnerid,
                        prepayid:res.data.jsApiConfig.prepayid,
                        sign:res.data.jsApiConfig.sign,
                        timestamp:res.data.jsApiConfig.timestamp
                    };
                    var appid = $scope.payMsg.appid,
                        noncestr = $scope.payMsg.noncestr,
                        packageg = $scope.payMsg.package,
                        partnerid = $scope.payMsg.partnerid,
                        prepayid = $scope.payMsg.prepayid,
                        sign = $scope.payMsg.sign,
                        timestamp = $scope.payMsg.timestamp;
                    var payMsg = {
                        body:{
                            appid:appid,
                            noncestr:noncestr,
                            packageg:packageg,
                            partnerid:partnerid,
                            prepayid:prepayid,
                            sign:sign,
                            timestamp:timestamp
                        }
                    };
                    var u = navigator.userAgent;
                    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
                    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
                    //getSureToken是函数名
                    if(isiOS){
                        if(window.webkit){
                            window.webkit.messageHandlers.getPay.postMessage(payMsg);
                            /*if($sessionStorage.tcdzFlag == true){
                             $state.go('layout.mobile.serve.dfk');
                             }else{
                             $state.go('layout.mobile.serve.yfk');
                             }*/
                        }
                    }else{
                        if(window.App){
                            window.App.getPay(appid,noncestr,packageg,partnerid,prepayid,sign,timestamp);
                            /*if($sessionStorage.tcdzFlag == true){
                             $state.go('layout.mobile.serve.dfk');
                             }else{
                             $state.go('layout.mobile.serve.yfk');
                             }*/
                        }
                    }
                    $timeout(function () {
                        $state.go('layout.mobile.serve.all');
                    },2000)
                }
            });
        }else {
            $http.post('/wechat/pay-test/call-back',{
                token:$sessionStorage.token,
                order_number:$scope.payDetail.order_number,
                code:$stateParams.code
            }).success(function (res) {
                if(res.errcode == 0) {
                    $state.go('layout.mobile.serve.ywc')
                }
            })
        }

    };
    //    支付完成
    /*$http.post('/wechat/pay-api/call-back',{
        token:$sessionStorage.token
    }).success(function (res) {
        /!*if($sessionStorage.tcdzFlag == true){
         $state.go('layout.mobile.serve.dfk');
         }else{
         $state.go('layout.mobile.serve.yfk');
         }
         console.log(data);*!/
        if(res==true){
            $state.go('layout.mobile.serve.all');
        }
    });*/
//    返回
    $scope.goToBack = function () {
        if(parseInt($stateParams.isServe) == 1){
            history.go(-1)
        }else{
            $state.go('layout.mobile.home')
        }
    }
}])
;