'use strict';
app.controller('homeTcdz5Ctrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.userName = '';
    $http.post('/ruiuser/user-api/view',{
        token:$sessionStorage.token
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.userName = data.data.name;
        }
    });


    $scope.deposit = ''; //定金
    $scope.sum_price = ''; //总价
    $http.post('/personal/customiz-api/index',{
        token:$sessionStorage.token,
        start_page:0,
        pages:5
    }).success(function (data) {
        if(data.errcode == 0){
            // console.log(data.data.list);
            $scope.deposit = data.data.list[0].deposit;
            $scope.sum_price = $scope.deposit
        }
    });



    //生成待付款订单
    $scope.goPay = function () {
        $http.post('/order/order-api/add',{
            token:$sessionStorage.token,
            type:1,
            order_type:2,
            deposit:$scope.deposit,
            sum_price:$scope.sum_price,
            exam_people:$scope.userName,
            package_name:'个性化定制',
            tel:$sessionStorage.userTel
        }).success(function (data) {
            if(data.errcode == 0){
                $http.post('/order/order-api/index',{
                    token:$sessionStorage.token,
                    start_page:0,
                    pages:1,
                    type:1
                }).success(function (data) {
                    if(data.errcode == 0){
                        // 服务板块-全部
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
                        $sessionStorage.tcdzFlag = true;
                        $state.go('tjyyPay',{
                            id:data.data.list[0].id
                        });
                    }
                });
            }
        });
    }
}])