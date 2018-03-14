'use strict';
app.controller('evaluateCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.evaluate={
        token:$sessionStorage.token,
        orderid:parseInt($stateParams.id) //需要评价的订单id
    };
    $('.y-star-count span li').click(function () {
        var count = $(this).index() + 1;//评价星数
        var fCount = $(this).parent().parent().index();//评价种类下标
        // console.log('第' + fCount + '排' + count + '分');
        $(this).parent().find('li').removeClass('active');
        $(this).parent().find('li:lt(' + count + ')').addClass('active');

        switch (fCount) {
            case 0:$scope.evaluate.commodity_evaluate = count; break;
            case 1:$scope.evaluate.customer_evaluate = count; break;
            case 2:$scope.evaluate.exam_evaluate = count; break;
            case 3:$scope.evaluate.scene_evaluate = count; break;
            case 4:$scope.evaluate.user_evaluate = count; break;
        }
    });


    //评价结束前往所有订单页面
    $scope.goYwc = function () {
        var data = $scope.evaluate;
        var arr = [];
        angular.forEach(data,function (val,value) {
            arr.push(value)
        });
        if(arr.length == 7){
            $http.post('/evaluate/evaluate-api/add',data ).success(function (data) {
                if(data.errcode == 0){
                    console.log('评价成功');
                    $state.go('layout.mobile.serve.ywc');
                    $sessionStorage.pjFlag = true; //表示已评价
                }
            })
        }else{
            $scope.mPop.err('请评价所有选项');
        }
    }
}])
;