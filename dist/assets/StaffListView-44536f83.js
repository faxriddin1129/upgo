import{_ as w,j as p,q as S,c as r,a as o,b as f,k,x,f as _,F as y,r as C,C as V,o as c,e as I,p as L,g as b,y as j}from"./index-e79a3e3f.js";import{_ as B}from"./BackBtnView-d3429739.js";/* empty css             *//* empty css                 *//* empty css                                                                    */import{S as N}from"./StaffCardView-1ed24ede.js";import{u as M}from"./staffStore-66c9d8b6.js";import{S as T}from"./SearchLoader-08b8b259.js";/* empty css                  *//* empty css                         *//* empty css                     */import"./el-dropdown-item-4ed993c7.js";/* empty css                *//* empty css                       *//* empty css                   *//* empty css                   *//* empty css                                                                     */const h=n=>(L("data-v-c8493aea"),n=n(),b(),n),A={class:"staff-list"},D={class:"d-flex align-items-center justify-content-between"},E=h(()=>o("p",{class:"m-0 main-title"},"Xodimlar ro'yhati",-1)),F=h(()=>o("div",null,null,-1)),P={class:"search-input"},$=V('<div class="search-icon" data-v-c8493aea><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" data-v-c8493aea><g clip-path="url(#clip0_723_5)" data-v-c8493aea><path d="M8.33333 14.1667C11.555 14.1667 14.1667 11.555 14.1667 8.33333C14.1667 5.11167 11.555 2.5 8.33333 2.5C5.11167 2.5 2.5 5.11167 2.5 8.33333C2.5 11.555 5.11167 14.1667 8.33333 14.1667Z" stroke="#254A93" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-v-c8493aea></path><path d="M17.5 17.5L12.5 12.5" stroke="#254A93" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-v-c8493aea></path></g><defs data-v-c8493aea><clipPath id="clip0_723_5" data-v-c8493aea><rect width="20" height="20" fill="white" data-v-c8493aea></rect></clipPath></defs></svg></div>',1),q={key:0},H={class:"list-staff-wrap"},Q={__name:"StaffListView",setup(n){const s=p([]),u=M(),d=p(""),i=p(!1),v=function(){j.push({name:"dillerpanel"})},m=function(e){s.value.splice(e,1)};S(()=>{u.LIST().then(e=>{var t,a;e.status===200&&(console.log((t=e==null?void 0:e.data)==null?void 0:t.data),s.value=(a=e==null?void 0:e.data)==null?void 0:a.data,i.value=!0)}).catch(e=>{console.log(e)})});const g=e=>{i.value=!1,d.value.length?u.SEARCH(d.value).then(t=>{var a;s.value=(a=t==null?void 0:t.data)==null?void 0:a.data,i.value=!0}).catch(t=>{console.log("err: ",t)}):u.LIST().then(t=>{var a,l;t.status===200&&(console.log((a=t==null?void 0:t.data)==null?void 0:a.data),s.value=(l=t==null?void 0:t.data)==null?void 0:l.data,i.value=!0)}).catch(t=>{console.log(t)})};return(e,t)=>(c(),r("div",A,[o("div",D,[f(B,{onClick:v}),E,F]),o("div",null,[o("div",null,[o("div",P,[$,k(o("input",{onInput:g,placeholder:"Qidiruv",class:"input-search",type:"search","onUpdate:modelValue":t[0]||(t[0]=a=>d.value=a)},null,544),[[x,d.value]])])])]),i.value?_("",!0):(c(),r("div",q,[f(T)])),o("div",H,[(c(!0),r(y,null,C(s.value,(a,l)=>(c(),r("div",{key:l,class:"mb-3"},[a.status!==0?(c(),I(N,{key:0,job:a.role_format,fullname:`${a.detail[0].first_name} ${a.detail[0].last_name}`,img:a.detail[0].file.url,staff_id:a.id,staff_index:l,userName:a.username,onDeleteId:m},null,8,["job","fullname","img","staff_id","staff_index","userName"])):_("",!0)]))),128))])]))}},lt=w(Q,[["__scopeId","data-v-c8493aea"]]);export{lt as default};