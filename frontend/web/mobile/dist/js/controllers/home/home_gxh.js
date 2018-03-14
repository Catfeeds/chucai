'use strict';
app.controller('homeGxhCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.maskShow = false;
    $scope.showIntruDetail = function () {
        $scope.maskShow = true;
    };
    // 拨打咨询热线
    $scope.telPhone = function (tel) {
        location.href = 'tel://' + tel;
    };
    //前往个性化体检
    $scope.goTcdz=function () {
        $sessionStorage.quesOption={
            token:$sessionStorage.token,
            age:'选择年龄',//年龄
            sex:'是',//性别
            is_sexual:'是',//性生活
            height:null,//身高
            weight:null,//体重
            waist:null,//腰围
            family_history:'选择家族史',//家族史
            past_history:'选择既往病史',//既往病史
            allerg_history:'选择过敏史',//过敏史
            sit:'是',//静坐为主
            sleep:'是',//睡眠充足
            sleep_quality:'选择',//睡眠质量
            habit:'选择',//习惯
            smoke:'是',//超过20支烟
            smoke_year:'选择',//烟龄
            passive_smoke:'选择',//被动吸烟
            exercise:'选择',//锻炼
            diet:'选择',//膳食搭配
            drink:'选择',//每日饮水量
            anorectal:'选择',//便秘腹泻等
            urinary:'选择',//尿不畅等
            blue:'选择',//精神压抑
            vertebral:'选择',//颈椎
            examination:'选择',//血脂异常等
            burn:'是',//生育意愿
            breast:'选择',//乳腺疾病
            menstruation:'选择',//月经
            menopause:'选择',//绝经
            TCT:'是',//TCT
            pregnant:'是',//怀孕
            physical:'选择',//身体状况
            doctor_number:'选择',//看过医生次数
            exam:'是',//体检
            symptom:'选择',//症状
            activity:'选择'//活动困难
        };
        $sessionStorage.iList={
            list2:[],
            list3:[],
            list4:[],
            list6:[],
            list12:[],
            list13:[],
            list15:[],
            list16:[],
            list17:[],
            list22:[],
            list23:[]
        }
        $state.go('tcdz');
    }
}])
;