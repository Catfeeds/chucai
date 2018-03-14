'use strict';
app.controller('healthyTjCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.baseOption.healtyhIsShow = -1;
    $scope.newsLists = $sessionStorage.newsLists;
    $http.post('/news/news-api/index',{
        is_recommend:1,
        start_page:0,
        pages:50
    }).success(function (data) {
        if(data.errcode == 0){
            console.log('推荐',data.data.list);
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
    /*$scope.demoList=['第1章','第2章','第3章','第4章','第5章','第6章'];
    var n=1;
    $scope.busy=false;
    $scope.lazyLoad=function () {
        $scope.busy=true;
        $scope.demoList=$scope.demoList.concat([${n},${n+1},${n+2},${n+3}]);
        n+=4;
        console.log('现在是',n);
        $timeout(function () {
            $scope.busy=false;
        },1500);
    }*/
}])
;