'use strict';
app.controller('homeTjyyCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    /*if($sessionStorage.institutionList){
        $scope.institutionList = $sessionStorage.institutionList;
    }else{
        $http.post('/institution/institution-api/index',{
            start_page: 0,
            pages: 20
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.institutionList = $sessionStorage.institutionList = data.data.list;
                // console.log ($scope.institutionList)
            }
        });
    }*/
    $scope.institutionList = $sessionStorage.institutionList
    /*$scope.institutionListItem = [];
    $scope.institutionListItems = []; //体检套餐推荐*/
}])
;