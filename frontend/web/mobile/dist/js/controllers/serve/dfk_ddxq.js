'use strict';
app.controller('serveDfkXqCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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

    $scope.dfkDetail = [];
    getDfk();
    function getDfk() {
        $http.post('/order/order-api/view',{
            token:$sessionStorage.token,
            id:$stateParams.id
        }).success(function (data) {
            $scope.dfkDetail = data.data;
            console.log(data.data)
        });
    }
    //取消订单
    $scope.xQIsShow = false;
    $scope.showChangeXq = function (boo) {
        $scope.xQIsShow = boo;
    };
    $scope.orderDel = function () {
        $http.post('/order/order-api/delete',{
            id: $stateParams.id
        }).success(function () {
            // console.log('订单取消成功');
            getDfk();
            $state.go("layout.mobile.serve.dfk");
        });
    };
}])
;//我的服务-待付款-查看订单详情