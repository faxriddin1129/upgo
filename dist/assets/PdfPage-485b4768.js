import{j as c,q as b,s as g,d as s,c as d,a as t,t as e,F as v,r as y,a2 as m,f as w,H as x,o as r}from"./index-e79a3e3f.js";const B={class:"title-top"},k={class:"text-center"},D={class:"row"},P={class:"col-md-6 col-6 col-sm-6"},z={class:"d-flex align-items-start gap-2 mb-1"},M=t("p",{class:"m-0 fw-bolder"},"Bajaruvchi:",-1),N={class:"m-0"},S={class:"d-flex align-items-start gap-2 mb-1"},T=t("p",{class:"m-0 fw-bolder"},"Manzil:",-1),q={class:"m-0"},C={class:"d-flex align-items-start gap-2 mb-1"},L=t("p",{class:"m-0 fw-bolder"},"Telefon:",-1),$={class:"m-0"},j={class:"d-flex align-items-start gap-2 mb-1"},A=t("p",{class:"m-0 fw-bolder"},"Director:",-1),E={class:"m-0"},F={class:"col-md-6 col-6 col-sm-6"},Q={class:"d-flex align-items-start gap-2 mb-1"},R=t("p",{class:"m-0 fw-bolder"},"Buyurtmachi:",-1),U={class:"m-0"},V={class:"d-flex align-items-start gap-2 mb-1"},H=t("p",{class:"m-0 fw-bolder"},"Manzil:",-1),I={class:"m-0"},J={class:"d-flex align-items-start gap-2 mb-1"},K=t("p",{class:"m-0 fw-bolder"},"Telefon:",-1),O={class:"m-0"},Y={class:"d-flex align-items-start gap-2 mb-1"},G=t("p",{class:"m-0 fw-bolder"},"Director:",-1),W={class:"m-0"},X={class:"pt-4 table-wrap mb-4"},Z=t("h6",null,"Mahsulotlar ro'yhati",-1),tt={class:"table mb-5"},st=t("tr",null,[t("th",null,"N"),t("th",null,"Mahsulot nomi"),t("th",null,"Mahsulot birligi"),t("th",null,"Narxi (so'm)")],-1),et={class:"table"},at=t("th",null,"Buyurtma narxi",-1),lt=t("th",null,"Jami narxi",-1),ot={class:"mb-5"},nt={class:"row"},ct=t("div",{class:"col-md-6 col-6"},[t("h6",null,"Buyurtma oluvchi:"),t("h6",null,"Buyurtmani yetkazib beruvchi:"),t("h6",null,"Buyurtma olingan vaqti:"),t("h6",null,"Buyurtma yetkazilgan vaqti:")],-1),it={class:"col-md-6 col-6"},_t={__name:"PdfPage",setup(dt){const p=x();let _=c(!1);const f=function(){_.value=!0,setTimeout(()=>{window.print()},50)};let a=c(null),l=c(0);c(0);let u=c(!1);return b(()=>{g.get(`/order/${p.params.id}`,{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then(o=>{console.log(o.data.data),a.value=o.data.data,a.value.products.forEach(i=>{l.value+=i.product.sell_price*i.count}),u.value=!0}).catch(o=>{console.log(o)})}),(o,i)=>s(u)?(r(),d("div",{key:0,class:m(["pdf-wrap",this.$route.name=="PdfPage"?"main":""])},[t("div",B,[t("p",k,"BUYURTMA N"+e(s(a).id),1)]),t("div",D,[t("div",P,[t("div",z,[M,t("p",N,e(s(a).client.legal_name),1)]),t("div",S,[T,t("p",q,e(s(a).client.address),1)]),t("div",C,[L,t("p",$,e(s(a).client.phone),1)]),t("div",j,[A,t("p",E,e(s(a).client.full_name),1)])]),t("div",F,[t("div",Q,[R,t("p",U,e(s(a).user.detail[0].legal_name),1)]),t("div",V,[H,t("p",I,e(s(a).user.detail[0].address),1)]),t("div",J,[K,t("p",O,e(s(a).user.username),1)]),t("div",Y,[G,t("p",W,e(s(a).user.detail[0].first_name),1)])])]),t("div",X,[Z,t("table",tt,[st,(r(!0),d(v,null,y(s(a).products,(n,h)=>(r(),d("tr",{key:h},[t("td",null,e(h+1),1),t("td",null,e(n.product.name),1),t("td",null,e(n.count)+" "+e(n.product.measure),1),t("td",null,e(n.product.sell_price*n.count),1)]))),128))]),t("table",et,[t("tr",null,[at,t("th",null,"Keshback("+e(s(a).cashback)+"%)",1),lt]),t("tr",null,[t("td",null,e(s(l)),1),t("td",null,e(s(l)*s(a).cashback/100),1),t("td",null,e(s(l)-s(l)*s(a).cashback/100),1)])])]),t("h6",ot," Buyurtma narxi: "+e(s(l)-s(l)*s(a).cashback/100)+" so'm, QQSsiz ",1),t("div",nt,[ct,t("div",it,[t("h6",null,e(s(a).client.full_name),1),t("h6",null,e(s(a).user.detail[0].first_name),1),t("h6",null,e(new Date(s(a).created_at*1e3).toLocaleDateString("en")),1),t("h6",null,e(new Date(s(a).delivery_time*1e3).toLocaleDateString("en")),1)])]),t("button",{class:m(["btn btn-primary w-100 mt-3",s(_)?"isOpacity":""]),onClick:f}," Pdf ",2)],2)):w("",!0)}};export{_t as default};
