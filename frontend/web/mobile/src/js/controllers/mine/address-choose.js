'use strict';
app.controller('addressChooseCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location','$interval',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location,$interval) {
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
    $scope.addressFlag = $stateParams.isDdxq; //判断是否是订单详情页的选择地址
    //上传数据
    if($stateParams.item){
        $http.post('/address/address-api/view',{
            token:$sessionStorage.token,
            start_page:0,
            pages:99
        }).success(function (data) {
            if(data.errcode == 0){
                $scope.addressList = data.data.list;
                angular.forEach($scope.addressList,function (val) {
                   if(val.id == $stateParams.item){
                       $scope.addressList = val;
                   }
                });
                $scope.option={
                    token:$sessionStorage.token,
                    id:$scope.addressList.id,
                    mobile:$scope.addressList.mobile,
                    consignee:$scope.addressList.consignee,
                    p_id:$scope.addressList.p_id,
                    c_id:$scope.addressList.c_id,
                    d_id:$scope.addressList.d_id,
                    address:$scope.addressList.address,
                    full_address:$scope.addressList.full_address
                };
            }
        });
    }else{
        $scope.option={
            mobile:null,
            token:$sessionStorage.token,
            consignee:null,
            p_id:null,
            c_id:null,
            d_id:null,
            address:null,
            full_address:null
        };
    }
    //数据
    $scope.pieCity={
        pid:'110000',//默认为北京直辖市,其他自动追加
        cid:null,
        did:null,
        city:[],
        district:[],
        show:false
    };
    //获取地址列表
    if($sessionStorage.addressList){
        $scope.rData=$sessionStorage.addressList;
    }else{
        $scope.rData=[];
        $http.post('/base/district-option-api/index',{
            pages:9999
        }).success(function (resp) {
            // console.log($scope.rData);
            if(resp.errcode==0){
                $scope.oData=resp.data.list;
                var pIndex=0;
                //数据分组
                angular.forEach($scope.oData,function (pItem) {
                    if(pItem.level==1){
                        $scope.rData.push({
                            id:pItem.id,
                            level:pItem.level,
                            name:pItem.name,
                            upid:pItem.upid
                        });
                        $scope.rData[pIndex].list=[];
                        var cIndex=0;
                        angular.forEach($scope.oData,function (cItem) {
                            if(cItem.upid==pItem.id && cItem.level==2){
                                $scope.rData[pIndex].list.push({
                                    id:cItem.id,
                                    level:cItem.level,
                                    name:cItem.name,
                                    upid:cItem.upid
                                });
                                $scope.rData[pIndex].list[cIndex].list=[];
                                angular.forEach($scope.oData,function (dItem) {
                                    if(dItem.upid==cItem.id && dItem.level==3){
                                        $scope.rData[pIndex].list[cIndex].list.push({
                                            id:dItem.id,
                                            level:dItem.level,
                                            name:dItem.name,
                                            upid:dItem.upid
                                        });
                                    }
                                });
                                cIndex++
                            }
                        });
                        pIndex++;
                    }
                });
            }
        });
    }
    //增加地址
    $scope.addAddress = function () {
        console.log($scope.pieCity);
        if($stateParams.item){
            $http.post('/address/address-api/update',$scope.option).success(function (res) {
                if(res.errcode == 0){
                    $state.go('address',{isDdxq:3});
                }
            })
        }else{
            $http.post('/address/address-api/add',$scope.option).success(function (resp) {
                if(resp.errcode == 0){
                    // console.log(resp);
                    $state.go('address',{isDdxq:3});
                }
            })
        }
    };
    //阻止默认事件
    document.getElementsByClassName('pie-city')[0].getElementsByClassName('content')[0].addEventListener('touchstart',function (e) {e.stopPropagation();});
    var mRem=$('html').css('font-size');
    var iHeight=Number((parseFloat(mRem)*1.5).toFixed(4));//1.5是1.5rem
    var p_this=$('#pickP');
    var c_this=$('#pickC');
    var d_this=$('#pickD');
    $scope.switchList={
        p:null,
        c:null,
        d:null
    };
    //监听
    document.getElementById('pickP').addEventListener('scroll',_.debounce(scrollP,100));
    document.getElementById('pickC').addEventListener('scroll',_.debounce(scrollC,100));
    document.getElementById('pickD').addEventListener('scroll',_.debounce(scrollD,100));
    function scrollP() {
        var p_top=p_this.scrollTop();
        p_this.find('.pie-item').each(function (i) {
            var top=$(this).position().top;
            if (top>=1.5*iHeight && top<2.5*iHeight) {
                $(this).addClass('ac').siblings().removeClass('ac');
                console.log('pid是', $(this).attr('data-pid'));
                $scope.pieCity.pid = $(this).attr('data-pid');
                if(p_top!=(i-2)*iHeight){
                    p_this.scrollTop((i-2)*iHeight);//矫正
                }
                $scope.setCList(i-2);
                $scope.$apply()
            }
        });
    }
    function scrollC() {
        var c_top=c_this.scrollTop();
        c_this.find('.pie-item').each(function (i) {
            var top=$(this).position().top;
            if (top>=1.5*iHeight && top<2.5*iHeight) {
                $(this).addClass('ac').siblings().removeClass('ac');
                $scope.pieCity.cid = $(this).attr('data-cid');
                if(c_top!=(i-2)*iHeight){
                    c_this.scrollTop((i-2)*iHeight);//矫正
                }
                $scope.setDList(i-2);
                $scope.$apply()
            }

        });
    }
    function scrollD() {
        var d_top=d_this.scrollTop();
        d_this.find('.pie-item').each(function (i) {
            var top=$(this).position().top;
            if (top>=1.5*iHeight && top<2.5*iHeight) {
                $(this).addClass('ac').siblings().removeClass('ac');
                $scope.pieCity.did = $(this).attr('data-did');
                if(d_top!=(i-2)*iHeight){
                    d_this.scrollTop((i-2)*iHeight);//矫正
                }
            }
        });
    }
    //赋值
    $scope.setCList=function(index){
        if($scope.switchList.c!=index){
            $scope.switchList.c=index;
            $scope.pieCity.city=$scope.rData[index].list;
            $scope.pieCity.cid=$scope.pieCity.city[0].id;
            console.log('刷新城市');
            $scope.setDList(0,true)
        }
    };
    $scope.setDList=function(index,type) {
        if($scope.switchList.d!=index || type){
            $scope.switchList.d=index;
            $scope.pieCity.district=$scope.pieCity.city[index].list;
            $scope.pieCity.did=$scope.pieCity.district[0].id;
            console.log('刷新地区');
        }
    };
    //repeat加载完后执行
    $scope.renderFinishP = function(index){
        $('#pickP').scrollTop(0);
        $('#pickP .pie-item').eq(2).addClass('ac');
        $scope.setCList(index)
    };
    $scope.renderFinishC = function(index){
        $('#pickC .pie-item').eq(2).addClass('ac');
        $('#pickC').scrollTop(0);
        $scope.setDList(index);
    };
    $scope.renderFinishD = function(){
        $('#pickD').scrollTop(0);
        $('#pickD .pie-item').eq(2).addClass('ac');
        // console.log('city',$scope.pieCity);
    };
    //地址
    $scope.addConfirm=function () {
        console.log('option',$scope.option);
        console.log('pieCity',$scope.pieCity);
        $scope.option.p_id=$scope.pieCity.pid;
        $scope.option.c_id=$scope.pieCity.cid;
        $scope.option.d_id=$scope.pieCity.did;
        $scope.pieCity.show=false;
        var html='';
        $('.pie-city .content .ac').each(function () {
            html+=$(this).text() + ' ';
        });
        $scope.option.address=html;
    };
    $scope.addCancel=function () {
        $scope.pieCity.show=false;
        $scope.option.address='';
        console.log('取消之后')
    }
}]);
//repeatFinish指令
app.directive('repeatFinish',function(){
    return {
        restrict: 'A',
        link: function(scope,element,attr){
            if(scope.$last == true){
                scope.$eval(attr.repeatFinish)
            }
        }
    }
});