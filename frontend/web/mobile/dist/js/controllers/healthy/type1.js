'use strict';
app.controller('healthyType1Ctrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.newsLists = $sessionStorage.newsLists;
    $scope.label_id = $stateParams.label_id;
    $scope.start_page = 0;
    $http.post('/news/news-api/index',{
        label_id:parseInt($scope.label_id),
        start_page:$scope.start_page,
        pages:10
    }).success(function (data) {
        if(data.errcode == 0){
            // console.log(data.data.list);
            $scope.newsLists = $sessionStorage.newsLists = data.data.list;
        }
    });
    // 无限加载
    $scope.busy=false;
    $scope.lazyLoad=function () {
        $scope.start_page += 1;
        $http.post('/news/news-api/index',{
            label_id:parseInt($scope.label_id),
            start_page:$scope.start_page,
            pages:10
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.newsLists = $sessionStorage.newsLists.concat(data.data.list);
            }
        });
        $scope.busy=true;
        $timeout(function () {
            $scope.busy=false;
        },1500);
    };
//    去往详情页
    $scope.goToDetail = function (id,img) {
        $state.go('healthy_detail',{
            id:id,
            img:img,
            scrollTop:$('.app-content-body').scrollTop()
        })
    };

    //自定义指令repeatFinish
    app.directive('newsFinish',function(){
        return {
            link: function(scope,element,attr){
                if(scope.$last == true){
                    $('.app-content-body').scrollTop(parseInt($sessionStorage.newsScrollTop)); // 之前阅读的位置
                }
            }
        }
    })
}])
;