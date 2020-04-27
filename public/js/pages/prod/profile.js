!function(t){var i={};function s(o){if(i[o])return i[o].exports;var e=i[o]={i:o,l:!1,exports:{}};return t[o].call(e.exports,e,e.exports,s),e.l=!0,e.exports}s.m=t,s.c=i,s.d=function(t,i,o){s.o(t,i)||Object.defineProperty(t,i,{configurable:!1,enumerable:!0,get:o})},s.n=function(t){var i=t&&t.__esModule?function(){return t.default}:function(){return t};return s.d(i,"a",i),i},s.o=function(t,i){return Object.prototype.hasOwnProperty.call(t,i)},s.p="/",s(s.s=0)}([function(t,i,s){t.exports=s(1)},function(t,i){new Vue({el:"#app",data:{message:"only text",limit:5,offset:0,posts:[],recordCount:1,isProcessing:!0,isPosting:!1,data:{brand:"",tags:"",category:"",price:"",address:"",keyword:"",limit:5,offset:0,user_id:0,page:"",tab:""},post:{title:"",description:"",type:"text",video:"",photo:"",fd:"",ownerMore:"",more:""},typed:{address:"",keyword:""},interval:0,shops:[],url:window.url,count:1,errors:{},value:"no value",videoEmbedded:"",videoExist:!0,readingVideo:!1,video:"",isInteracting:!1,videoFaileMessage:"",profile:{about:""},aboutEditing:!1,isSavingAbout:!1,isProfilePictureUploading:!1,isProfileLoading:!1,isProfileSideBarReady:!1},mounted:function(){this.loadMore(),this.profileLoad();var t=window.search,i=window.request_user_id,s=window.tab;s&&(this.data.tab=s),t&&(this.data.keyword=t),i&&(this.data.request_user_id=i)},methods:{fileOpen:function(){$("#imgInp").trigger("click")},aboutOpen:function(){this.aboutEditing=!0},aboutClose:function(){this.aboutEditing=!1},aboutSubmit:function(){this.isSavingAbout=!0,this.errors=[];var t=this.url+"/api/profile/update/about",i=this.profile;axios.post(t,i).then(function(t){this.isSavingAbout=!1,this.aboutEditing=!1}.bind(this)).catch(function(t){this.isSavingAbout=!1,422===t.response.status&&(this.errors=t.response.data.errors)}.bind(this))},profileLoad:function(){this.isProfileLoading=!0;var t=this.url+"/api/profile/load";axios.post(t,this.data).then(function(t){this.isProfileSideBarReady=!0,this.isProfileLoading=!1;var i=t.data.data.profile;this.profile=i,$("#imgInp").val("")}.bind(this)).catch(function(t){this.isProfileLoading=!1,422===t.response.status&&(this.errors=t.response.data.errors)}.bind(this))},updatePhoto:function(t){this.isProfilePictureUploading=!0,this.errors=[];var i=this.url+"/api/profile/update/photo",s=t.target.files[0],o=new FormData;o.append("photo",s,s.name),data=o,axios.post(i,data).then(function(t){this.isProfilePictureUploading=!1;var i=t.data.data.profile;this.profile=i}.bind(this)).catch(function(t){this.isChangeProfile=!0,this.isPostingImage=!1,this.isProfilePictureUploading=!1,422===t.response.status&&(this.errors=t.response.data.errors)}.bind(this))},postOpenFile:function(){$("#post-file-upload").trigger("click")},postType:function(t){this.post.type=t,this.errors=[],"photo"==t||"video"==t?$("#post-description").attr("placeholder","Bless everyone with your positive words (optional)"):$("#post-description").attr("placeholder","Bless everyone with your positive words (required)")},onFileSelected:function(t){this.errors=[],this.post.photo=t.target.files[0],document.getElementById("post-preview-photo").src=URL.createObjectURL(t.target.files[0])},interaction:function(t,i,s){this.isInteracting=!0;var o=this.url+"/api/post/"+t.id+"/interaction";"save"==s?1==this.posts[i].is_saved_by_auth_count?(this.posts[i].is_saved_by_auth_count=0,this.posts[i].post_saved_count--):(this.posts[i].is_saved_by_auth_count=1,this.posts[i].post_saved_count++):"inspire"==s&&(1==this.posts[i].is_inspired_by_auth_count?(this.posts[i].is_inspired_by_auth_count=0,this.posts[i].post_inspired_count--):(this.posts[i].is_inspired_by_auth_count=1,this.posts[i].post_inspired_count++));var e={post:t,action:s};axios.post(o,e)},postSubmit:function(){this.isPosting=!0;var t=this.url+"/api/post/store";this.errors=[];var i={};if(null!=this.post.photo&&"photo"==this.post.type){var s=new FormData;s.append("photo",this.post.photo,this.post.photo.name),s.append("title",this.post.title),s.append("description",this.post.description),s.append("type",this.post.type),s.append("video",this.post.video),i=s}else"video"==this.post.type?(this.videoExist=!0,this.readingVideo=!1,i=this.post):i=this.post;axios.post(t,i).then(function(t){this.isPosting=!1;var i=t.data.data.post,s=this.posts;s.unshift(i),this.recordCount=s.length,this.posts=s,this.post.description="",this.post.title="",this.post.video="",this.post.photo="",$("#post-preview-photo").attr("src",this.url+"/img/default.png"),$("#imgInp").val("")}.bind(this)).catch(function(t){this.isChangeProfile=!1,this.isPostingImage=!0,this.isPosting=!1,422===t.response.status&&(this.errors=t.response.data.errors)}.bind(this))},loadMore:function(){if(this.recordCount>0){this.isProcessing=!0;var t=this.url+"/api/post/search";this.data.page="profile",axios.post(t,this.data).then(function(t){var i=this,s=this.data.tab;this.isProcessing=!1;var o=t.data.offset,e=t.data.data.posts,n=t.data.count;this.count=n,this.data.offset=o,this.recordCount=e.length,e.forEach(function(t){"saved"!=s&&"inspired"!=s||(t=t.post),i.posts.push(t)})}.bind(this)).catch(function(t){this.isProcessing=!1})}},editOpen:function(t,i){this.posts[t].edit=!0},editClose:function(t,i){this.posts[t].edit=!1},moreOpen:function(t,i){this.isProcessing=!0;this.url,i.id},moreClose:function(t,i){this.posts[t].more=!1},editSubmit:function(t,i){this.isProcessing=!0;var s=this.url+"/api/post/"+i.id+"/update";this.posts[t].isProcessingUpdate=!0,axios.post(s,i).then(function(i){this.posts[t].isProcessingUpdate=!1,this.isProcessing=!1;var s=i.data.data.post;this.posts[t].title=s.title,this.posts[t].description=s.description,this.posts[t].edit=!1}.bind(this)).catch(function(i){this.posts[t].isProcessingUpdate=!1,422===i.response.status&&(this.posts[t].error=i.response.data.errors)}.bind(this))},deleteSubmit:function(t,i){if(confirm("Are you sure to delete this post?")){this.isProcessing=!0;var s=this.url+"/api/post/"+i.id+"/delete";axios.post(s,i).then(function(i){this.isProcessing=!1;i.data.data.post;this.posts.splice(t,1)}.bind(this)).catch(function(t){})}}},watch:{"post.video":function(t,i){var s={video:t},o=this.url+"/api/post/video/preview";null!=t&&t.length>10&&(this.errors=[],this.isPosting=!0,axios.post(o,s).then(function(t){var i=t.data.data.video_embedded,s=t.data.data.video_exist;this.videoEmbedded=i,this.videoExist=s,this.readingVideo=!0,this.isPosting=!1}.bind(this)))}},filters:{truncate:function(t,i,s){s=s||"...";var o=document.createElement("div");o.innerHTML=t;var e=o.textContent;return e.length>i?e.slice(0,i)+s:e},textMore:function(t,i){var s=document.createElement("div");s.innerHTML=t;var o=s.textContent;return o.length>length?o.slice(0,i):o},textLess:function(t,i){var s=document.createElement("div");s.innerHTML=t;var o=s.textContent;return o.length>length?o.slice(i,o.length):""},hasMore:function(t){}}})}]);