'use strict';
app.controller('serveYfkCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $rootScope.baseOption.serveIsShow=3;
    $scope.yfkList = []; //已付款列表
    $scope.start_page = 0;
    $scope.total_pages = '';
    $http.post('/order/order-api/index',{
        token:$sessionStorage.token,
        start_page:$scope.start_page,
        pages:20,
        type:2
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.total_pages = data.data.total_pages;
            $scope.yfkList = data.data.list;
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
        if($scope.yfkList[index].order_type == 1){
            $state.go('ddxq1Yfk',{
                id:$scope.yfkList[index].id,
                item:$scope.yfkList[index]
            })
        }else if($scope.yfkList[index].package_name == '门诊预约'){
            $state.go('ddxq2Yfk',{
                id:$scope.yfkList[index].id,
                item:$scope.yfkList[index]
            })
        }else if($scope.yfkList[index].package_name == '住院安排'){
            $state.go('ddxq3Yfk',{
                id:$scope.yfkList[index].id,
                item:$scope.yfkList[index]
            })
        }else if($scope.yfkList[index].package_name == '手术安排'){
            $state.go('ddxq3Yfk',{
                id:$scope.yfkList[index].id,
                item:$scope.yfkList[index]
            })
        }else if($scope.yfkList[index].order_type == 2){
            $state.go('ddxq1Yfk',{
                id:$scope.yfkList[index].id,
                item:$scope.yfkList[index]
            })
        }
    };

    //申请退款
    $scope.order_number = '';
    $scope.xQIsShow = false;
    $scope.showChangeXq = function (boo,order_number) {
        $scope.xQIsShow = boo;
        $scope.order_number = order_number;
    };
    $scope.orderDel = function () {
        $http.post('/wechat/pay-test/refund',{
            token:$sessionStorage.token,
            order_number: $scope.order_number
        }).success(function (res) {
            if(res == false){
                $scope.mPop.err('退款失败，请联系客服');
                $scope.xQIsShow = false;
            }else{
                $scope.mPop.info('申请退款成功');
                $state.go("layout.mobile.serve.ywc");
            }
        });
    };
}])
;