'use strict';
app.controller('homeTjscCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.start_page = 0;
    $scope.total_pages = '';
    if($sessionStorage.addhot){
        $scope.addhot = $sessionStorage.addhot; // 精品推荐列表
    }else{
        $http.post('/package/package-api/addhot',{
            start_page: 0,
            pages: 10
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.total_pages = data.data.total_pages;
                $scope.addhot = $sessionStorage.addhot = data.data.list;
            }
        });
    }

// 获取更多
    $scope.getMore = function () {
        $scope.start_page += 1;
        $http.post('/package/package-api/addhot',{
            start_page: 0,
            pages: 5
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.addhot= $sessionStorage.addhot = $scope.addhot.concat(data.data.list);
            }
        });
    };
    //体检商城标签
    $scope.label = [];
    $http.post('/label/label-api/view',{
        start_page: 0,
        pages: 6
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.label = data.data.list;
            // console.log(data.data.list)
        }
    });
}])