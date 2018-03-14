
app.controller('serveCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    // 是否有新消息
    $scope.isRead = false;
    $http.post('/notice/notice-api/all',{
        token:$sessionStorage.token,
        type:0
    }).success(function (res) {
        if(res.errcode==0){
            var arr = res.data.list;
            angular.forEach(arr,function (val) {
                if(val.is_read==1){
                    $scope.isRead = true;
                }else if(val.is_read==2){
                    $scope.isRead = false;
                }
            })
        }
    });
    $rootScope.baseOption.active=3;
    $rootScope.baseOption.serveIsShow=1;

    $scope.start_page = 0;
    $scope.total_pages = '';
    /*if(!$sessionStorage.serveList){
        $scope.serveList = [];
        $http.post('/order/order-api/index',{
            token:$sessionStorage.token,
            start_page:$scope.start_page,
            pages:20,
            type:0
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.total_pages = data.data.total_pages;
                $scope.serveList = $sessionStorage.serveList = data.data.list;
            }else if(data.errcode == 9999){
                $scope.mPop.err('该账号已在别处登录，请重新登录');
                $timeout(function () {
                    $state.go('login')
                },2000)
            }
        });
    }else{
        $scope.serveList = $sessionStorage.serveList;
        $scope.total_pages = $scope.allTotal_pages;
    }*/
    $scope.serveList = [];
    $http.post('/order/order-api/index',{
        token:$sessionStorage.token,
        start_page:$scope.start_page,
        pages:20,
        type:0
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.total_pages = data.data.total_pages;
            $scope.serveList = $sessionStorage.serveList = data.data.list;
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

                $scope.serveList = $scope.serveList.concat(data.data.list);
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
        $sessionStorage.orderScrollTop = $('.scroll-content').scrollTop();
        // console.log($scope.serveList[index])
        if($scope.serveList[index].order_type == 1){ //套餐
            if($scope.serveList[index].type == 1){ //待付款
                $state.go('ddxq1',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 2){ // 已付款
                $state.go('ddxq1Yfk',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 3 || $scope.serveList[index].type == 5){ // 已完成
                $state.go('ddxq1Ywc',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 6 || $scope.serveList[index].type == 7){ // 退款
                $state.go('ddxq1Tk',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }
        }else if($scope.serveList[index].package_name == '门诊预约'){ //门诊预约
            if($scope.serveList[index].type == 1){
                $state.go('ddxq2',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 2){
                $state.go('ddxq2Yfk',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 3 || $scope.serveList[index].type == 5){ // 已完成
                $state.go('ddxq2Ywc',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 6 || $scope.serveList[index].type == 7){ // 退款
                $state.go('ddxq2Tk',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }
        }else if($scope.serveList[index].package_name == '住院安排'){ //住院安排
            if($scope.serveList[index].type == 1){
                $state.go('ddxq3',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 2){
                $state.go('ddxq3Yfk',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 3 || $scope.serveList[index].type == 5){ // 已完成
                $state.go('ddxq3Ywc',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 6 || $scope.serveList[index].type == 7){ // 退款
                $state.go('ddxq3Tk',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }
        }else if($scope.serveList[index].package_name == '手术安排'){ // 手术安排
            if($scope.serveList[index].type == 1){
                $state.go('ddxq3',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 2){
                $state.go('ddxq3Yfk',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 3 || $scope.serveList[index].type == 5){ // 已完成
                $state.go('ddxq3Ywc',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 6 || $scope.serveList[index].type == 7){ // 退款
                $state.go('ddxq3Tk',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }
        }else if($scope.serveList[index].order_type == 2){ // 个性化
            if($scope.serveList[index].type == 1 || $scope.serveList[index].type == 10){
                $state.go('ddxq4',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 9){
                $state.go('ddxq4_undone',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 2 || $scope.serveList[index].type == 8){ // 已付款
                $state.go('ddxq1Yfk',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 3 || $scope.serveList[index].type == 5){ // 已完成
                $state.go('ddxq1Ywc',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }else if($scope.serveList[index].type == 6 || $scope.serveList[index].type == 7){ // 退款
                $state.go('ddxq4Tk',{
                    id:$scope.serveList[index].id,
                    item:$scope.serveList[index]
                })
            }
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
'use strict';
//repeatFinish指令
app.directive('repeatFinish',function(){
    return {
        restrict: 'A',
        link: function(scope,element,attr){
            if(scope.$last == true){

            }

        }
    }
});