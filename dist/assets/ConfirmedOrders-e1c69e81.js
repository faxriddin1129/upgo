/* empty css             *//* empty css                 */import{_ as v}from"./BackBtnView-d3429739.js";import{F as k}from"./FilterLocations-6a4fec6a.js";import{C as y}from"./ClientCardView-5f75ea30.js";/* empty css                                                                    */import{j as m,q as C,s as d,c as a,a as s,b as r,d as p,F as x,r as B,H as b,R as V,o as n,X as $,w as F,f as w,y as I,i as L}from"./index-e79a3e3f.js";import{u as S}from"./filter-ddd7e585.js";/* empty css                  *//* empty css                         *//* empty css                     *//* empty css                    *//* empty css                  *//* empty css                   */import"./el-dropdown-item-4ed993c7.js";/* empty css                */import"./clientStore-8611536b.js";/* empty css                   */const j={class:"d-flex align-items-center justify-content-between mb-4"},q=s("p",{class:"m-0 main-title"},"Buyurtmani tasdiqlash",-1),z={key:0},A={key:0},E={key:1},N=s("p",{class:"text-center"},"Hech qanday buyurtma mavjud emas",-1),H=[N],ne={__name:"ConfirmedOrders",setup(R){const _=S(),u=b(),i=m([]),f=function(){I.go(-1)},l=m(""),h=o=>{l.value.length?d.get(`/order?filter[name]=${l.value}&filter[status]=0`,{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then(e=>{console.log(e.data),i.value=e.data.data}).catch(e=>{console.log(e)}):d.get(`/order?filter[user_id]=${u.params.id}&filter[status]=0`,{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then(e=>{var c;i.value=(c=e==null?void 0:e.data)==null?void 0:c.data}).catch(e=>{console.log(e)})};return C(()=>{d.get(`/order?filter[user_id]=${u.params.id}&filter[status]=0`,{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then(o=>{console.log("asd",o.data.data),i.value=o.data.data}).catch(o=>{console.log(o)})}),(o,e)=>{const c=V,g=L("router-link");return n(),a("div",null,[s("div",j,[r(v,{onClick:f}),q,s("div",null,[r(k)])]),s("div",null,[r(c,{onKeyup:h,modelValue:l.value,"onUpdate:modelValue":e[0]||(e[0]=t=>l.value=t),placeholder:"Qidiruv",type:"search","suffix-icon":p($),class:"mb-3"},null,8,["modelValue","suffix-icon"])]),i.value.length>0?(n(),a("div",z,[(n(!0),a(x,null,B(i.value,t=>(n(),a("div",{key:t,class:"mb-3"},[p(_).locations.checkedCities.includes(t.client.region)?(n(),a("div",A,[r(g,{to:`/confirmed-orders-info/${t.id}`},{default:F(()=>[r(y,{legal_name:t.client.legal_name,img:t.client.file,name:t.client.name},null,8,["legal_name","img","name"])]),_:2},1032,["to"])])):w("",!0)]))),128))])):(n(),a("div",E,H))])}}};export{ne as default};