import{_ as g,n as k,D as w,c as o,a as t,b as d,d as r,F as x,r as S,B as I,o as n,t as _,k as V,v as B,p as F,g as C,y as v,j as m,z as y}from"./index-e79a3e3f.js";import{_ as E}from"./BackBtnView-d3429739.js";import{u as j}from"./staffStore-66c9d8b6.js";import{u as q}from"./useUploadFileStore-2c0d6f39.js";const h=f=>(F("data-v-ce2be0df"),f=f(),C(),f),A={class:"d-flex align-items-center justify-content-between"},O=h(()=>t("p",{class:"m-0 text-center main-title"},"Yangi xodim qo'shish",-1)),z=h(()=>t("div",null,null,-1)),L={class:"form"},M={class:"mb-3"},N={key:0,class:"input-label mb-3"},P={class:"input-wrap"},T=["type"],U={key:1,class:"input-label mb-3"},R={class:"input-wrap"},X=["type","onUpdate:modelValue"],Y={__name:"AddStaffView",setup(f){const a=j(),p=q(),e=k([{label:"Ismi",value:a.staffData.first_name,type:"text"},{label:"Familyasi",value:a.staffData.last_name,type:"text"},{label:"Oylik maoshi",value:a.staffData.salary_int,type:"text"},{label:"Oylik maoshi (%)",value:a.staffData.salary_percent,type:"text"},{label:"Xodim rasmi",value:w(()=>p.fileID),type:"file"},{label:"Telefon raqam (+998995887756) / Login",value:a.staffData.phone,type:"text"},{label:"Parol",value:a.staffData.password,type:"password"},{label:"Parol tasdiqlash",value:a.staffData.password_confirm,type:"password"}]);let b=function(){v.go(-1)},D=function(){let l=m(0);e.forEach((s,u)=>{s.value?s.value.length<1&&(l.value=l.value+1):u!==4&&(l.value=l.value+1)});let i=m(0);e[4].value||(i.value=i.value+1),l.value>0?y.info("Maydonlardagi ma'lumotlar uzunligi 5ta belgidan kam bolmasligi"):i.value>0?y.info("Rasm joylanmagan"):(setTimeout(()=>{v.push("/permissions")},200),a.staffData.first_name=e[0].value,a.staffData.last_name=e[1].value,a.staffData.salary_int=e[2].value,a.staffData.salary_percent=e[3].value,a.staffData.file_id=e[4].value,a.staffData.phone=e[5].value,a.staffData.password=e[6].value,a.staffData.password_confirm=e[7].value)};return(l,i)=>(n(),o("div",null,[t("div",A,[d(E,{onClick:r(b)},null,8,["onClick"]),O,z]),t("div",L,[t("div",M,[(n(!0),o(x,null,S(e,(s,u)=>(n(),o("div",{key:u},[s.type==="file"?(n(),o("div",N,[t("label",null,_(s.label),1),t("div",P,[t("input",{onChange:i[0]||(i[0]=c=>r(p).setFile(c.target.files[0])),type:s.type,class:"input"},null,40,T)])])):(n(),o("div",U,[t("label",null,_(s.label),1),t("div",R,[V(t("input",{type:s.type,class:"input","onUpdate:modelValue":c=>s.value=c},null,8,X),[[B,s.value]])])]))]))),128))]),d(I,{onClick:r(D),text:"Davom etish"},null,8,["onClick"])])]))}},Q=g(Y,[["__scopeId","data-v-ce2be0df"]]);export{Q as default};
