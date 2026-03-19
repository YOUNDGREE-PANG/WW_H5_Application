


<template>
<van-nav-bar
  title="报名助手"
  left-arrow
  @click-left="onClickLeft"

/>




<van-form  >

  <van-cell-group inset style="margin-top:5%">

  <van-field
  style="color:#1989fa"
    label="订单信息"
    class="icon icon-titles"
    disabled
  />
  



<!-- 通过 pattern 进行正则校验 -->
    <van-field
      v-model="user_name"
      name="user_name"
      placeholder="请输入客户的姓名"
      label="客户姓名"
      :rules="[{ pattern, message: '请输入正确内容' }]"/>










<van-field
  v-model="bussines1"
  is-link
  readonly
  name="bussines1"
  label="业务类型"
  placeholder="请选择业务类型"
  @click="showPicker1(true)"
/>
<van-popup v-model:show="show_it1" destroy-on-close position="bottom">
  <van-picker

    :columns="columns_data1"
    :model-value="pickerValue1"
    @confirm="onConfirm1"
    @cancel="showPicker1(false)"
  />
</van-popup>



<van-field
  v-model="bussines2"
  is-link
  readonly
  name="bussines2"
  label="专业/工种"
  placeholder="请选择专业/工种"
   @click="showPicker2(true)"
/>
<van-popup v-model:show="show_it2" destroy-on-close position="bottom">
  <van-picker

    :columns="columns_data8"
    :model-value="pickerValue2"
    @confirm="onConfirm2"
    @cancel="showPicker2(false)"
  />
</van-popup>
  



<van-field name="radio" >
  <template #input>
    <van-radio-group v-model="bussines_type" direction="horizontal" @change="chossed_value">
      <van-radio v-for="option in radioOptions"  :key="option.label" :name="option.value">{{option.label}}</van-radio>
    </van-radio-group>
  </template>
</van-field>









    <!-- 通过 validator 进行函数校验 -->
    <van-field
      v-model="price"
      name="price"
      placeholder="订单金额"
      label="订单金额"
      :rules="[{ validator,message: '请输入正确内容' }]"/>

 
 
    <!--<van-field
      v-model="subtract"
      name="subtract"
      placeholder="减免金额"
      label="减免金额"
      :rules="[{ validator,message: '请输入正确内容' }]"/>-->
  


<van-field name="radio" label="收款单位">
  <template #input>
    <van-radio-group v-model="componey" direction="horizontal">
      <van-radio name="1">筑信学校</van-radio>
      <van-radio name="2" icon-size="18px">筑信企业</van-radio>
    </van-radio-group>
  </template>
</van-field>

</van-cell-group>






  <div style="margin: 16px;"  >
    <van-button round block  type="primary"  @click="SentMessage()">
      提交
    </van-button>
  </div>
</van-form>

<div id="ww_login" style="max-width:25rem;height:" ></div>

</template>

<script >
//
import { Field, CellGroup } from 'vant';
import { closeToast, showLoadingToast } from 'vant';
import { NavBar } from 'vant';
import { showToast } from 'vant';
import { ref } from 'vue';
import { createApp } from 'vue';
import * as ww from '@wecom/jssdk';
import axios from 'axios';
import { Cell } from 'vant';
import { Switch } from 'vant';
import sha1 from 'js-sha1';
import { getCurrentInstance } from "vue";
import { Picker } from 'vant';
import { onMounted, onBeforeUnmount } from 'vue';

const app = createApp();
app.use(ww) //注册


   showToast("登陆前depart="+localStorage.getItem('ww_user_id'));

export default {

 data() {
  return {
    getConfigSignature: '',
    getAgentConfigSignature: '',
    timestamp:'',
    nonceStr:'',
    signature:'',
     columns_data1:[],
     columns_data8:[],
    componey:ref('1'),
    can_edit:ref(true),
    subtract:ref(0),
    checked_value:[],





  };
},


setup() {//组件安装后函数


     
   
    const ww= ref('');
    const user_name = ref('');
    const price = ref('');
    const chossed_type = ref('');
    const onClickLeft = () => history.back();
    const onClickRight = () => showToast('按钮');
    const pattern = /[\u4E00-\u9FA5]/;
    const validator = (val) =>/^\d+(\.\d{1,2})?$/.test(val);
    const checked_value= ref([]);
    const bussines1 = ref('');
    const bussines2 = ref('');
    const radioOptions= ref([]);
    const pickerValue1 = ref([]);
    const pickerValue2 = ref([]);
    const show_it1 = ref(false);
    const show_it2 = ref(false);
    const bussines_type= ref([]);
    const bussines_id= ref('');
    const url7 = 'https://www.test.com/api/index/get_jdy_entry_list'; 





   
    


   const onConfirm1 = ({ selectedValues, selectedOptions }) => {//监听选择器选择项
    bussines1.value = selectedOptions[0]?.text;
    pickerValue1.value = selectedValues;
    price.value ='';
   
    show_it1.value = false;
   
    };  
    

   const onConfirm2 = ({ selectedValues, selectedOptions }) => {//监听选择器选择项
    bussines2.value = selectedOptions[0]?.text;
    pickerValue2.value = selectedValues;
    price.value ='';
   

    show_it2.value = false;



 const headers1 = {//工种数据
        'Content-Type': 'application/json', // 设置请求头为JSON格式
      };


      const data3 = {
      
      "yewu":pickerValue1.value[0],
      "gong":pickerValue2.value[0]

      };

      showToast('数据加载中！');
  axios.post(url7, data3, { headers1 })
        .then(response2 => {
    //从后端获取数据并更新columns
   const columns_data4 = response2.data.map(item =>item.type);
   const columns_data5 = response2.data.map(item =>item.price);
   const columns_dataA =Array.from(new Set(columns_data4));
   const columns_dataB =Array.from(new Set(columns_data5));
    const columns_dataC =  columns_dataA.map((label, index) => ({label, value: columns_dataB[index] }));
console.log(columns_dataC);

  radioOptions.value=columns_dataC;

     


        })
        .catch(error => {
        
          console.error('Error:', error); // 处理错误情况
        });






    show_it2.value = false;
    // pickerValue.value = ref([]);
    }; 

  
    return {
  bussines_type,
    bussines_id,
      Switch,
      radioOptions,
      bussines1,
      bussines2,
      pickerValue1,
      pickerValue2,
      //columns,
      //columns_data,
      onConfirm1,
      onConfirm2,
      show_it1,
      show_it2,
    onClickLeft, 
    onClickRight,
    NavBar,
    Field,
    Cell,
    CellGroup,
    closeToast,
      showLoadingToast,
      pattern,
      validator,
      ref,
      user_name,
      price,
      chossed_type,
      ww,
      //getConfigSignature,
      //getAgentConfigSignature
    
    };



  },

    methods: {



showPicker1(e){

this.price='';
this.bussines2='';
this.bussines_type='';
this.radioOptions=[];
  if(e==false){
 this.show_it1 = false;

}else{

this.show_it1 = true;
}

},
showPicker2(e){



let yewu=this.pickerValue1;

this.radioOptions=[];
this.bussines_type='';
this.price='';

if(yewu==''){

 showToast("请先选择前置选项！");


}else{
  if(e==false){
 this.show_it2 = false;

}else{

 const url12 = 'https://www.test.com/api/index/get_jdy_entry_list'; 
 const headers7 = {//工种数据
        'Content-Type': 'application/json', // 设置请求头为JSON格式
      };


      const data7 = {

      "yewu":this.pickerValue1[0]


      };

    
  axios.post(url12,data7, { headers7 })
        .then(response7 => {
    //从后端获取数据并更新columns
    //从后端获取数据并更新columns
   const columns_data7 = response7.data.map(item => item.gong);

  const columns_data10 =Array.from(new Set(columns_data7 ));
   console.log(columns_data10);
 const columns_data11 = columns_data10.map(item =>({
   "text": item,
   "value": item

}));

  this.columns_data8=columns_data11;
     this.show_it2 = true;



        })
        .catch(error => {
        
          console.error('Error:', error); // 处理错误情况
        });


}

}




},



 fetchData() {





if(localStorage.getItem('ww_user_id')==null||localStorage.getItem('ww_user_name')==null){
 // 初始化登录组件 
 const wwLogin= ww.createWWLoginPanel({
  el: '#ww_login',
  params: {
    login_type: 'CorpApp',
    appid: '你的企微应用ID',
    agentid: '1000108',
    // redirect_uri 必须是配置在应用可信域名下的地址，且需要编码
    redirect_uri: 'https://scrm.zhuxinedu.com',
    state: 'loginState',
    redirect_type: 'callback',
  },
  onCheckWeComLogin({ isWeComLogin }) {
    console.log(isWeComLogin)
  },
  onLoginSuccess({ code }) {
  

  const url3 = 'https://www.test.com/api/index/ww_get_user_info'; //登录企微
    const headers3 = {
        'Content-Type': 'application/json', // 设置请求头为JSON格式
      };
      const data3 = {
        code:code,
      };

  axios.post(url3, data3, { headers3 })
        .then(response3 => {
             showToast(response3.data.ww_user_id);
          
     
   
        localStorage.setItem('ww_user_id',response3.data.ww_user_id);
        localStorage.setItem('ww_department',response3.data.ww_department);
        localStorage.setItem('ww_user_name',response3.data.ww_user_name);
       
   
        wwLogin.unmount()   //卸载登陆面板

        })
        .catch(error => {
        
          showToast(error); // 处理错误情况
        });

 showToast("登录成功！"+localStorage.getItem('ww_department'));

  },
  onLoginFail(err) {
    console.log(err)
  },
})


}





 
const url1 = 'https://www.test.com/api/index/get_bussines_choose_data'; 

    const headers2 = {//工种数据
        'Content-Type': 'application/json', // 设置请求头为JSON格式
      };
      const data2 = {
      
      "field":"yewu"

      };

    
  axios.post(url1, data2, { headers2 })
        .then(response2 => {
    //从后端获取数据并更新columns
   const columns_data3 = response2.data.map(item => ({
   "text": item,
   "value": item,
  
}));

  this.columns_data1=columns_data3;
     


        })
        .catch(error => {
        
          console.error('Error:', error); // 处理错误情况
        });




 


const get_url = window.location.href.split('#')[0];

axios.get('https://www.test.com/api/index/get_agent_signature')
  .then(response => {
    //alert(response.data);
   const agent_ticket_info=response.data;
 
ww.register({
  corpId: '你的企微应用ID',       // 必填，当前用户企业所属企业ID
  agentId: 1000108,                  // 必填，当前应用的AgentID
  jsApiList: ['sendChatMessage'], // 必填，需要使用的JSAPI列表
  getAgentConfigSignature,            // 必填，根据url生成应用签名的回调函数
  onAgentConfigSuccess,
  onAgentConfigFail,
})
async function getAgentConfigSignature(get_url) {

    const randomNumber = Math.floor(Math.random() * Math.pow(36, 6));
    const timestamp = Date.now();
    //var this_url="https://scrm.zhuxinedu.com/";
    var this_url=window.location.href.split('#')[0]; 
    var this_noncestr=randomNumber.toString(36).slice(0, 6);
    var agent_ticket=agent_ticket_info;
    var this_timestamp = Math.floor(timestamp / 1000); // 转换为十位时间戳
    var fina_data="jsapi_ticket="+agent_ticket+"&noncestr="+this_noncestr+"&timestamp="+this_timestamp+"&url="+this_url;
    var this_agent_signature= sha1(fina_data);
    //alert("timestamp="+this_timestamp+"agent_ticket="+agent_ticket+"url="+this_url+"agent_signature="+this_agent_signature+"noncestr="+this_noncestr);

  return {timestamp:this_timestamp,nonceStr:this_noncestr,signature:this_agent_signature }

  }


  async function onAgentConfigSuccess(res2) {

  //showToast("onAgentConfigSuccess成功:"+res2)

  }

  async function onAgentConfigFail(res3) {

  showToast("getonAgentConfig失败！:"+JSON.stringify(res3));

  }



 })
  .catch(error => {
    console.error('There was an error!', error);
  });

    
    },

    chossed_value(e){
     
    // this.bussines_type=value;
  this.price=this.bussines_type;
   this.checked_value = this.radioOptions.find(item => item.value === this.bussines_type);

   

    },

    SentMessage() {



    alert(this.price);


if(localStorage.getItem('ww_user_id')==null||localStorage.getItem('ww_user_name')==null||localStorage.getItem('ww_department')==null){
  
 showToast("请先登录！");
localStorage.removeItem('ww_user_id');//防止旧版登录态
localStorage.removeItem('ww_user_name');

}else{
  

 const today = new Date();
    // 格式化日期为 yyyy-mm-dd 形式
    const dateString = today.toISOString().slice(0, 10);

    // 生成五位随机数
    const randomNumber = Math.floor(Math.random() * 100000) // 注意这里乘以100000是为了确保至少有5位数字，但实际上我们只需要5位，所以稍后我们会调整
        .toString() // 将数字转换为字符串
        .slice(-5); // 取最后5位数字，确保是5位数

    // 组合日期和随机数
    const order_id = dateString + randomNumber;



   const url2 = 'https://www.test.com/api/index/sent_reg_info'; //发送报名信息到简道云
   const headers = {
        'Content-Type': 'application/json', // 设置请求头为JSON格式
      };
   

  const data2 = {
      user_name:this.user_name,
      price:this.price,
      bussines_type:this.bussines1,
      subject:this.bussines2,
      type:this.checked_value.label,
      subtract:this.subtract,
      componey:this.componey,
      can_edit:this.can_edit,
      ww_department:localStorage.getItem('ww_department'),
      ww_user_id:localStorage.getItem('ww_user_id'),
      ww_user_name:localStorage.getItem('ww_user_name'),
      order_id:order_id
      };


//if(this.price==''||this.checked_value.label=='undefined'||this.user_name==''||this.bussines2==''||this.bussines1==''||this.subtract==''||this.componey==''||this.can_edit==''){
if(this.price==''||this.checked_value.label=='undefined'||this.user_name==''||this.bussines2==''||this.bussines1==''||this.componey==''||this.can_edit==''){
  
  showToast('请完整填写！');

}else{
  

 axios.post(url2, data2, { headers })
        .then(response => {    

  if(response.data=="Failed"){

  showToast("不允许的业务！");

  }else{

   showToast("生成订单成功！");

       ww.sendChatMessage({
  msgtype: 'miniprogram',
 miniprogram:
  {
    appid: "wx6**********e23",//小程序的appid，企业已关联的任一个小程序
    title: this.user_name+this.bussines1+this.bussines2+this.checked_value.label, //小程序消息的title
    imgUrl:"https://www.test.com/assets/img/qwsk.jpg",//小程序消息的封面图。必须带http或者https协议头，否则报错 $apiName$:fail invalid imgUrl
    page: "pages/index/index.html?order_id="+order_id,//小程序消息打开后的路径，注意要以.html作为后缀，否则在微信端打开会提示找不到页面
  },
  success: function (res4) {


  showToast("生成小程序成功！");

    },
  fail: function (res5) {
        showToast("getCurExternal失败！:"+JSON.stringify(res5));
        //alert("失败:",res5)

    },
})

  }

  })
        .catch(error => {
         showToast(error);
          console.error('Error:', error); // 处理错误情况
        });


}

 


}



    }
  },
 mounted() {
 //组件挂载后函数
    this.fetchData(); //就获取数据
    const meta = document.querySelector('meta[name="viewport"]');
    if (meta) {
      meta.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
    }
  }
}
</script>
<style>
body{
backround:red
}

#van-field-1-label{
color:black
}

iframe{
max-width:90%;  
margin-left:5%

}
</style>
