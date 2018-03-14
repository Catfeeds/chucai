'use strict';
app.controller('settingCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
$scope.userMobile = $sessionStorage.userMobile;
//    显示登录还是退出登录
    $scope.loginFlag = false;
    if($sessionStorage.token){
        $scope.loginFlag = true
    }else{
        $scope.loginFlag = false;
    }
//    意见反馈
    // 验证手机号
    $scope.checkPhone = function(phone){
        if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){
            return false;
        }
    };
    // 验证邮箱
    $scope.checkFilter = function (email) {
        if(!(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email))){
            return false
        }
    };
    // 纯数字验证
    $scope.validate = function(obj){
        var reg = /^[0-9]*$/;
        return reg.test(obj);
    };
    $scope.setting_yj = function () {
        if($sessionStorage.token){
            $state.go('setting_yj');
        }else{
            $scope.mPop.err('请登录')
        }
    };
    $scope.opinionFeedback = function () {
        if($('#y-options').val() == '' || $('#y-tel').val() == ''){
            $scope.mPop.err('请填写完整再提交反馈')
        }else if($scope.validate($('#y-tel').val()) == true){
            if($scope.checkPhone($('#y-tel').val()) == false){
                $scope.mPop.err('请填写正确的手机号')
            }else{
                $http.post('/feedback/feedback-api/add',{
                    token:$sessionStorage.token,
                    content:$('#y-options').val(),
                    contact:$('#y-tel').val()
                }).success(function (data) {
                    if(data.errcode == 0){
                        $scope.mPop.info('意见反馈成功');
                        $timeout(function () {
                            history.go(-1);
                        },2000);
                    }else if(data.errcode == 1200){
                        var text = data.errmsg + '请不要重复反馈';
                        $scope.mPop.err(text);
                        $timeout(function () {
                            history.go(-1);
                        },2000);
                        $('#y-options').val('');
                        $('#y-tel').val('')
                    }

                });
            }
        }else if($scope.validate($('#y-tel').val()) == false){
            if($scope.checkFilter($('#y-tel').val()) == false){
                $scope.mPop.err('请填写正确的邮箱号')
            }else{
                $http.post('/feedback/feedback-api/add',{
                    token:$sessionStorage.token,
                    content:$('#y-options').val(),
                    contact:$('#y-tel').val()
                }).success(function (data) {
                    if(data.errcode == 0){
                        $scope.mPop.info('意见反馈成功');
                        history.go(-1);
                    }else if(data.errcode == 1200){
                        var text = data.errmsg + '请不要重复反馈';
                        $scope.mPop.err(text);
                        $timeout(function () {
                            history.go(-1);
                        },2000);
                        $('#y-options').val('');
                        $('#y-tel').val('')
                    }
                });
            }
        }
    };
//修改密码
    $scope.setting_password = function () {
        if($sessionStorage.token){
            $state.go('setting_password');
        }else{
            $scope.mPop.err('请登录')
        }
    };
    $scope.showPasswdMsg = false;
    $scope.passwordMsg = '两次密码不一样';
    $scope.verificationPasswd = function () {
        if($('#presentpwdNew').val() != $('#presentpwd').val()) {
            $scope.showPasswdMsg = true;
        }else {
            $scope.showPasswdMsg = false;
        }
    };
    $scope.changePassword = function () {
        if($('#orignalpwd').val() == '' || $('#presentpwd').val() == '' || $('#presentpwdNew').val() == ''){
            $scope.mPop.err('请填写完整');
        }else{
            $http.post('/ruiuser/user-api/update',{
                token:$sessionStorage.token,
                orignalpwd:$('#orignalpwd').val(),
                presentpwd:$('#presentpwd').val()
            }).success(function (res) {
                if(res.errcode == 0){
                    $scope.mPop.info('密码修改成功');
                    $sessionStorage.token = null;
                    $sessionStorage.isChangePassWd = true;
                    $state.go('login');
                }else if(res.errcode == 2004){
                    $scope.mPop.err(res.errmsg);
                }
            })
        }
    };

//    清除缓存
    /*$scope.showCache = false;
    $scope.delCache = function () {
        $scope.showCache = true;
        console.log($scope.showCache)
    };
    $scope.cancel = function (boolean) {
        $scope.showCache = boolean;
    };*/
//退出登录
    $scope.goMine = function () {
        $sessionStorage.token = null;
        $sessionStorage.isChangePassWd = false;
        $state.go('layout.mobile.mine');
    };
}])
;
