

<%@page contentType="text/html" pageEncoding="UTF-8"%>
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
        <style type="text/css">
            #big_wrapper{
                text-align: center;
                background-color: sienna;
                color:white;
            }
            #link.active{
                color:white;
            }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="col-lg-12">
                <img style="width: 70%;" src="Images/logo.jpg" />
            </div>
        </div>
        
        <form action="Controller" method="Post">                   
            <div style="position: absolute; top:5px; right: 5px;" class="logmeout"> <input class="btn btn-primary btn-md" type="submit" name="signout" value=" Logout "> </div>
        </form>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4">
                <% String Confirmation = (String) session.getAttribute("Order_Confirmation");
                if (Confirmation == null) {
                %>

                <form action="Controller" method="Post">                   
            
                    <legend>Payment Information</legend>
                    <div class="form-group">
                        <label>Card Type</label>
                        <select class="form-control" name="card_type">
                            <option> American Express </option>   
                            <option> Citi Bank </option>   
                            <option> Disover </option>   
                            <option> Bank of America </option>   
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Card Number</label>
                        <input class="form-control" type="text" value="" maxlength="16" name="card_number" />
                    </div>

                    <div class="form-group">
                        <label>Name on Card</label>
                        <input class="form-control" type="text" value="" maxlength="20" name="card_name" />
                    </div>

                    <div class="form-group">
                        <div class="col-lg-6">
                            <label>Expiration Date</label>
                            <select class="form-control" name="expiration_month">
                                <option> 1 </option> <option> 2 </option> <option> 3 </option> <option> 4 </option>   
                                <option> 5 </option> <option> 6 </option> <option> 7 </option> <option> 8 </option>   
                                <option> 9 </option> <option> 10 </option> <option> 11 </option> <option> 12 </option>   
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label>Expiration Year</label>
                            <select class="form-control" name="expiration_year">
                                <option> 2013 </option>   
                                <option> 2014 </option>   
                                <option> 2015 </option>   
                                <option> 2016 </option>   
                            </select>
                        </div>
                    </div>

                    <legend>Billing Information</legend>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input class="form-control" type="text" value="" name="fullname" />
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input class="form-control" type="text" value="" name="address" />
                    </div>

                    <div class="form-group">
                        <label>Country</label>
                        <input class="form-control" type="text" value="" name="country" />
                    </div>

                    <div class="form-group">
                        <label>Zip</label>
                        <input class="form-control" type="text" value="" name="zipcode" />
                    </div>

                    <div class="form-group">
                        <input class="form-control btn btn-primary" type="submit" name="place_order" Value="Make Payment" /> 
                    </div>
                <% }  // ending billing n payment info %>
                <%
                    if (Confirmation != null) {
                %>

                <!--div class="logmeout"> <input type="submit" name="signout" value=" Logout "> </div-->

                <h1> Order Has been submitted!! Look out for your product!!!  <br /> <br /> <br /> 
                    Thank you for ordering at Vijay's Shopss </h1>  <br /> <br /> <br /> <br /> <br />
                <div id="link">    <h2> <a href="index.jsp"> Shop Again! </a> </h2> </div>
                <% }%>

            </form> 
            </div>
        </div>
        <div id="big_wrapper">

                  
        </div>
    </body>
</html>
