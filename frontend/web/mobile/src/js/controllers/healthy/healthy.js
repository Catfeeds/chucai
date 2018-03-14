'use strict';
app.controller('healthyCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $rootScope.changeNavH();
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
    $rootScope.baseOption.active=2;
    // $scope.labelList = $sessionStorage.labelList;
    $rootScope.healtyhIsShow = -1;
    $rootScope.setShow = function (n) {
        $sessionStorage.baseOption.healtyhIsShow = n;
    };
    $http.post('/news/news-labels-api/index',{
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.labelList = $sessionStorage.labelList = data.data.list;
            // console.log( $scope.labelList)
        }
    });

    $scope.chooseType = function (index) {
        $sessionStorage.baseOption.healtyhIsShow = index;
        $state.go('layout.mobile.healthy.type1',{label_id:$scope.labelList[index].id})
    }
}])
;