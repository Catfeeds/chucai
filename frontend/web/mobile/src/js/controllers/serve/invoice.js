'use strict';
app.controller('invoiceCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    if($sessionStorage.invoice == '有'){
        $('.y-i-flag span:eq(1)').addClass('active');
    }else{
        $('.y-i-flag span:eq(1)').removeClass('active');
    }
    $scope.invoice = $sessionStorage.invoice;
    $scope.invoiceFlag = function () {
        if($sessionStorage.invoice == '有'){
            $('.y-i-flag span:eq(1)').removeClass('active');
            $sessionStorage.invoice = '无';
            $scope.invoice = $sessionStorage.invoice;
        }else{
            $('.y-i-flag span:eq(1)').addClass('active');
            $sessionStorage.invoice = '有';
            $scope.invoice = $sessionStorage.invoice;
        }
    };
    $scope.con = $sessionStorage.invoiceHeader;
    $scope.invoiceCon = function (con) {
        $scope.con = $sessionStorage.invoiceHeader = con;
    }
}])
;