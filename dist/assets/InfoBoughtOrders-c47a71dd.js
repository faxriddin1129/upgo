import{T as m}from"./TableView-52bca027.js";import{C as u}from"./ClientCardView-5f75ea30.js";import{_ as p,j as n,q as h,s as v,c as f,a as t,b as l,t as o,f as g,H as C,o as w,p as x,g as y,y as b}from"./index-e79a3e3f.js";import{_ as B}from"./BackBtnView-d3429739.js";/* empty css             *//* empty css                  *//* empty css                   *//* empty css                  *//* empty css                 *//* empty css                         *//* empty css                     */import"./el-dropdown-item-4ed993c7.js";/* empty css                */import"./clientStore-8611536b.js";/* empty css                   */const s=i=>(x("data-v-6af03f29"),i=i(),y(),i),k={key:0},I={class:"d-flex align-items-center justify-content-between mb-5"},S=s(()=>t("p",{class:"m-0 main-title"},"Buyurtmani qaytarish",-1)),V=s(()=>t("div",null,null,-1)),j={class:"mb-3"},M={class:"order-card"},D=s(()=>t("p",{class:"underline-title"},"Buyurtma oluvchi",-1)),Z={class:"d-flex align-items-center gap-3 mb-3"},q=s(()=>t("svg",{width:"20",height:"20",viewBox:"0 0 20 20",fill:"none",xmlns:"http://www.w3.org/2000/svg"},[t("path",{d:"M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C11.93 4 13.5 5.57 13.5 7.5C13.5 9.43 11.93 11 10 11C8.07 11 6.5 9.43 6.5 7.5C6.5 5.57 8.07 4 10 4ZM10 18C7.97 18 5.57 17.18 3.86 15.12C5.55 13.8 7.68 13 10 13C12.32 13 14.45 13.8 16.14 15.12C14.43 17.18 12.03 18 10 18Z",fill:"black","fill-opacity":"0.4"})],-1)),L={class:"agent m-0"},N={class:"d-flex align-items-center gap-3"},O=s(()=>t("svg",{width:"18",height:"18",viewBox:"0 0 18 18",fill:"none",xmlns:"http://www.w3.org/2000/svg"},[t("path",{d:"M17.01 12.38C15.78 12.38 14.59 12.18 13.48 11.82C13.13 11.7 12.74 11.79 12.47 12.06L10.9 14.03C8.07 12.68 5.42 10.13 4.01 7.2L5.96 5.54C6.23 5.26 6.31 4.87 6.2 4.52C5.83 3.41 5.64 2.22 5.64 0.99C5.64 0.45 5.19 0 4.65 0H1.19C0.65 0 0 0.24 0 0.99C0 10.28 7.73 18 17.01 18C17.72 18 18 17.37 18 16.82V13.37C18 12.83 17.55 12.38 17.01 12.38Z",fill:"black","fill-opacity":"0.4"})],-1)),T={class:"phone m-0"},$={class:"order-card d-flex flex-column mt-4 gap-3"},z={class:"d-flex align-items-center justify-content-between"},H=s(()=>t("p",{class:"title m-0"},"Yetkazish vaqti",-1)),A={class:"text m-0"},E={class:"d-flex align-items-center justify-content-between"},F=s(()=>t("p",{class:"title m-0"},"Jami narxi",-1)),J={class:"text price m-0"},R={class:"d-flex align-items-center justify-content-between"},U=s(()=>t("p",{class:"title m-0"},"To’lov usuli",-1)),Y={class:"text payment m-0"},G={__name:"InfoBoughtOrders",setup(i){const r=C(),e=n({}),c=n(!1),_=function(){b.go(-1)},d=n("");return h(async()=>{await v.get(`/order/${r.params.id}`,{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then(a=>{e.value=a.data.data,console.log(a.data.data),d.value=new Date(a.data.data.delivery_time*1e3),c.value=!0}).catch(a=>{console.log(a)})}),(a,K)=>c.value?(w(),f("div",k,[t("div",I,[l(B,{onClick:_}),S,V]),t("div",j,[l(u,{legal_name:e.value.client.legal_name,name:e.value.client.name,img:e.value.client.file},null,8,["legal_name","name","img"])]),t("div",null,[t("div",M,[D,t("div",Z,[q,t("p",L,o(e.value.user.detail[0].first_name)+" "+o(e.value.user.detail[0].last_name),1)]),t("div",N,[O,t("p",T,o(e.value.user.username),1)])])]),t("div",null,[t("div",$,[t("div",z,[H,t("p",A,o(d.value.toLocaleDateString("en-US")),1)]),t("div",E,[F,t("p",J,o(e.value.total_price)+" so’m",1)]),t("div",R,[U,t("p",Y,o(e.value.payment_type.name),1)])])]),t("div",null,[l(m,{route:a.$route.name,product:e.value.products},null,8,["route","product"])])])):g("",!0)}},_t=p(G,[["__scopeId","data-v-6af03f29"]]);export{_t as default};
