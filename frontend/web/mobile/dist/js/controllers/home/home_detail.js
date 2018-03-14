'use strict';
app.controller('homeTypeDetaillCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.typeList = $sessionStorage.typeList;//对应类型的列表
    $scope.title = $stateParams.title;
    $scope.start_page = 0;
    $scope.total_pages = '';
    $http.post('/package/package-api/label',{
        start_page:$scope.start_page,
        pages:5,
        label_id: $stateParams.id
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.typeList = $sessionStorage.typeList = data.data.list;
            $scope.total_pages = data.data.total_pages;
        }
    });
    // 获取更多
    $scope.getMore = function () {
        $scope.start_page += 1;
        $http.post('/package/package-api/label',{
            start_page:$scope.start_page,
            pages:5,
            label_id: $stateParams.id
        }).success(function (data) {
            $scope.typeList= $sessionStorage.typeList = $scope.typeList.concat(data.data.list);
        });
    };
    //    去套餐详情
    $scope.goTcxq = function (id) {
        $sessionStorage.isHascoupon = false;
        $state.go('tcxq',{listId:id})
    }
}])
;