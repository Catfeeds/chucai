'use strict';
app.controller('addressCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.addressDel = false;//是否删除
    $scope.showMask = false;//遮罩
    $scope.showList = false;//地区列表
    $scope.showMask1 = false;
    $scope.addressDone = false;
    $scope.choose_address1 = 'img/mine/choose.png';
    $scope.choose_address2 = 'img/mine/choose.png';
    $scope.addressFlag = parseInt($stateParams.isDdxq); //判断是否是订单详情页的选择地址
    //设为默认地址
    if(!$sessionStorage.userAddressCity){
        $sessionStorage.userAddressCity = '您所在的地区';
    }
    $scope.setBaseAddress = function (index,id) {
        $http.post('/address/address-api/default-address',{
            id:id,
            token:$sessionStorage.token,
            status:1
        }).success(function (data) {
            if(data.errcode == 0){
                getAddressList();
                $sessionStorage.userAddress = $scope.addressList[index].full_address;
                $sessionStorage.userAddressCity = $scope.addressList[index].address.split(' ')[1];
                // console.log($sessionStorage.userAddress);
                $sessionStorage.addressFlag = false;
            }
        })
    };
    //地址列表获取
    $scope.addressList = [];//地址列表
    $scope.addressList = $sessionStorage.addressList;
    function getAddressList() {
        $http.post('/address/address-api/view',{
            token:$sessionStorage.token,
            start_page:0,
            pages:10
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.addressList =  data.data.list;
            }
        });
    }
    getAddressList();

//    删除地址
    $scope.deleteAddress = function (id) {
        $scope.showMask1 = true;
        $scope.showMask = true;
        $scope.deleteDone = function () {
            $http.post('/address/address-api/delete',{
                id:id,
                token:$sessionStorage.token
            }).success(function (data) {
                if(data.errcode == 0){
                    getAddressList();
                    $scope.showMask1 = false;
                    $scope.showMask = false;
                }
            })
        };
    };
    $scope.showDel = function () {
        $scope.showMask1 = false;
        $scope.showMask = false;
    };
//    修改地址
    $scope.changeAddress = function (id) {
        $state.go('address-choose',{
            item:id
        });
    };
//    去往订单详情
    console.log($scope.addressFlag + ' ' + typeof $scope.addressFlag);
    console.log($sessionStorage.adaptAddress);
    $scope.goDdxq = function (item) {
        $sessionStorage.userAddressCity = item.address.split(' ')[1];
        $sessionStorage.serve_consignee = item.consignee;
        $sessionStorage.serve_tel = item.mobile;
        $sessionStorage.serve_fullAddress = item.full_address;
        $sessionStorage.addressFlag = true; //订单地址首选为手动选择的，而不是默认地址
        if(parseInt($stateParams.isLstd) == 1){
            if(parseInt($stateParams.isDdxq)==3){
                history.go(-3);
            }else if(parseInt($stateParams.isDdxq)==1){
                history.go(-1);
            }
        }else{
            // 体检套餐判断地区符合度
            if($sessionStorage.adaptAddress == '全部'){
                if(parseInt($stateParams.isDdxq)==1){
                    history.go(-1);
                }else if(parseInt($stateParams.isDdxq)==3){
                    history.go(-3);
                }
            }else{
                /*if($sessionStorage.adaptAddress.indexOf(item.address.split(' ')[1]) < 0 ) {
                    $scope.mPop.info('该套餐不支持' + item.address.split(' ')[1]);
                }else{

                }*/
                if(parseInt($stateParams.isDdxq)==1){
                    history.go(-1);
                }else if(parseInt($stateParams.isDdxq)==3){
                    history.go(-3);
                }
            }
        }
    };
//    返回
    $scope.goToBack = function () {
      if(parseInt($stateParams.isDdxq)==3){
          history.go(-3);
      }else if(parseInt($stateParams.isDdxq)==1){
          history.go(-1);
      }
    };
}]);
