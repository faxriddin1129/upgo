/* empty css             *//* empty css                  */import{_ as z}from"./BackBtnView-d3429739.js";import{_ as S,j as r,q as B,s as b,c as d,a as t,b as l,d as q,t as n,F as j,r as C,H as I,o as _,w as p,J as g,p as Q,g as $,y as v,M as D,i as E}from"./index-e79a3e3f.js";const s=i=>(Q("data-v-d23e673d"),i=i(),$(),i),F={class:"d-flex align-items-center justify-content-between"},N=s(()=>t("p",{class:"m-0 text-center main-title"},"Qarzdorlikni so’ndirish",-1)),V=s(()=>t("div",null,null,-1)),A={class:"total-price__wrap col-md-12"},J=s(()=>t("p",{class:"m-0"},"Jami summa",-1)),L={class:"total-price"},M={class:"d-flex align-items-center justify-content-between mb-2"},H=s(()=>t("p",{class:"title m-0"},"Yetkazilgan vaqti",-1)),R={class:"content fw-bolder m-0"},T={class:"d-flex align-items-center justify-content-between mb-2"},U=s(()=>t("p",{class:"title m-0"},"Buyurtma narxi",-1)),Y={class:"content fw-bolder m-0"},G={class:"d-flex align-items-center justify-content-between mb-2"},K=s(()=>t("p",{class:"title m-0"},"Berilgan narx",-1)),O={class:"content fw-bolder m-0"},P={class:"d-flex align-items-center justify-content-between mb-3"},W=s(()=>t("p",{class:"title m-0"},"Qolgan qarz",-1)),X={class:"content fw-bolder m-0"},Z={__name:"QarzSondirish",setup(i){const y=I(),m=r([]),u=r([]),h=r(0);let k=function(){v.go(-1)};const w=function(e){b.get(`/order/${e}/payment`,{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then(o=>{console.log(o.data),v.push("/dillerpanel")}).catch(o=>{console.log(o)})};return B(()=>{b.get(`/order?filter[debt]=1&filter[client_id]=${y.params.id}&filter[settlement2]=1`,{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then(e=>{console.log(e.data.data),m.value=e.data.data,e.data.data.forEach((o,c)=>{u.value[c]=new Date(o.delivery_time*1e3)}),e.data.data.forEach(o=>{h.value+=o.debt_kil[0].debt_price})}).catch(e=>{console.log(e)})}),(e,o)=>{const c=D,x=E("router-link");return _(),d("div",null,[t("div",F,[l(z,{onClick:q(k)},null,8,["onClick"]),N,V]),t("div",A,[J,t("div",L,n(h.value)+" so'm",1)]),(_(!0),d(j,null,C(m.value,(a,f)=>(_(),d("div",{key:f,class:"qarz-sondirish-card mb-3"},[t("div",M,[H,t("p",R,n(u.value[f].toLocaleDateString("en-US")),1)]),t("div",T,[U,t("p",Y,n(a.update_total_price)+" so’m",1)]),t("div",G,[K,t("p",O,n(a.payment_price?a.payment_price:0)+" so’m ",1)]),t("div",P,[W,t("p",X,n(a.debt_kil[0].debt_price)+" so’m ",1)]),l(c,{onClick:tt=>w(a.id),type:"success",class:"qarzsondirish__btn mb-3"},{default:p(()=>[g("Qarzdorlikni so’ndirish")]),_:2},1032,["onClick"]),l(x,{to:`/more-info/${a.id}`},{default:p(()=>[l(c,{type:"primary",class:"qarzsondirish__btn"},{default:p(()=>[g("Batafsil ma'lumot")]),_:1})]),_:2},1032,["to"])]))),128))])}}},nt=S(Z,[["__scopeId","data-v-d23e673d"]]);export{nt as default};