import{s as t}from"./index-e79a3e3f.js";const n={CREATE(e){return t.post("/diller",e,{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}})},LIST(){return t.get("/diller",{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}})},ITEM(e){const r=localStorage.getItem("token");return t.get(`/diller/${e}`,{headers:{Authorization:`Bearer ${r}`}})},STATUS(e,r,o){const a=localStorage.getItem("token");return t.post(`/diller/${e}?status=${r}`,o,{headers:{Authorization:`Bearer ${a}`}})},UPDATE(e,r){return t.put(`/diller/${e}`,r)},SEARCH(e){return t.get(`/diller?filter[name]=${e}`,{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}})}};export{n as D};
