var AlertMsg = new function(){
  this.type = 'info';
  this.duration = 3000;
  this.timeout = null;
  this.msg = "";

  this.showAlert = function(){
    this.el = document.getElementById("alertBoxLower");
    if(!this.el){
      this.el = document.createElement("div");
      this.el.setAttribute("id","alertBoxLower");
      document.body.appendChild(this.el);
    }
    this.el.innerHTML = this.msg;
    this.el.classList.remove('info','warning','success','danger','primary','secondary','light','dark');
    if(this.timeout){
      this.timeout = clearTimeout(this.timeout);
    }
    var that = this;
    setTimeout(function(){
      that.el.classList.add(that.type,"show");
    },0);
    this.timeout = setTimeout(function(){
      that.el.classList.remove("show");
      that.timeout = null;
    },this.duration);
  }
}

function alertMsg(msg,type,duration){
  AlertMsg.msg = msg;
  AlertMsg.duration = (typeof duration !== 'undefined')? duration : 3000;
  AlertMsg.type = (typeof type !== 'undefined')? type : 'info';
  AlertMsg.showAlert();
}
