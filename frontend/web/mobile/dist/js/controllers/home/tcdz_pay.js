'use strict';
app.controller('tcdzPayCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.payDetail = []; //收银台简要
    $http.post('/order/order-api/show',{
        token:$sessionStorage.token,
        id:$stateParams.id
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.payDetail = data.data[0];
            console.log($scope.payDetail)
        }
    });


//    支付
    $scope.goPay = function () {
        $http.post('/wechat/pay-test/call-back',{
            token:$sessionStorage.token,
            order_number:$scope.payDetail.order_number
        }).success(function (data) {
            console.log(data)
        });
    }
}])