{{--layui模块JS--}}

{!! Html::script('layui/layui.js') !!}
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate
    });

    function searchLog(){
        try{
            var username = document.getElementById('username').value;
            var timestart = document.getElementById('timestart').value;
            var timeend = document.getElementById('timeend').value;
            if(username == ''){
                if(timestart == '' && timeend == ''){
                    document.getElementById("namenotice").style.display ="block";
                    setTimeout( " hide() " , 3000 );
                    return false;
                }
                if(timestart == '' || timeend == ''){
                    document.getElementById("timenotice").style.display ="block";
                    setTimeout( " hide() " , 3000 );
                    return false;
                }
            }
            if(username != ''){
                if(timestart == '' || timeend == ''){
                    document.getElementById("timenotice").style.display ="block";
                    setTimeout( " hide() " , 3000 );
                    return false;
                }
            }
            return true;
        }catch(err){
            alert(err);
        }
    }
    function hide(){
        document.getElementById("namenotice").style.display ="none";
        document.getElementById("timenotice").style.display ="none";
        return;
    }
    function autohide(){
        document.getElementById("loginsEmpty").style.display ="none";
        document.getElementById("processEmpty").style.display ="none";
        document.getElementById("personnelAddError").style.display ="none";
        document.getElementById("personnelAddFaild").style.display ="none";
        document.getElementById("personnelAddSuccess").style.display ="none";
    }
    function personnelCheck(){
            var realname = document.getElementById('realname').value;
            var name = document.getElementById('name').value;
            var password = document.getElementById('password').value;
            var confirmpassword = document.getElementById('confirmpassword').value;
            var position = document.getElementById('position').value;
            if(realname =='' || name =='' || password =='' || confirmpassword ==''){
                alert('所有项目均为必填项, 不能留空!!');
                return false;
            }
            if(password != confirmpassword){
                alert('两次输入的密码不一致, 请重新确认!');
                return false;
            }
            if(position == ''){
                alert('请选择要填加的职位!');
                return false;
            }
            return true;
    }
    function updateCheck(){
        var realname = document.getElementById('realname').value;
        if(realname ==''){
            alert('用户真实姓名不能为空, 请填写使用者姓名!');
            return false;
        }
        return true;
    }
    function passwordCheck(){
        var newpassword = document.getElementById('newpassword').value.trim();
        var password = document.getElementById('password').value;
        var confirmpassword = document.getElementById('confirmpassword').value;
        if(newpassword =='' || password =='' || confirmpassword ==''){
            alert('所有项目均为必填项, 不能留空!!');
            return false;
        }
        if(newpassword.length <6){
            alert('请输入至少6位长度的密码!');
            return false;
        }
        if(newpassword != confirmpassword){
            alert('两次输入的密码不一致, 请重新确认!');
            return false;
        }
    }
    //去除前后空格
    String.prototype.trim=function() {
        return this.replace(/(^\s*)|(\s*$)/g,'');
    }

    //3秒后自动调用 hideloginlog div
    window.onload=setTimeout( " autohide() " , 3000 );
</script>
