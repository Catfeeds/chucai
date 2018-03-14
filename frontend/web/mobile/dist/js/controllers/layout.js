'use strict';
/* Controllers */
app.controller('layoutCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.myServe = function () {
        switch($rootScope.baseOption.serveIsShow){
            case 1:
                $sessionStorage.toState.name='layout.mobile.serve.all';
                break;
            case 2:
                $sessionStorage.toState.name='layout.mobile.serve.dfk';
                break;
            case 3:
                $sessionStorage.toState.name='layout.mobile.serve.yfk';
                break;
            case 4:
                $sessionStorage.toState.name='layout.mobile.serve.ywc';
                break;
            case 5:
                $sessionStorage.toState.name='layout.mobile.serve.tk';
                break;
        }
        if(!$sessionStorage.token){
            $state.go('login');
        }else{
            $http.post('/aboutus/about-us-api/view',{
            }).success(function (data) {
                if(data.errcode == 0){
                    $sessionStorage.aboutUsTel = data.data.list[0].tel;
                    $state.go($sessionStorage.toState.name);
                }
            });
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
        }
    };
    $scope.myMine = function () {
        $sessionStorage.toState.name='layout.mobile.mine';
        if(!$sessionStorage.token){
            $state.go('login');
        }else{
            $state.go($sessionStorage.toState.name);
        }
    }
}])
;