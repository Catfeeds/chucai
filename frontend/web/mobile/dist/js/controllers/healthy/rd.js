'use strict';
app.controller('healthyRdCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.baseOption.healtyhIsShow = -2;
    $scope.newsLists = $sessionStorage.newsLists;
    $http.post('/news/news-api/index',{
        is_hot:1
    }).success(function (data) {
        if(data.errcode == 0){
            console.log('热点',data.data.list);
            $scope.newsLists = $sessionStorage.newsLists = data.data.list;
        }
    });
    //    去往详情页
    $scope.goToDetail = function (id,img) {
        $state.go('healthy_detail',{
            id:id,
            img:img,
            scrollTop:$('.app-content-body').scrollTop()
        })
    };
}])
;