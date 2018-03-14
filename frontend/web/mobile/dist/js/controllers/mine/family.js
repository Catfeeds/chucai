'use strict';
app.controller('familyCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.showMask = false;//遮罩
    $scope.title = '家人管理';
    $scope.chooseFamilyFlag = parseInt($stateParams.chooseFamily);
    if($scope.chooseFamilyFlag == 1 || $scope.chooseFamilyFlag == 2 || $scope.chooseFamilyFlag == 3){
        $scope.title = '选择预约人';
    }

//    家人列表
    $scope.familyList = [];
    $scope.familySex = '';
    $scope.familyNum = 0;
    function familyList () {
        $http.post('/family/family-api/index',{
            token:$sessionStorage.token
        }).success(function (data) {
            if(data.code == 0){
                $scope.familyNum = data.count;
                $scope.familyList = data.family_data;
                angular.forEach($scope.familyList,function (val) {
                    switch(parseInt(val.sex)){
                        case 1: val.sex='男';break;
                        case 2: val.sex='女';break
                    }
                })
            }else if(data.code == 1200){
                $scope.familyNum = 0
            }
        });
    }
    familyList();
//    家人增加
    $scope.showFamilyList = true;
    $scope.showFamilyAdd = false;
    $scope.addSex = 1;
    $scope.addFamilyName = '';
    //返回家人列表
    $scope.addGoFamilyList = function () {
        $scope.showFamilyList = true;
        $scope.showFamilyAdd = false;
    };
    $scope.familyAddItem = function (index) {
        $scope.showFamilyList = false;
        $scope.showFamilyAdd = true;
        $scope.setAddSex = function (n) {
            $scope.addSex = n;
        }
    };
    $scope.familyAddDone = function () {
        if($scope.isIdCardNo($('#add_id_card').val())== false){
            $scope.mPop.err('请输入正确的身份证号!');
        }else if($('#add_name').val == '' || $('#add_id_card').val() == '' || $('#add_age').val() == '' || $('#add_tel').val() == ''){
            $scope.mPop.err('请填写完整!')
        }else if($scope.checkPhone($('#add_tel').val())==false){
            $scope.mPop.err('请输入正确的手机号!');
        }else{
            $http.post('/family/family-api/add',{
                token:$sessionStorage.token,
                name:$('#add_name').val(),
                sex:parseInt($scope.addSex),
                id_card:$('#add_id_card').val(),
                age:parseInt($('#add_age').val()),
                tel:$('#add_tel').val()
            }).success(function () {
                $('#add_name').val('');
                $('#add_id_card').val('');
                $('#add_age').val('');
                $('#add_tel').val('');
                $scope.addSex = 1;
                familyList();
                $scope.showFamilyList = true;
                $scope.showFamilyAdd = false;
            });
        }

    };
//    家人删除
    $scope.familyId = 0;
    $scope.showDel = function (flag,id) {
        $scope.showMask = flag;
        $scope.familyId = id;
    };
    $scope.delFamily = function () {
        $http.post('/family/family-api/delete',{
            token:$sessionStorage.token,
            id:$scope.familyId
        }).success(function () {
            familyList();
        });
        $scope.showMask = false
    };

//    家人修改
    $scope.showFamilyList = true;
    $scope.showFamilyChange = false;
    $scope.needChangeFamily = [];
    $scope.changeSex = '';
    //返回家人列表
    $scope.changeGoFamilyList = function () {
        $scope.showFamilyList = true;
        $scope.showFamilyChange = false;
    };
    $scope.familyChangeItem = function (index) {
        $scope.needChangeFamily = $scope.familyList[index];
        if($scope.needChangeFamily.sex == '男'){
            $scope.changeSex = 1
        }else{
            $scope.changeSex = 2
        }
        // console.log($scope.needChangeFamily);
        $scope.showFamilyList = false;
        $scope.showFamilyChange = true;
        $scope.setChangeSex = function (n) {
            $scope.changeSex = n;
        }
    };
    $scope.familyChangeDone = function () {
        $http.post('/family/family-api/update',{
            id:parseInt($scope.needChangeFamily.id),
            token:$sessionStorage.token,
            name:$('#change_name').val(),
            sex:parseInt($scope.changeSex),
            id_card:$('#change_id_card').val(),
            age:parseInt($('#change_age').val()),
            tel:$('#change_tel').val()
        }).success(function () {
            familyList();
            $scope.showFamilyList = true;
            $scope.showFamilyChange = false;
        });
    };

    $scope.chooseFamily = function (name,id,sex,age,index) {
        $sessionStorage.mzyyName = name; //绿色通道就诊人
        $sessionStorage.familyId = id; //绿色通道就诊人id
        if($scope.chooseFamilyFlag == 1){
            $sessionStorage.mzyy = 'mzyy';
            $state.go('bqms',{})
        }else if($scope.chooseFamilyFlag == 2){
            $sessionStorage.mzyy = 'zyap';
            $state.go('bqms',{})
        }else if($scope.chooseFamilyFlag == 3){
            $sessionStorage.mzyy = 'shap';
            $state.go('bqms',{})
        }else if($sessionStorage.ddxqFamily == true){
            // 套餐性别限定
            if($sessionStorage.adaptSex == '男'){
                if(sex == '女'){
                    $scope.mPop.info('该套餐仅限男性使用');
                }else{
                    $sessionStorage.familyName = name;
                    history.go(-1);
                }
            }else if($sessionStorage.adaptSex == '女'){
                if(sex == '男'){
                    $scope.mPop.info('该套餐仅限女性使用');
                }else{
                    $sessionStorage.familyName = name;
                    history.go(-1);
                }
            }else{
                $sessionStorage.familyName = name;
                history.go(-1);
            }

        }
    };


// 验证手机号
    $scope.checkPhone = function(phone){
        if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){
            return false;
        }
    };
    //验证身份证
    $scope.isIdCardNo=function(num){
        if(num){
            num = num.toUpperCase();
            //身份证号码为15位或者18位，15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X。
            if (!(/(^\d{15}$)|(^\d{17}([0-9]|X)$)/.test(num))) {
                // alert('输入的身份证号长度不对，或者号码不符合规定！\n15位号码应全为数字，18位号码末位可以为数字或X。');
                return false;
            }
            //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
            //下面分别分析出生日期和校验位
            var len, re;
            len = num.length;
            if (len == 15){
                re = new RegExp(/^(\d{6})(\d{2})(\d{2})(\d{2})(\d{3})$/);
                var arrSplit = num.match(re);
                //检查生日日期是否正确
                var dtmBirth = new Date('19' + arrSplit[2] + '/' + arrSplit[3] + '/' + arrSplit[4]);
                var bGoodDay;
                bGoodDay = (dtmBirth.getYear() == Number(arrSplit[2])) && ((dtmBirth.getMonth() + 1) == Number(arrSplit[3])) && (dtmBirth.getDate() == Number(arrSplit[4]));
                if (!bGoodDay) {
                    // alert('输入的身份证号里出生日期不对！');
                    return false;
                }else{
                    //将15位身份证转成18位
                    //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                    var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                    var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                    var nTemp = 0, i;
                    num = num.substr(0, 6) + '19' + num.substr(6, num.length - 6);
                    for(i = 0; i < 17; i ++) {
                        nTemp += num.substr(i, 1) * arrInt[i];
                    }
                    num += arrCh[nTemp % 11];
                    return true;
                }
            }
            if (len == 18){
                re = new RegExp(/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/);
                var arrSplit = num.match(re);
                //检查生日日期是否正确
                var dtmBirth = new Date(arrSplit[2] + "/" + arrSplit[3] + "/" + arrSplit[4]);
                var bGoodDay;
                bGoodDay = (dtmBirth.getFullYear() == Number(arrSplit[2])) && ((dtmBirth.getMonth() + 1) == Number(arrSplit[3])) && (dtmBirth.getDate() == Number(arrSplit[4]));
                if (!bGoodDay) {
                    /*alert(dtmBirth.getYear());
                     alert(arrSplit[2]);
                     alert('输入的身份证号里出生日期不对！');*/
                    return false;
                }
                else {
                    //检验18位身份证的校验码是否正确。
                    //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                    var valnum;
                    var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                    var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                    var nTemp = 0, i;
                    for(i = 0; i < 17; i ++) {
                        nTemp += num.substr(i, 1) * arrInt[i];
                    }
                    valnum = arrCh[nTemp % 11];
                    if (valnum != num.substr(17, 1)) {
                        // alert('18位身份证的校验码不正确！应该为：' + valnum);
                        return false;
                    }
                    return true;
                }
            }
            return false;
        }
    };
}]);
