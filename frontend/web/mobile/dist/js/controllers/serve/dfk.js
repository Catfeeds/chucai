'use strict';
app.controller('serveDfkCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $rootScope.baseOption.active=3;
    $rootScope.baseOption.serveIsShow=2;

    $scope.dfkList = []; // 待付款列表
    $scope.start_page = 0;
    $scope.total_pages = '';
    $http.post('/order/order-api/index',{
        token:$sessionStorage.token,
        start_page:$scope.start_page,
        pages:20,
        type:1
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.total_pages = data.data.total_pages;
            $scope.dfkList = data.data.list;
        }else if(data.errcode == 9999){
            $scope.mPop.err('该账号已在别处登录，请重新登录');
            $timeout(function () {
                $state.go('login')
            },2000)
        }
    });
    // 获取更多订单
    $scope.getMore = function () {
        $scope.start_page += 1;
        $http.post('/order/order-api/index',{
            token:$sessionStorage.token,
            start_page:$scope.start_page,
            pages:20,
            type:0
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.dfkList = $scope.dfkList.concat(data.data.list);
            }else if(data.errcode == 9999){
                $scope.mPop.err('该账号已在别处登录，请重新登录');
                $timeout(function () {
                    $state.go('login')
                },2000)
            }
        });
    };
    //去往订单详情页面
    $scope.goXq = function (index) {
        // console.log($scope.dfkList[index])
        if($scope.dfkList[index].order_type == 1){
            $state.go('ddxq1',{
                id:$scope.dfkList[index].id,
                item:$scope.dfkList[index]
            })
        }else if($scope.dfkList[index].package_name == '门诊预约'){
            $state.go('ddxq2',{
                id:$scope.dfkList[index].id,
                item:$scope.dfkList[index]
            })
        }else if($scope.dfkList[index].package_name == '住院安排'){
            $state.go('ddxq3',{
                id:$scope.dfkList[index].id,
                item:$scope.dfkList[index]
            })
        }else if($scope.dfkList[index].package_name == '手术安排'){
            $state.go('ddxq3',{
                id:$scope.dfkList[index].id,
                item:$scope.dfkList[index]
            })
        }else if($scope.dfkList[index].order_type == 2){
            if($scope.dfkList[index].type == 1 || $scope.dfkList[index].type == 10) {
                $state.go('ddxq4',{
                    id:$scope.dfkList[index].id,
                    item:$scope.dfkList[index]
                })
            }else if($scope.dfkList[index].type == 9) {
                $state.go('ddxq4_undone',{
                    id:$scope.dfkList[index].id,
                    item:$scope.dfkList[index]
                })
            }
        }
    };
//    去支付
    $scope.goToZf = function (id,type,retainage) {
        if(type!=10){
            if(type == 9){
                $sessionStorage.familyName = '请选择体检人'; //清空订单详情页的体检人名字
                $sessionStorage.invoice = '无'; //默认没有发票
                $sessionStorage.fare = '0.00'; //默认无发票
                $sessionStorage.guideName = '选择导医'; //默认无导医
                $sessionStorage.guidePrice = '0.00'; //默认无导医
                $sessionStorage.serveDate = '选择时间'; //默认无时间
                $sessionStorage.addressFlag = false; //默认地址
                $state.go('ddxq_dz',{
                    id:id,
                    retainage:retainage
                })
            }else{
                $state.go('tjyyPay',{
                    id:id,
                    isServe:1
                })
            }

        }
    }
}]);
