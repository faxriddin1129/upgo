/* empty css             *//* empty css                 */import{_ as k}from"./BackBtnView-d3429739.js";/* empty css                  *//* empty css                         *//* empty css                     */import"./filter-ddd7e585.js";/* empty css                    */import{j as u,q as y,s as r,c as i,b as l,a as n,d as S,F as b,r as x,R as B,o as d,W as I,X as C,w as V,y as w,i as m}from"./index-e79a3e3f.js";/* empty css                                                                   *//* empty css                                                                    *//* empty css                                                                            */import"./stockStore-576318a6.js";import"./stock-b7c92c55.js";import{P as L}from"./ProductCardView-c404245e.js";const $={key:0},z={key:1},A={class:"d-flex align-items-center justify-content-between mb-5"},j=n("p",{class:"m-0 main-title"},"Mahsulot ayirish",-1),E=n("div",null,null,-1),N={class:"flex justify-center"},Z={__name:"SubtractListProductView",setup(P){const p=function(){w.push({name:"Business"})},h=(e,t)=>{localStorage.setItem("itemID",e),localStorage.setItem("product",JSON.stringify(t))},a=u({load:!0,data:[],searchload:!0}),s=u(""),_=u([]);y(()=>{r.get("/stock",{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then(e=>{var t;console.log("stockca",e.data.data),a.value.data=(t=e==null?void 0:e.data)==null?void 0:t.data,a.value.load=!1}).catch(e=>{console.log(e)}),r.get("/category",{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then(e=>{var t;console.log(e.data),_.value=(t=e==null?void 0:e.data)==null?void 0:t.data}).catch(e=>{console.log(e)})});const g=e=>{a.searchload=!1,s.value.length?r.get(`/stock?filter[name]=${s.value}`,{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then(t=>{console.log(t.data),a.value.data=t.data.data,a.value.searchload=!0}).catch(t=>{console.log(t)}):r.get("/stock",{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then(t=>{var c;a.value.data=(c=t==null?void 0:t.data)==null?void 0:c.data,a.value.load=!1}).catch(t=>{console.log(t)})};return(e,t)=>{const c=B,f=m("SearchLoader"),v=m("router-link");return a.value.load?(d(),i("div",$,[l(I)])):(d(),i("div",z,[n("div",A,[l(k,{onClick:p}),j,E]),n("div",null,[l(c,{modelValue:s.value,"onUpdate:modelValue":t[0]||(t[0]=o=>s.value=o),class:"w-100 m-2 block mx-auto rounded-lg my-3",size:"small",placeholder:"Qidiruv","suffix-icon":S(C),onKeyup:g},null,8,["modelValue","suffix-icon"])]),n("div",N,[l(f)]),(d(!0),i(b,null,x(a.value.data,o=>(d(),i("div",{key:o,class:"mb-3"},[l(v,{to:"/dillerpanel/business/subtract-list-product/subtract"},{default:V(()=>[l(L,{onClick:F=>h(o.product_id,o),product:o},null,8,["onClick","product"])]),_:2},1024)]))),128))]))}}};export{Z as default};