'use strict';
app.controller('onlineQuestionCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location','Upload',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location,Upload) {
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
    $scope.showChoose = 1;
    $scope.sex = '男';//性别获取
    $scope.setChoose = function (n) {
        $scope.showChoose = n;
        if(n==1){
            $scope.sex = '男';
        }else if(n==2){
            $scope.sex = '女';
        }
    };
    // 解决定位在Android机上被软键盘影响布局问题
    var h=$(window).height();
    $(window).resize(function() {
        if($(window).height()<h){
            $('.y-o-ok').hide();
        }
        if($(window).height()>=h){
            $('.y-o-ok').show();
        }
    });
    // 提问
    $scope.submitQuestion = function () {
        if($('.y-o-c-age input').val() == ''){
            $scope.mPop.err('请输入年龄')
        }else if($('.y-o-detail textarea').val() == ''){
            $scope.mPop.err('请描述您的病情')
        }else{
            $http.post('/consult/consult-api/add',{
                token:$sessionStorage.token,
                age: parseInt($('.y-o-c-age input').val()),
                sex:$scope.showChoose,
                content:$('.y-o-detail textarea').val(),
                imglist:$scope.data.list,
                // type:4, //在线咨询
                upid:0
            }).success(function (res) {
                if(res.errcode == 0){
                    $http.post('/consult/consult-api/index-list',{
                        token:$sessionStorage.token,
                        start_page: 0,
                        pages: 1
                    }).success(function (data) {
                        if(data.errcode==0){
                            var msgList = data.data.list;
                            $state.go('chat',{
                                id:msgList[0].id
                            });
                        }
                    });
                }else if(res.errcode == 9999){
                    $scope.mPop.err('该账户已在别处登录，请重新登录');
                    $timeout(function () {
                        $state.go('login')
                    },2000)
                }
            });
        }
    };

    // 图片上传
    $scope.data={
        img:null,
        list:[]
    };
    $scope.upload = function (file){
        Upload.upload({
            url: '/base/pic-api/upload?pic_type=local',
            file: file
        }).progress(function (evt) {
            // console.log(parseInt(100.0 * evt.loaded / evt.total));
        }).success(function (resp) {
            console.log(resp);
            if(resp.state=='SUCCESS'){
                $scope.data.list.push(resp.url);
                $scope.data.img=null;
            }
        }).error(function (resp) {
            console.log(resp)
        });
    };

    /*var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
    $scope.mobileUp=function () {
        if(isiOS){
            alert('苹果');
            window.webkit.messageHandlers.uploadImg.postMessage(null);
        }else{
            alert('安卓');
            window.callBack.uploadImg();
            if(window.App){
             window.App.uploadImg();
             }
        }
    };*/
}]);