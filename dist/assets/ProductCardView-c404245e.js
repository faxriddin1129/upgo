import{_ as o,o as d,c as r,a as t,t as c}from"./index-e79a3e3f.js";const a={class:"product-card-wrapper d-flex align-items-center"},n={class:"product-card left-part d-flex align-items-center gap-3 w-100"},_={class:"img-wrap"},i=["src"],p={class:"long-text d-flex flex-column justify-content-center"},l={class:"m-0 id-name"},u={class:"product-name m-0"},m={class:"product-card right-part d-flex justify-content-center"},f={class:"d-flex flex-column align-items-center"},h={class:"m-0 count"},x={class:"m-0 count-text"},g={__name:"ProductCardView",props:{product:{type:Object,required:!0}},setup(s){const e=s;return(v,w)=>(d(),r("div",a,[t("div",n,[t("div",_,[t("img",{src:e.product.product.file,alt:"product"},null,8,i)]),t("div",p,[t("p",l,"ID: "+c(e.product.product_id),1),t("p",u,c(e.product.product.name),1)])]),t("div",m,[t("div",f,[t("p",h,c(e.product.count),1),t("p",x,c(e.product.product.measure),1)])])]))}},P=o(g,[["__scopeId","data-v-64db5a82"]]);export{P};
