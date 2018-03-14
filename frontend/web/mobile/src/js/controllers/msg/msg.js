'use strict';
app.controller('msgCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.show = 1;
    $scope.showMask = false;
    $scope.changeNum = function (n) {
        this.show = n;
    };
//    取消遮罩
    $scope.cancel = function () {
        $scope.showMask = false;
    };

    //服务信息
    $scope.msg1 = $sessionStorage.msg1;
    $scope.getMsg1 = function () {
        $http.post('/notice/notice-api/index',{
            token:$sessionStorage.token,
            start_page: 0,
            pages: 50,
            type:1
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.msg1 = $sessionStorage.msg1 = data.data.list;
                $state.go('msg.fwxx');
            }
        });
    };
    $scope.goFwxx = function () {
        $rootScope.baseOption.msgShow=2;
        $scope.getMsg1();
    };


    //系统公告
    $scope.msg2 = $sessionStorage.msg2;
    console.log($scope.msg1,$scope.msg2);
    $scope.getMsg2 = function () {
        $http.post('/notice/notice-api/index',{
            token:$sessionStorage.token,
            start_page: 0,
            pages: 50,
            type:2
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.msg2 = $sessionStorage.msg2 = data.data.list;
                $state.go('msg.xtgg');
            }
        });
    };
    $scope.goXtgg = function () {
        $rootScope.baseOption.msgShow=3;
        $scope.getMsg2()
    };

//清空消息
    $scope.showMsgChoose = function () {
        $scope.showMask = true;
    };
    $scope.isReadAll = function () {
        $('.y-unread').hide();
        $http.post('/notice/notice-api/read-all',{
            token:$sessionStorage.token
        }).success(function (res) {
            if(res.errcode == 0){
                $scope.mPop.info('已全部标记为已读');
                $scope.showMask = false;
            }
        })
    };
//    去往详情页
    $scope.goToDetail = function (id) {
        $state.go('msg_detail',{
            id:id
        })
    };

    // 根据情况返回
    $scope.goToBack = function () {
        switch($sessionStorage.goFlag){
            case 'home':$state.go('layout.mobile.home');break;
            case 'healthy':$state.go('layout.mobile.healthy.tj');break;
            case 'serve':$state.go('layout.mobile.serve.all');break;
            case 'mine':$state.go('layout.mobile.mine');break;
        }
    }
}])
;
