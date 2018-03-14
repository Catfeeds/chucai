'use strict';
app.controller('homeTjzxCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.lists = $sessionStorage.lists;
    $scope.lists_package = $sessionStorage.lists_package;
    $scope.id = 0;
    $http.post('/package/package-api/index',{
        ins_id: $stateParams.id
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.id = $stateParams.id;//体检预约-体检机构列表对应id -> 传入套餐详情页面
            $scope.lists = $sessionStorage.lists = data.data.list;
            $scope.lists_package = $sessionStorage.lists_package = $scope.lists[0].package;
        }
    });


//    去套餐详情
    $scope.goTcxq = function (id) {
        $sessionStorage.isHascoupon = false;
        $state.go('tcxq',{listId:id})
    }
}]);
