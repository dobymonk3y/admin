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
            }else{
                return true;
            }
        }catch(err){
            alert(err);
        }
    }
    function hide(){
        document.getElementById("namenotice").style.display ="none";
        document.getElementById("timenotice").style.display ="none";
        return;
    }
</script>
