'use strict';
app.controller('onlineChatCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location','Upload',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location,Upload) {
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

    // 在线咨询展示
    $scope.msgList = [];
    $scope.chatList = function () {
        $http.post('/consult/consult-api/view',{
            token:$sessionStorage.token,
            start_page: 0,
            pages: 100,
            id:$stateParams.id
        }).success(function (data) {
            if(data.errcode == 0){
                console.log(data.data.list);
                $scope.msgList = data.data.list;
            }
        });
    };
    $scope.chatList();
    // 提问
    $scope.submitQuestion = function () {
        if($('#y-content').val() == ''){
            $('#y-content').attr('placeholder','发送内容不能为空')
        }else{
            $http.post('/consult/consult-api/add',{
                token:$sessionStorage.token,
                content:$('#y-content').val(),
                imglist:null,
                runid:4, //在线咨询
                upid:$stateParams.id
            }).success(function (res) {
                if(res.errcode == 0){
                    $('#y-content').val('');
                    $scope.chatList();
                }
            });
        }
    };
    // 图片上传
    $scope.upImg = null;
    $scope.upload = function (file) {
        Upload.upload({
            url: '/base/pic-api/upload?pic_type=local',
            file: file
        }).progress(function (evt) {
            // console.log(parseInt(100.0 * evt.loaded / evt.total)) ;
        }).success(function (data) {
            if(data.state=='SUCCESS'){
                $scope.upImg = data.url;
                console.log($scope.upImg);
                $http.post('/consult/consult-api/add',{
                    token:$sessionStorage.token,
                    content:'',
                    imglist:'',
                    img:$scope.upImg,
                    runid:4, //在线咨询
                    upid:$stateParams.id
                }).success(function (res) {
                    if(res.errcode == 0){
                        $('#y-content').val('');
                        $scope.chatList();
                    }
                });
            }
        }).error(function (file, status, headers, config) {
            console.log('error status: ' + status);
        });
    };
}])
;