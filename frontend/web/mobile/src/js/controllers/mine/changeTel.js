'use strict';
app.controller('changeTelCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location','$interval',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location,$interval) {
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
//    获取验证码
    $scope.number = '获取验证码';
    $('.y-r-con span').text($scope.number);
    $scope.numberFlag = true;//不能重复点击获取验证码
    $scope.getVerification = function () {
        if($scope.checkPhone($('#y-tel').val()) == false){
            $scope.mPop.err('请填写正确的手机号');
        }else if($scope.numberFlag == true){
            $http.post('/sms/index/change',{
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

    // 修改手机号
    $scope.changeTelDone = function () {
      $http.post('/ruiuser/user-api/change',{
          token:$sessionStorage.token,
          phone:$('#y-tel').val(),
          code:$('#y-verification').val()
      }).success(function (res) {
          if(res.errcode == 0){
              $scope.mPop.info('修改手机号成功');
              $timeout(function () {
                  $state.go('login')
              },1200)
          }else{
              $scope.mPop.info(res.errmsg);
          }
      })
    };
    // 验证手机号
    $scope.checkPhone = function(phone){
        if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){
            return false;
        }
    };
}]);
