var app=angular.module('app',['infinite-scroll','ui.router']);
app.config(function ($stateProvider,$urlRouterProvider) {
  $stateProvider
    .state("search",{//搜索
      url:"/search",
      templateUrl:"views/search.html"
    })
    .state("details",{//详情
      url:"/details",
      templateUrl:"views/details.html"
    });
  $urlRouterProvider.otherwise("search");
});
app.controller('ctrl',function ($scope,$http,$state) {
  $scope.dtList=[];//区域
  $http.post("../../api/base-api/lables").success(function (msg) {
    $scope.dtList=msg.data.dtList;
    $scope.dtList.unshift({dt_id:null,name:'全部'});
  });
  $scope.info={
    dt_id:null,
    page:1,
    size:5
  };
  $scope.show={
    title:null,
    list:[],
    scrollBusy:true,
    detailsCon:{}
  };
  $scope.search=function () {
    $scope.info.page=1;//初始化页码
    $http({
      method:'POST',
      url:"../../api/auth-api/search",
      headers:{"content-type":"text/json"},
      data:$scope.info
    }).success(function (msg) {
      if(msg.data.length==0){
        $scope.show.list = [];
        $scope.show.title="暂无结果";
      }else{
        $scope.show.scrollBusy=false;
        $scope.show.title=null;
        $scope.show.list=msg.data;
      }
    });
  };
  $scope.scroll=function () {
    $scope.info.page++;
    $http({
      method:'POST',
      url:"../../api/auth-api/search",
      headers:{"content-type":"text/json"},
      data:$scope.info
    }).success(function (msg) {
      $scope.show.list=$scope.show.list.concat(msg.data)
    })
  };
  $scope.details=function (item) {
    $scope.show.detailsCon=item;
    $state.go('details');
    document.body.scrollTop=0;
  };
  $scope.modelClose=function () {
    $state.go('search')
  }
});