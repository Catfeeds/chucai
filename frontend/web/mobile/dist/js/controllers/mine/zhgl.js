'use strict';
app.controller('userMsgCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location','Upload',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location,Upload) {
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
    $sessionStorage.adaptAddress = '全部'; // 防止和套餐选择地址冲突
    $scope.userName = $sessionStorage.userName; // 用户名
    $scope.userSex = $sessionStorage.userSex; //用户性别
    $scope.userPhoto = $sessionStorage.userPhoto; // 用户头像
    $scope.user_id_card = $sessionStorage.user_id_card; // 身份证
    $scope.userList = [];
    $http.post('/ruiuser/user-api/view',{
        token:$sessionStorage.token
    }).success(function (data) {
        $scope.userList = data.data;
        console.log($scope.userList )
    });
    //上传头像
    $scope.showMask = false;
    $scope.nameShow = false;
    $scope.uploadUserImage = function () {
        $scope.showMask = true;
    };
    $scope.userImgCancel = function () {
        $scope.showMask = false;
    };

    $scope.upload = function (file) {
        $scope.showMask = false;
        Upload.upload({
            url: '/base/pic-api/upload?pic_type=local',
            file: file
        }).progress(function (evt) {
            $scope.nameShow = true;
            // console.log(parseInt(100.0 * evt.loaded / evt.total)) ;
        }).success(function (data) {
            if(data.state=='SUCCESS'){
                $scope.nameShow = false;
                $scope.upImg = data.url;
                $scope.userPhoto = $sessionStorage.userPhoto = $scope.upImg;
                $scope.mPop.info('头像上传成功');
            }
        }).error(function (file, status, headers, config) {
            console.log('error status: ' + status);
            $scope.nameShow = false;
        });
    };
    //默认地址显示
    $scope.goAddress = function () {
        $scope.data = {
            token:$sessionStorage.token,
            name:$('#y-name').val(),
            sex:parseInt($sessionStorage.setSex),
            headimg:$scope.upImg,
            id_card:$('#y-id-card').val(),
            mobile:$scope.userList.mobile
        };
        $http.post('/ruiuser/user-api/add',$scope.data).success(function (res) {
            if(res.errcode==0){
                $scope.user_id_card = $sessionStorage.user_id_card = $('#y-id-card').val();
                $state.go('address',{isDdxq:1})
            }
        });
    };
    // 地址列表
    function getAddressList() {
        $http.post('/address/address-api/view',{
            token:$sessionStorage.token,
            start_page:0,
            pages:10
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.address = data.data.list;
                // console.log(address);
                angular.forEach($scope.address,function (val) {
                    if(val.status == 1){
                        $sessionStorage.userAddress = val.full_address;
                        $scope.userAddress = $sessionStorage.userAddress;
                    }
                })
            }
        });
    }
    getAddressList();
    $scope.userAddress = $sessionStorage.userAddress;

    // 性别状态选择+显示
    $scope.setSex = $sessionStorage.setSex; // 性别按钮是选中还是不选中状态
    if($sessionStorage.userSex == '男'){
        $scope.setSex = $sessionStorage.setSex = 1;
    }else if($sessionStorage.userSex == '女'){
        $scope.setSex = $sessionStorage.setSex = 2;
    }else {
        $scope.setSex = $sessionStorage.setSex = 0; // 新用户时性别按钮无选择
    }
    $scope.sexShow = false;
    $scope.showSex = function () {
        $scope.sexShow = true;
        if($sessionStorage.userSex == '男'){
            $scope.setSex = $sessionStorage.setSex = 1;
        }else if($sessionStorage.userSex == '女'){
            $scope.setSex = $sessionStorage.setSex = 2;
        }else {
            $scope.setSex = $sessionStorage.setSex = 0; // 新用户时性别按钮无选择
        }
    };
    $scope.setSexs = function (n) {
        $scope.setSex = $sessionStorage.setSex = n;
        if(parseInt($scope.setSex) == 1){
            $scope.userSex = $sessionStorage.userSex = '男'
        }else if(parseInt($scope.setSex) == 2){
            $scope.userSex = $sessionStorage.userSex = '女'
        }
        $scope.sexShow = false;
    };
    /*$scope.chooseSex = function () {
        if(parseInt($scope.setSex) == 1){
            $scope.userSex = $sessionStorage.userSex = '男'
        }else if(parseInt($scope.setSex) == 2){
            $scope.userSex = $sessionStorage.userSex = '女'
        }
        $scope.sexShow = false;
    };*/
// 输入姓名
    /*$scope.nameShow = false;
    $scope.inputName = function () {
        $scope.nameShow = true;
    };
    $scope.cancelName = function () {
        $scope.nameShow = false;
    };
    $scope.nameInputOk = function () {
        if($('#y-name').val() == ''){
            $scope.mPop.err('姓名不能为空')
        }else{
            $scope.userName = $sessionStorage.userName = $('#y-name').val();
            $scope.nameShow = false;
        }
    };*/
//    新用户信息填写完毕
    $('#y-id-card').val($sessionStorage.id_card);
    $scope.goMine = function () {
        $sessionStorage.id_card = $('#y-id-card').val();
        $scope.userName = $sessionStorage.userName = $('#y-name').val();
        if($scope.isIdCardNo($('#y-id-card').val())== false){
            $scope.mPop.err('请填写正确的身份证号')
        }else{
            if($sessionStorage.userPhoto == null){ // 头像非必改项
                $scope.upImg = 'img/mine/uploadpic.png';
            }else{
                var data = {
                    token:$sessionStorage.token,
                    name:$scope.userName,
                    sex:parseInt($scope.setSex),
                    headimg:$scope.upImg,
                    id_card:$('#y-id-card').val(),
                    mobile:$scope.userList.mobile
                };
                $http.post('/ruiuser/user-api/add',data).success(function (res) {
                    if(res.errcode == 0){
                        $state.go('layout.mobile.mine')
                    }else if(data.errcode == 9999){
                        $scope.mPop.err('该账号已在别处登录，请重新登录');
                        $timeout(function () {
                            $state.go('login')
                        },2000)
                    }
                });
            }
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
}])
;