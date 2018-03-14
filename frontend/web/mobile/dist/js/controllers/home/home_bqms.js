'use strict';
app.controller('homeBqmsCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location','Upload',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location,Upload) {
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
    $scope.familyName = $sessionStorage.mzyyName; //一开始选择的就诊人
    $scope.familyId = $sessionStorage.familyId;
    $scope.mzyy = $sessionStorage.mzyy;//判断是门正预约还是住院安排
    $('textarea').val($sessionStorage.ill_describe);
    console.log('就诊人：' + $scope.familyName + ' ' + '就诊人id：' + $scope.familyId + $scope.mzyy);
    $scope.nullCon = false;
    $scope.goMzyy = function () {
        if($('textarea').val() == ''){
            $scope.nullCon = true;
        }else if($('textarea').val() != ''){
            $sessionStorage.ill_describe = $('textarea').val();
            if($scope.mzyy == 'mzyy'){
                $http.post('/appoint/appoint-api/add',{
                    token:$sessionStorage.token,
                    ill_describe: $sessionStorage.ill_describe,
                    imglist:$sessionStorage.pics, // 病情描述图
                    type:1,
                    family_id:parseInt($sessionStorage.familyId)
                }).success(function (res) {
                    if(res.errcode == 0){
                        $state.go('mzyy',{})
                    }
                });
            }else if($scope.mzyy == 'zyap'){
                $http.post('/appoint/appoint-api/add',{
                    token:$sessionStorage.token,
                    ill_describe: $sessionStorage.ill_describe,
                    imglist:$sessionStorage.pics, // 病情描述图
                    type:2,
                    family_id:parseInt($sessionStorage.familyId)
                }).success(function (res) {
                    if(res.errcode == 0){
                        $state.go('zyap',{})
                    }
                });
            }else if($scope.mzyy == 'shap'){
                $http.post('/appoint/appoint-api/add',{
                    token:$sessionStorage.token,
                    ill_describe: $sessionStorage.ill_describe,
                    imglist:$sessionStorage.pics, // 病情描述图
                    type:3,
                    family_id:parseInt($sessionStorage.familyId)
                }).success(function (res) {
                    if(res.errcode == 0){
                        $state.go('zyap',{})
                    }
                });
            }
        }
    };
    $scope.showError = function () {
        $scope.nullCon = false;
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
                $sessionStorage.pics = $scope.data.list; // 病情描述图
                $scope.data.img=null;
            }
        }).error(function (resp) {
            console.log(resp)
        });
    };
}])
;
/*
$http.post('/appoint/appoint-api/add',{
    token:$sessionStorage.token,
    ill_describe: $sessionStorage.ill_describe,
    imglist:$sessionStorage.pics, // 病情描述图
    is_match:1,
    type:1,
    hope_time:$scope.data,
    service_price:$sessionStorage.service_price,
    sum_price:$scope.sum_price,
    family_id:parseInt($sessionStorage.familyId),
    runid:1 // 门诊预约图片描述
}).success(function () {
    // console.log('success')
    $state.go('outpatient_pay',{
        hospital:'带定制',
        department:'带定制',
        doctor:'带定制',
        hope_time:$scope.date,
        sum_price:$scope.sum_price,
        familyName:'带定制'
    })
});
$http.post('/appoint/appoint-api/add',{
    token:$sessionStorage.token,
    ill_describe: $sessionStorage.ill_describe,
    imglist:$sessionStorage.pics, // 病情描述图
    hospital:$scope.hospital,
    department:$scope.ks,
    doctor:$scope.doctor,
    is_match:2,
    type:1,
    hope_time:$scope.date,
    service_price:$sessionStorage.service_price,
    sum_price:$scope.sum_price,
    family_id:parseInt($sessionStorage.familyId),
    runid:1 // 门诊预约图片描述
}).success(function () {
    // console.log('success')
    $sessionStorage.guideName = '选择导医';
    $sessionStorage.guidePrice = 0;
    $sessionStorage.invoice = '无';
    $state.go('outpatient_pay',{
        hospital:$scope.hospital,
        department:$scope.ks,
        doctor:$scope.doctor,
        hope_time:$scope.date,
        sum_price:$scope.sum_price,
        familyName:$sessionStorage.mzyyName
    })
});*/
