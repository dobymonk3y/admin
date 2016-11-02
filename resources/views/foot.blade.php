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

    //3秒后自动调用 hideloginlog div
    window.onload=setTimeout( " autohide() " , 3000 );
</script>
