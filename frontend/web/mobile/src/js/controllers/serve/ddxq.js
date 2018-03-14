'use strict';
app.controller('serveDetailCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.xQIsShow = false;
    $scope.payShow = false;
    if($sessionStorage.isHascoupon == true){
        $scope.totalPrice = $sessionStorage.totalPrice = 0;
    }else{
        $scope.totalPrice = $sessionStorage.totalPrice;
    }
    $scope.showChangeXq = function (boo) {
        $scope.xQIsShow = boo;
    };

    $scope.familyName = $sessionStorage.familyName; //体检人名字


//    申请退款
    $scope.closePay = function () {
        $scope.xQIsShow = false;
        $scope.payShow = false;
        $state.go("layout.mobile.serve.all");
    };
    //订单详情总列表
    $scope.detailList = [];
    $scope.package_name = '';
    $http.post('/package/package-api/message',{
        token:$sessionStorage.token,
        id: $stateParams.id //体检中心对应的套餐id
    }).success(function (data) {
        $scope.detailList = data.data.list[0];
        $scope.package_name = $scope.detailList.package_name;
        if($sessionStorage.isHascoupon == true){
            $scope.totalPrice = $sessionStorage.totalPrice = 0;
        }else{
            $scope.totalPrice = $sessionStorage.totalPrice = parseInt($scope.detailList.present_price) + parseInt($sessionStorage.guidePrice) + parseInt($sessionStorage.fare);
        }

    });
//    选择地址
    if($sessionStorage.addressLength == 0){
        $scope.hasAddress = true;
    }else{
        $scope.hasAddress = false;
        if($sessionStorage.addressFlag == true){
            $scope.consignee = $sessionStorage.serve_consignee;
            $scope.tel = $sessionStorage.serve_tel;
            $scope.fullAddress = $sessionStorage.serve_fullAddress;
        }else if($sessionStorage.addressFlag == false){
            $http.post('/address/address-api/view',{
                token:$sessionStorage.token,
                start_page:0,
                pages:10
            }).success(function (data) {
                if(data.errcode == 0){
                    var address = data.data.list;
                    // console.log(address);
                    angular.forEach(address,function (val) {
                        if(val.status == 1){
                            $scope.consignee = $sessionStorage.serve_consignee = val.consignee;
                            $scope.tel = $sessionStorage.serve_tel = val.mobile;
                            $scope.fullAddress = $sessionStorage.serve_fullAddress = val.full_address;
                        }
                    })
                }
            });
        }
    }
    $scope.goChooseAddress = function () {
        $state.go('address',{
            isDdxq:1
        })
    };


//    选择时间
    $scope.data = $sessionStorage.serveDate;
    // console.log($scope.data);
    $scope.goChooseData = function () {
        $state.go('choose-data',{
            id:$stateParams.id
        })
    };

//    选择体检人
    $scope.goChooseFamily = function () {
        $sessionStorage.ddxqFamily = true;
        $state.go('family');
    };

//    选择导医
    $scope.showGuideDoctor = false;
    $scope.guideDoctor = [];
    $scope.showMask = false;
    $scope.guideName = $sessionStorage.guideName;
    $scope.guideIndex = '';
    $scope.guidePrice = $sessionStorage.guidePrice; //导医价格
    $scope.chooseGuideDoctor = function () {
        $http.post('/order/exam-guide-api/index',{
            start_page:0,
            pages:5
        }).success(function (data) {
            $scope.guideDoctor = data.data.list;
            $scope.showGuideDoctor = true;
            $scope.showMask = true;
            console.log(data.data.list)
        });
        $scope.isGuideDoctor = function (index) {
            $scope.guideIndex = index;
            $('.y-g-d-list .y-item').removeClass('active');
            $('.y-g-d-list .y-item').eq(index).addClass('active');
        }
    };
    $scope.closeGuideDoctor = function () {
        $scope.showGuideDoctor = false;
        $scope.showMask = false;
    };
    $scope.okGuideDoctor = function () {
        $sessionStorage.guidePrice = $scope.guideDoctor[$scope.guideIndex].price;
        $scope.guidePrice = $sessionStorage.guidePrice;
        for(var i=0;i<$('.y-g-d-list .y-item').length;i++){
            if($('.y-g-d-list .y-item').eq(i).hasClass('active')){
                $sessionStorage.guideName = $('.y-g-d-list .y-item').eq(i).find('span').eq(0).text();
                $scope.guideName = $sessionStorage.guideName;
            }
        }

        $scope.showGuideDoctor = false;
        $scope.showMask = false;
        if($sessionStorage.isHascoupon == true){
            $scope.totalPrice = $sessionStorage.totalPrice = 0
        }else{
            $sessionStorage.totalPrice = parseInt($scope.detailList.present_price) + parseInt($sessionStorage.guidePrice) + parseInt($sessionStorage.fare);
            $scope.totalPrice = $sessionStorage.totalPrice;
        }

    };
    // 保存留言信息
    if($sessionStorage.textMsg){
        $scope.textMsg = $sessionStorage.textMsg;
    }else{
        $scope.textMsg = '';
    }
    $scope.saveMsg = function () {
        $sessionStorage.textMsg = $scope.textMsg;
    };
    //发票
    $scope.invoice = $sessionStorage.invoice;


    $scope.fare = $sessionStorage.fare;
    if($sessionStorage.invoice =='有'){
        $sessionStorage.fare = '12.00';
        $scope.fare = $sessionStorage.fare;
    }else if($sessionStorage.invoice =='无'){
        $sessionStorage.fare = '0.00';
        $scope.fare = $sessionStorage.fare;
    }
    //返回订单页面
    $scope.goInvoiceDdxq = function () {
        $scope.showInvoice = false;
        $('.y-serve-xq').show();
        if($sessionStorage.invoice =='有'){
            $sessionStorage.fare = '12.00';
            $scope.fare = $sessionStorage.fare;
        }else if($sessionStorage.invoice =='无'){
            $sessionStorage.fare = '0.00';
            $scope.fare = $sessionStorage.fare;
        }
        if($sessionStorage.isHascoupon == true){
            $scope.totalPrice = $sessionStorage.totalPrice = 0
        }else{
            $scope.totalPrice = $sessionStorage.totalPrice = parseInt($scope.detailList.present_price) + parseInt($sessionStorage.guidePrice) + parseInt($sessionStorage.fare);
        }
    };
//    生成待付款订单
//     console.log($scope.fullAddress)
    $scope.goPay = function () {
        if($scope.fullAddress == '请选择地址'){
            $scope.mPop.err('请选择地址!')
        }else if($scope.data == '选择时间'){
            $scope.mPop.err('请选择时间!')
        }else if($scope.familyName == '请选择体检人'){
            $scope.mPop.err('请选择体检人!')
        }else if($scope.guideName == '选择导医'){
            $scope.mPop.err('请选择导医!')
        }else{
            if($sessionStorage.adaptAddress == '全部'){
                $http.post('/order/order-api/add',{
                    token:$sessionStorage.token,
                    package_id:parseInt($stateParams.id),
                    name:$scope.consignee,
                    full_address:$scope.fullAddress,
                    tel:$scope.tel,
                    is_invoice:$sessionStorage.invoice,
                    type:1,
                    message:$('#text_msg').val(),
                    order_type:1,
                    header:$sessionStorage.invoiceHeader,
                    price:parseInt($scope.detailList.present_price),
                    fare:parseInt($sessionStorage.fare),
                    sum_price:parseInt($sessionStorage.totalPrice),
                    exam_time:$scope.data,
                    exam_people:$scope.familyName,
                    guider:$scope.guideName,
                    guide_price:parseInt($sessionStorage.guidePrice),
                    package_name:$scope.package_name,
                    institution_name:$scope.detailList.institution.name,
                    coupn_id:parseInt($stateParams.coupon_id),
                    family_id:parseInt($sessionStorage.familyId)
                }).success(function (res) {
                    if(res.errcode == 0){
                        // console.log('订单生成成功');
                        $http.post('/order/order-api/index',{
                            token:$sessionStorage.token,
                            start_page:0,
                            pages:1,
                            type:1
                        }).success(function (data) {
                            if(data.errcode == 0){
                                // $scope.dfkList = data;
                                // console.log(data.data.list[0].id);
                                // 服务板块-全部
                                $http.post('/order/order-api/index',{
                                    token:$sessionStorage.token,
                                    start_page:0,
                                    pages:20,
                                    type:0
                                }).success(function (data) {
                                    if(data.errcode == 0){
                                        $scope.allTotal_pages = data.data.total_pages;
                                        $sessionStorage.serveList = data.data.list;
                                    }
                                });
                                $state.go('tjyyPay',{
                                    id:data.data.list[0].id,
                                    coupon_id:parseInt($stateParams.coupon_id)
                                });
                            }
                        });
                    }
                });
            }else{
                /*if($sessionStorage.adaptAddress.indexOf($sessionStorage.userAddressCity) < 0 ) {
                    $scope.mPop.info('该套餐不支持' + $sessionStorage.userAddressCity);
                }else{

                }*/
                $http.post('/order/order-api/add',{
                    token:$sessionStorage.token,
                    package_id:parseInt($stateParams.id),
                    name:$scope.consignee,
                    full_address:$scope.fullAddress,
                    tel:$scope.tel,
                    is_invoice:$sessionStorage.invoice,
                    type:1,
                    message:$('#text_msg').val(),
                    order_type:1,
                    header:$sessionStorage.invoiceHeader,
                    price:parseInt($scope.detailList.present_price),
                    fare:parseInt($sessionStorage.fare),
                    sum_price:parseInt($sessionStorage.totalPrice),
                    exam_time:$scope.data,
                    exam_people:$scope.familyName,
                    guider:$scope.guideName,
                    guide_price:parseInt($sessionStorage.guidePrice),
                    package_name:$scope.package_name,
                    institution_name:$scope.detailList.institution.name,
                    coupn_id:parseInt($stateParams.coupon_id),
                    family_id:parseInt($sessionStorage.familyId)
                }).success(function (res) {
                    if(res.errcode == 0){
                        // console.log('订单生成成功');
                        $http.post('/order/order-api/index',{
                            token:$sessionStorage.token,
                            start_page:0,
                            pages:1,
                            type:1
                        }).success(function (data) {
                            if(data.errcode == 0){
                                // $scope.dfkList = data;
                                // console.log(data.data.list[0].id);
                                // 服务板块-全部
                                $http.post('/order/order-api/index',{
                                    token:$sessionStorage.token,
                                    start_page:0,
                                    pages:20,
                                    type:0
                                }).success(function (data) {
                                    if(data.errcode == 0){
                                        $scope.allTotal_pages = data.data.total_pages;
                                        $sessionStorage.serveList = data.data.list;
                                    }
                                });
                                $state.go('tjyyPay',{
                                    id:data.data.list[0].id,
                                    coupon_id:parseInt($stateParams.coupon_id),
                                    code:$stateParams.code
                                });
                            }
                        });
                    }
                });
            }
        }
    };
}])
;
