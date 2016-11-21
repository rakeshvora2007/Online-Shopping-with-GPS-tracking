<%@page import="java.util.Date"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>

<%
String name=(String) request.getAttribute("name");
String names=(String) session.getAttribute("name");
%>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="vijays_shop.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
        <script type="text/javascript" src="js/jquery-1.11.2.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <title>JSP Page</title>
    </head>
    <body>

        <script type="text/javascript">
            function form_validation(){
            var name=document.Login_Form.login_name.value;
            var password=document.Login_Form.login_password.value;
            var flag = true;             
            if(name==""){
                document.getElementById("invalid_login").style.color="red";
                document.getElementById('invalid_login').innerHTML="UserName is mandatory!";
                flag = false;
            }             
            if(password==""){
                document.getElementById("invalid_login").style.color="red";
                document.getElementById('invalid_login').innerHTML="Password is mandatory!";
                flag = false;
            }    
            return flag;
            }
        </script>
        <div class="row">
            <div class="col-lg-12">
                <img style="width: 70%;" src="Images/logo.jpg" />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 bg-white box-shadow-common round-border10">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2  class="text-center">Welcome Customer</h2>
                    <h4 style="line-height: 25px;">Welcome to Online Shopping Portal. We have just started our operations and trying our best to provide
                    Real-time tracking of product delivery. </h4>

                    <br /><br />
                    <h4 style="line-height: 25px;">Currently we provide products in the following categories. Soon we will be up with 100s of categories of products.</h4>
                    <div class="form-group col-lg-4 col-lg-offset-4">
                        <select class="form-control" name="Item">
                            <option> Books </option>
                            <option> Electronics </option>
                            <option> House Hold Stuffs</option>
                        </select>
                    </div>
                    <br />
                </div>
            </div>
            
        </div>
        <!--div id="date">  Current Time =  <%=new Date() %> </div-->
        <div id="invalid_login"> </div>
        <% String authentication = (String) session.getAttribute("authentication");            
            if (authentication == null) {
        %>                
        <div style="position: absolute; right: 0px; top: 0px; background: #5bc0de; padding: 20px;" class="round-border5">
            <h3>Login</h3>
            <form name="Login_Form" action="Controller" method="Post">
                <div align="right">                       
                    <b>Username</b>    <input  type="text" class="form-control" maxlength="40" name="login_name"> &nbsp;&nbsp;
                    <b>Password</b>    <input type="password" class="form-control" maxlength="40" name="login_password">             
                    <input class="btn btn-sm btn-primary" type="submit" name="login_submit" value="Login" onclick="return form_validation()">             
                    <a class="btn btn-sm btn-danger" href="registration.jsp"> Register </a>
                </div>                    
            </form>
            <% }
                if (authentication != null) { if(authentication.equals("Auth_Success"))
                { // out.println("authentication = " + authentication);
            %>
            <form name="logout" action="Controller" method="Post">
                <div style="position: absolute; top:5px; right: 5px;" class="logmeout"> <input class="btn btn-primary btn-md" type="submit" name="signout" value=" Logout "> </div>
            </form>            
            <%} else { %>
            <div id="wrong_user"> <span style="color:red"> Username/Password is wrong! </span> </div>
              <form name="Login_Form" action="Controller" method="Post">
                <div id="login_in" align="right">                       
                    Username    <input  type="text" maxlength="40" name="login_name"> &nbsp;&nbsp;
                    Password    <input type="password" maxlength="40" name="login_password">             
                    <input type="submit" name="login_submit" value="Submit" onclick="return form_validation()">             
                    <a href="registration.jsp"> Register </a>
                </div>                    
            </form>
          
            <%}}%>

        </div>  
        
            
            <center>
                <div id="footer1" class="col-lg-8 col-lg-offset-2 text-center"> Copyright &copy; Abdul Hafeez 2015  </div>
            </center>
        </div>
    </body>
</html>
