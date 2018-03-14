'use strict';
app.controller('registerCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location','$interval',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location,$interval) {
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
    $scope.number = '获取验证码';
    $('.y-r-con span').text($scope.number);
    $scope.numberFlag = true;//不能重复点击获取验证码
//    注册
    //    忘记密码
    $scope.forget = $stateParams.forget;
    // console.log('是否忘记密码：' + $scope.forget);
    $scope.showPasswdMsg = false;
    $scope.passwordMsg = '两次密码不一样';
    $scope.verificationPasswd = function () {
        if($('#y-password').val() != $('#y-passwd').val()) {
            $scope.showPasswdMsg = true;
        }else {
            $scope.showPasswdMsg = false;
        }
    };
    $scope.registerDone = function () {
        if($scope.forget == 2){ // 忘记密码
            $http.post('/ruiuser/rui-user-api/reset',{
                mobile:$('#y-tel').val(),
                newpwd:$('#y-password').val(),
                code:$('#y-verification').val()
            }).success(function (res) {
                if(res.errcode == 0){
                    $scope.mPop.info('密码重置成功');
                    $sessionStorage.isChangePassWd = true;
                    $timeout(function () {
                        $state.go('login')
                    },1200);
                }else if(res.errcode == 1201){
                    $scope.mPop.err('请输入正确的验证码');
                }
            })
        }else if($scope.forget == 1){ //注册
            $http.post('/ruiuser/rui-user-api/create',{
                mobile:$('#y-tel').val(),
                password:$('#y-password').val(),
                code:$('#y-verification').val()
            }).success(function (res) {
                if(res.errcode == 0){
                    $scope.mPop.info('注册成功');
                    $state.go('login')
                }else if(res.errcode == 1200){
                    $scope.mPop.err('该用户已注册，请登录');
                }else if(res.errcode == 1201){
                    $scope.mPop.err('请输入正确的验证码');
                }
            })
        }
    };


//    获取验证码
    $scope.getVerification = function () {
        if($('#y-tel').val() == ''){
            $scope.mPop.err('请填写手机号');
        }else if($scope.numberFlag == true){
            $http.post('/sms/index/register',{
                phone:$('#y-tel').val()
            }).success(function (res) {
                if(res.errcode == 0){
                    $scope.mPop.info('请注意查收');
                    $scope.number = 59;
                    $('.y-r-con span').text($scope.number);
                    $rootScope.timer = $interval(function () {
                        $scope.number --;
                        $('.y-r-con span').text($scope.number);
                        // console.log($scope.number);
                        if($scope.number == 0){
                            $interval.cancel($rootScope.timer);
                            $scope.number = '获取验证码';
                            $('.y-r-con span').text($scope.number);
                            $scope.numberFlag = true;
                        }
                    },1000);
                    $scope.numberFlag = false;
                }else{
                    $scope.mPop.err(res.errmsg);
                }
            });
        }
    };
}]);