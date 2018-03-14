'use strict';
app.controller('loginCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    //    返回按钮判断
    $scope.isChangePassWd = $sessionStorage.isChangePassWd;
    //    登录
    $scope.errorMsg = '';
    $scope.login = function () {
        $sessionStorage.userTel = $('#y-login-tel').val();
        $http.post('/ruiuser/rui-user-api/login',{
            mobile:$('#y-login-tel').val(),
            password:$('#y-login-password').val()
        }).success(function (data) {
            if(data.errcode == 0){
                $sessionStorage.token = data.data.token;
                $http.post('/address/address-api/view',{
                    token:$sessionStorage.token,
                    start_page:0,
                    pages:10
                }).success(function (data) {
                    if(data.errcode == 0){
                        var address = data.data.list;
                        $sessionStorage.addressLength = address.length;
                    }
                });
                $scope.mPop.info('登陆成功!');
                $timeout(function () {
                    if($sessionStorage.toState.type==1){//门诊预约
                        $state.go($sessionStorage.toState.name,{chooseFamily:1},{location:'replace'})
                    }else if($sessionStorage.toState.type==2){//住院安排和手术安排
                        $state.go($sessionStorage.toState.name,{chooseFamily:2},{location:'replace'})
                    }else if($sessionStorage.toState.type==3){//订单详情
                        $state.go($sessionStorage.toState.name,{id:$sessionStorage.toState.id},{location:'replace'})
                    }else{//其他情况
                        $state.go($sessionStorage.toState.name,{},{location:'replace'})
                    }
                },1200);
            }else{
                $scope.errorMsg = data.errmsg;
            }
        })
    };
    // 客服电话
    $http.post('/aboutus/about-us-api/view',{
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.aboutUs = data.data.list[0];
            $sessionStorage.contactTel = $scope.aboutUs.tel;
        }
    });
}]);
